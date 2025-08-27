<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAccessCode;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamAssignmentController extends Controller
{
    /**
     * Show the exam assignment page
     */
    public function index(Exam $exam)
    {
        $exam->load(['assignedStudents', 'accessCodes.student']);
        
        $availableStudents = Student::where('partner_id', auth()->user()->role_id)
            ->where('status', 'active')
            ->whereNotIn('id', $exam->assignedStudents->pluck('id'))
            ->get();

        return view('partner.exams.assign', compact('exam', 'availableStudents'));
    }

    /**
     * Assign students to exam
     */
    public function assignStudents(Request $request, Exam $exam)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $studentIds = $request->student_ids;
        $assignedCount = 0;

        DB::transaction(function () use ($exam, $studentIds, &$assignedCount) {
            foreach ($studentIds as $studentId) {
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
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $assignment = ExamAccessCode::where('exam_id', $exam->id)
            ->where('student_id', $request->student_id)
            ->first();

        if ($assignment) {
            $assignment->delete();
            return back()->with('success', 'Student assignment removed successfully.');
        }

        return back()->withErrors(['error' => 'Assignment not found.']);
    }

    /**
     * Regenerate access code for a student
     */
    public function regenerateCode(Request $request, Exam $exam)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

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

            return back()->with('success', 'Access code regenerated successfully.');
        }

        return back()->withErrors(['error' => 'Assignment not found.']);
    }

    /**
     * Bulk operations
     */
    public function bulkOperations(Request $request, Exam $exam)
    {
        $request->validate([
            'action' => 'required|in:assign,remove,regenerate',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $action = $request->action;
        $studentIds = $request->student_ids;
        $count = 0;

        switch ($action) {
            case 'assign':
                $count = $this->bulkAssign($exam, $studentIds);
                $message = "Successfully assigned {$count} students to the exam.";
                break;
                
            case 'remove':
                $count = $this->bulkRemove($exam, $studentIds);
                $message = "Successfully removed {$count} student assignments.";
                break;
                
            case 'regenerate':
                $count = $this->bulkRegenerate($exam, $studentIds);
                $message = "Successfully regenerated {$count} access codes.";
                break;
        }

        return back()->with('success', $message);
    }

    /**
     * Bulk assign students
     */
    private function bulkAssign(Exam $exam, array $studentIds)
    {
        $count = 0;
        
        DB::transaction(function () use ($exam, $studentIds, &$count) {
            foreach ($studentIds as $studentId) {
                $existingAssignment = ExamAccessCode::where('exam_id', $exam->id)
                    ->where('student_id', $studentId)
                    ->first();

                if (!$existingAssignment) {
                    $accessCode = ExamAccessCode::generateUniqueCode();
                    
                    ExamAccessCode::create([
                        'exam_id' => $exam->id,
                        'student_id' => $studentId,
                        'access_code' => $accessCode,
                        'status' => 'active',
                        'expires_at' => $exam->end_time,
                    ]);
                    
                    $count++;
                }
            }
        });

        return $count;
    }

    /**
     * Bulk remove assignments
     */
    private function bulkRemove(Exam $exam, array $studentIds)
    {
        return ExamAccessCode::where('exam_id', $exam->id)
            ->whereIn('student_id', $studentIds)
            ->delete();
    }

    /**
     * Bulk regenerate codes
     */
    private function bulkRegenerate(Exam $exam, array $studentIds)
    {
        $count = 0;
        
        $assignments = ExamAccessCode::where('exam_id', $exam->id)
            ->whereIn('student_id', $studentIds)
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
