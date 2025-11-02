<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAccessCode;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\HasPartnerContext;

class ExamAssignmentController extends Controller
{
    use HasPartnerContext;



    /**
     * Show the exam assignment page
     */
    public function index(Request $request, Exam $exam)
    {
        $exam->load(['assignedStudents.courses', 'accessCodes' => function($query) {
            $query->with(['student.courses'])->whereNotNull('student_id');
        }]);

        // Clean up any orphaned access codes (access codes with null student_id)
        ExamAccessCode::where('exam_id', $exam->id)
            ->whereNull('student_id')
            ->delete();
        
        // Get the authenticated user's partner ID
        $user = auth()->user();
        $partnerId = $user->partner_id ?? null;
        
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
        
        // Course filter - using the new enrollment system
        if ($request->filled('course_id') && $request->course_id !== 'all') {
            $query->whereHas('courses', function($q) use ($request) {
                $q->where('courses.id', $request->course_id);
            });
        }
        
        // Batch filter - using the new enrollment system
        if ($request->filled('batch_id') && $request->batch_id !== 'all') {
            $query->whereHas('courses', function($q) use ($request) {
                $q->where('course_batch_enrollments.batch_id', $request->batch_id);
            });
        }
        
        // Gender filter
        if ($request->filled('gender') && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }
        
        $availableStudents = $query->with(['courses'])->paginate(30)->appends($request->except('page'));
        
        // Get filter options
        $courses = \App\Models\Course::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
        $batches = \App\Models\Batch::where('partner_id', $partnerId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

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
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:students,id',
        ], [
            'student_ids.required' => 'Please select at least one student to assign.',
            'student_ids.array' => 'Student selection must be an array.',
            'student_ids.min' => 'Please select at least one student to assign.',
            'student_ids.*.exists' => 'One or more selected students are invalid.',
        ]);

        $studentIds = $request->student_ids;
        
        // Additional check to ensure student_ids is not empty
        if (empty($studentIds)) {
            return back()->with('error', 'Please select at least one student to assign.');
        }
        
        $assignedCount = 0;

        // ✅ Validate that all students belong to current partner
        $validStudentIds = \App\Models\Student::where('partner_id', $partnerId)
            ->whereIn('id', $studentIds)
            ->pluck('id')
            ->toArray();

        if (count($validStudentIds) !== count($studentIds)) {
            // Find which students don't belong to the partner
            $invalidStudentIds = array_diff($studentIds, $validStudentIds);
            $invalidStudents = \App\Models\Student::whereIn('id', $invalidStudentIds)->get();
            
            $invalidStudentNames = $invalidStudents->pluck('full_name')->implode(', ');
            
            return back()->with('error', "Some students do not belong to your institution: {$invalidStudentNames}");
        }
        
        // ✅ Check if any of the students are already assigned to this exam
        $alreadyAssignedStudentIds = ExamAccessCode::where('exam_id', $exam->id)
            ->whereIn('student_id', $validStudentIds)
            ->pluck('student_id')
            ->toArray();
            
        if (!empty($alreadyAssignedStudentIds)) {
            $alreadyAssignedStudents = \App\Models\Student::whereIn('id', $alreadyAssignedStudentIds)->get();
            $alreadyAssignedStudentNames = $alreadyAssignedStudents->pluck('full_name')->implode(', ');
            
            return back()->with('error', "Some students are already assigned to this exam: {$alreadyAssignedStudentNames}");
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
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized access to this exam.'], 403);
            }
            return redirect()->back()->withErrors(['error' => 'Unauthorized access to this exam.']);
        }

        $request->validate([
            'assignment_id' => 'required|exists:exam_access_codes,id',
        ]);

        $assignment = ExamAccessCode::where('id', $request->assignment_id)
            ->where('exam_id', $exam->id)
            ->with('student')
            ->first();

        if (!$assignment) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Assignment not found or access denied.'], 404);
            }
            return redirect()->back()->withErrors(['error' => 'Assignment not found or access denied.']);
        }

        // Handle case where student is null (orphaned access code)
        if (!$assignment->student) {
            // Delete the orphaned access code
            $assignment->delete();
            
            // Handle both AJAX and regular form submissions
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Orphaned assignment removed successfully.']);
            }
            
            return redirect()->back()->with('success', 'Orphaned assignment removed successfully.');
        }

        // ✅ Ensure the assignment belongs to a student from current partner
        if ($assignment->student->partner_id !== $partnerId) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Student not found or access denied.'], 404);
            }
            return redirect()->back()->withErrors(['error' => 'Student not found or access denied.']);
        }

        $assignment->delete();
        
        // Handle both AJAX and regular form submissions
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Student assignment removed successfully.']);
        }
        
        return redirect()->back()->with('success', 'Student assignment removed successfully.');
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
            return back()->with('error', 'Unauthorized access to this exam.');
        }

        $request->validate([
            'action' => 'required|in:remove,regenerate',
            'assignment_ids' => 'required|array',
            'assignment_ids.*' => 'exists:exam_access_codes,id',
        ]);

        $action = $request->action;
        $assignmentIds = $request->assignment_ids;
        $count = 0;
        $message = '';

        switch ($action) {
            case 'remove':
                $count = $this->bulkRemove($exam, $assignmentIds);
                $message = "Successfully removed {$count} student assignments.";
                break;

            case 'regenerate':
                $count = $this->bulkRegenerate($exam, $assignmentIds);
                $message = "Successfully regenerated {$count} access codes.";
                break;
        }

        return back()->with('success', $message);
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
            ]);
            $count++;
        }

        return $count;
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
