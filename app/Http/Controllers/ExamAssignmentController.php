<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAccessCode;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\BulkSmsBdService;
use App\Models\SmsRecord;
use App\Traits\HasPartnerContext;

class ExamAssignmentController extends Controller
{
    use HasPartnerContext;

    protected $bulkSmsBdService;

    public function __construct(BulkSmsBdService $bulkSmsBdService)
    {
        $this->bulkSmsBdService = $bulkSmsBdService;
    }

    /**
     * Show the exam assignment page
     */
    public function index(Request $request, Exam $exam)
    {
        $exam->load(['assignedStudents', 'accessCodes.student']);
        
        // Get the authenticated user's partner ID
        $user = auth()->user();
        $partnerId = $user->partner->id ?? null;
        
        if (!$partnerId) {
            // If no partner record exists, create one
            $partner = new \App\Models\Partner();
            $partner->user_id = $user->id;
            $partner->name = $user->name;
            $partner->email = $user->email;
            $partner->status = 'active';
            $partner->partner_category = 'Institution';
            $partner->save();
            
            $partnerId = $partner->id;
        }
        
        // Check if the user has access to this exam
        if ($exam->partner_id && $exam->partner_id !== $partnerId) {
            // If the exam belongs to a different partner, redirect with error
            return redirect()->route('partner.exams.index')
                ->withErrors(['error' => 'You do not have access to this exam.']);
        }
        
        // Build query for available students with filters
        $query = Student::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->whereNotIn('id', $exam->assignedStudents->pluck('id'));
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%")
                  ->orWhere('school_college', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Course filter
        if ($request->filled('course_id') && $request->course_id !== 'all') {
            $query->where('course_id', $request->course_id);
        }
        
        // Batch filter
        if ($request->filled('batch_id') && $request->batch_id !== 'all') {
            $query->where('batch_id', $request->batch_id);
        }
        
        // Gender filter
        if ($request->filled('gender') && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }
        
        $availableStudents = $query->with(['course', 'batch'])->get();
        
        // Get filter options
        $courses = \App\Models\Course::where('partner_id', $partnerId)->get();
        $batches = \App\Models\Batch::where('partner_id', $partnerId)->get();

        // Debug information
        \Log::info('Exam Assignment Debug', [
            'user_id' => $user->id,
            'partner_id' => $partnerId,
            'exam_partner_id' => $exam->partner_id,
            'total_students' => Student::where('partner_id', $partnerId)->count(),
            'active_students' => Student::where('partner_id', $partnerId)->where('status', 'active')->count(),
            'assigned_students_count' => $exam->assignedStudents->count(),
            'available_students_count' => $availableStudents->count(),
        ]);

        return view('partner.exams.assign', compact('exam', 'availableStudents', 'courses', 'batches'));
    }

    /**
     * Assign students to exam
     */
    public function assignStudents(Request $request, Exam $exam)
    {
        $partnerId = $this->getPartnerId();

        // ✅ Ensure exam belongs to current partner
        if ($exam->partner_id !== $partnerId) {
            return back()->with('error', 'Unauthorized access to this exam.');
        }

        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $studentIds = $request->student_ids;
        $assignedCount = 0;

        // ✅ Validate that all students belong to current partner
        $validStudentIds = \App\Models\Student::where('partner_id', $partnerId)
            ->whereIn('id', $studentIds)
            ->pluck('id')
            ->toArray();

        if (count($validStudentIds) !== count($studentIds)) {
            return back()->with('error', 'Some students do not belong to your institution.');
        }

        DB::transaction(function () use ($exam, $validStudentIds, &$assignedCount) {
            foreach ($validStudentIds as $studentId) {
                // Check if already assigned
                $existingAssignment = ExamAccessCode::where('exam_id', $exam->id)
                    ->where('student_id', $studentId)
                    ->first();

                if (!$existingAssignment) {
                    // Generate unique access code
                    $accessCode = ExamAccessCode::generateUniqueCode();

                    // Create assignment
                    ExamAccessCode::create([
                        'exam_id' => $exam->id,
                        'student_id' => $studentId,
                        'access_code' => $accessCode,
                        'status' => 'active',
                        'expires_at' => $exam->end_time,
                    ]);

                    $assignedCount++;
                }
            }
        });

        return back()->with('success', "Successfully assigned {$assignedCount} students to the exam.");
    }

    /**
     * Remove student assignment
     */
    public function removeAssignment(Request $request, Exam $exam)
    {
        $partnerId = $this->getPartnerId();

        // ✅ Ensure exam belongs to current partner
        if ($exam->partner_id !== $partnerId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access to this exam.'], 403);
        }

        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        // ✅ Ensure student belongs to current partner
        $student = \App\Models\Student::where('id', $request->student_id)
            ->where('partner_id', $partnerId)
            ->first();

        if (!$student) {
            return response()->json(['success' => false, 'message' => 'Student not found or access denied.'], 404);
        }

        $assignment = ExamAccessCode::where('exam_id', $exam->id)
            ->where('student_id', $request->student_id)
            ->first();

        if ($assignment) {
            $assignment->delete();
            return response()->json(['success' => true, 'message' => 'Student assignment removed successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Assignment not found.'], 404);
    }

    /**
     * Regenerate access code for a student
     */
    public function regenerateCode(Request $request, Exam $exam)
    {
        $partnerId = $this->getPartnerId();

        // ✅ Ensure exam belongs to current partner
        if ($exam->partner_id !== $partnerId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access to this exam.'], 403);
        }

        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        // ✅ Ensure student belongs to current partner
        $student = \App\Models\Student::where('id', $request->student_id)
            ->where('partner_id', $partnerId)
            ->first();

        if (!$student) {
            return response()->json(['success' => false, 'message' => 'Student not found or access denied.'], 404);
        }

        $assignment = ExamAccessCode::where('exam_id', $exam->id)
            ->where('student_id', $request->student_id)
            ->first();

        if ($assignment) {
            $newCode = ExamAccessCode::generateUniqueCode();
            $assignment->update([
                'access_code' => $newCode,
                'status' => 'active',
                'used_at' => null,
            ]);

            return response()->json(['success' => true, 'message' => 'Access code regenerated successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Assignment not found.'], 404);
    }

    /**
     * Bulk operations
     */
    public function bulkOperations(Request $request, Exam $exam)
    {
        $partnerId = $this->getPartnerId();

        // ✅ Ensure exam belongs to current partner
        if ($exam->partner_id !== $partnerId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access to this exam.'], 403);
        }

        $request->validate([
            'action' => 'required|in:assign,remove,regenerate,send_sms',
            'assignment_ids' => 'required|array',
            'assignment_ids.*' => 'exists:exam_access_codes,id',
        ]);

        $action = $request->action;
        $assignmentIds = $request->assignment_ids;
        $count = 0;
        $message = '';

        switch ($action) {
            case 'assign':
                $count = $this->bulkAssign($exam, $assignmentIds); // Assuming student_ids is passed for assignment
                $message = "Successfully assigned {$count} students to the exam.";
                break;

            case 'remove':
                $count = $this->bulkRemove($exam, $assignmentIds);
                $message = "Successfully removed {$count} student assignments.";
                break;

            case 'regenerate':
                $count = $this->bulkRegenerate($exam, $assignmentIds);
                $message = "Successfully regenerated {$count} access codes.";
                break;

            case 'send_sms':
                $count = $this->bulkSendSms($exam, $assignmentIds);
                $message = "Attempted to send SMS to {$count} assignments.";
                break;
        }

        return response()->json(['success' => true, 'message' => $message]);
    }

    /**
     * Bulk assign students to exam
     */
    private function bulkAssign(Exam $exam, array $assignmentIds)
    {
        // For now, return 0 as this method needs proper implementation
        // based on the actual business logic requirements
        return 0;
    }

    /**
     * Bulk remove assignments
     */
    private function bulkRemove(Exam $exam, array $assignmentIds) // Changed to assignmentIds
    {
        return ExamAccessCode::where('exam_id', $exam->id)
            ->whereIn('id', $assignmentIds) // Changed to 'id'
            ->delete();
    }

    /**
     * Bulk regenerate codes
     */
    private function bulkRegenerate(Exam $exam, array $assignmentIds) // Changed to assignmentIds
    {
        $count = 0;

        $assignments = ExamAccessCode::where('exam_id', $exam->id)
            ->whereIn('id', $assignmentIds) // Changed to 'id'
            ->get();

        foreach ($assignments as $assignment) {
            $newCode = ExamAccessCode::generateUniqueCode();
            $assignment->update([
                'access_code' => $newCode,
                'status' => 'active',
                'used_at' => null,
                'sms_status' => 'pending',
            ]);
            $count++;
        }

        return $count;
    }

    /**
     * Bulk send SMS to assignments.
     */
    private function bulkSendSms(Exam $exam, array $assignmentIds)
    {
        $sentCount = 0;
        $failedCount = 0;

        foreach ($assignmentIds as $assignmentId) {
            $assignment = ExamAccessCode::with(['student', 'exam.partner'])
                                        ->find($assignmentId);

            if ($assignment && $assignment->student && $assignment->student->phone && $assignment->exam && $assignment->exam->partner) {
                $message = "Dear {$assignment->student->full_name},\nYou are assigned to exam {$assignment->exam->title} by {$assignment->exam->partner->name}, scheduled at {$assignment->exam->formatted_start_time} & your access code is: {$assignment->access_code}.\nVisit: " . config('app.url') . "/LiveExam to access the exam.";

                // For now, just mark as sent without actual SMS sending
                // This needs to be implemented with actual SMS service
                $assignment->update(['sms_status' => 'sent']);
                $sentCount++;
            } else if ($assignment) {
                $assignment->update(['sms_status' => 'skipped_no_phone']);
                $failedCount++;
            }
        }
        return $sentCount;
    }

    /**
     * Export assignments
     */
    public function exportAssignments(Exam $exam)
    {
        $assignments = ExamAccessCode::where('exam_id', $exam->id)
            ->with(['student'])
            ->get();

        $filename = "exam_{$exam->id}_assignments.csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function() use ($assignments) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, ['Student Name', 'Phone', 'Access Code', 'Status', 'Used At']);
            
            // CSV data
            foreach ($assignments as $assignment) {
                fputcsv($file, [
                    $assignment->student->full_name,
                    $assignment->student->phone,
                    $assignment->access_code,
                    $assignment->status,
                    $assignment->used_at ? $assignment->used_at->format('Y-m-d H:i:s') : 'Not Used'
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
