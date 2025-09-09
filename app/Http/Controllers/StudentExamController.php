<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Student;
use App\Models\ExamAccessCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentExamController extends Controller
{
    public function availableExams()
    {
        $studentId = 1; // Default student ID
        
        $availableExams = Exam::where('status', 'published')
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            // ->with('questionSet')
            ->get();

        return view('student.exams.available', compact('availableExams'));
    }

    public function showExam(Exam $exam)
    {
        $studentId = 1; // Default student ID
        
        // Check if student has already taken this exam
        $existingResult = ExamResult::where('student_id', $studentId)
            ->where('exam_id', $exam->id)
            ->first();

        if ($existingResult && !$exam->allow_retake) {
            return redirect()->route('student.exams.result', $exam)
                ->with('error', 'You have already taken this exam.');
        }

        return view('student.exams.show', compact('exam'));
    }

    public function startExam(Exam $exam)
    {
        $studentId = 1; // Default student ID
        
        // Check if exam is available
        if ($exam->status !== 'published' || now() < $exam->start_time || now() > $exam->end_time) {
            return redirect()->route('student.exams.available')
                ->with('error', 'This exam is not available at this time.');
        }

        // Check if student has already taken this exam
        $existingResult = ExamResult::where('student_id', $studentId)
            ->where('exam_id', $exam->id)
            ->where('status', 'completed')
            ->first();

        if ($existingResult && !$exam->allow_retake) {
            return redirect()->route('student.exams.result', $exam)
                ->with('error', 'You have already completed this exam.');
        }

        // Create or get existing result
        $result = ExamResult::firstOrCreate([
            'student_id' => $studentId,
            'exam_id' => $exam->id,
        ], [
            'started_at' => now(),
            'total_questions' => $exam->total_questions ?? 0,
            'status' => 'in_progress',
        ]);

        // $questions = $exam->questionSet->questions()->orderBy('pivot_order')->get();
        $questions = collect(); // Empty collection for now

        return view('student.exams.start', compact('exam', 'questions', 'result'));
    }

    public function takeExam(Exam $exam)
    {
        $studentId = 1; // Default student ID
        
        // Check if exam is available
        if (!$exam->isActive) {
            return redirect()->route('student.exams.available')
                ->with('error', 'This exam is not available at this time.');
        }

        // Get existing result
        $result = ExamResult::where('student_id', $studentId)
            ->where('exam_id', $exam->id)
            ->where('status', 'in_progress')
            ->first();

        if (!$result) {
            return redirect()->route('student.exams.start', $exam)
                ->with('error', 'Please start the exam first.');
        }

        // $questions = $exam->questionSet->questions()->orderBy('pivot_order')->get();
        $questions = collect(); // Empty collection for now

        return view('student.exams.take', compact('exam', 'questions', 'result'));
    }

    public function submitExam(Request $request, Exam $exam)
    {
        $studentId = 1; // Default student ID
        
        $result = ExamResult::where('student_id', $studentId)
            ->where('exam_id', $exam->id)
            ->where('status', 'in_progress')
            ->firstOrFail();

        $answers = $request->input('answers', []);
        
        // Use the same scoring logic as PublicQuizController
        $scoreData = $this->calculateScore($exam, $answers, $studentId, $result->id);
        
        // Apply negative marking if enabled
        if ($exam->has_negative_marking && $scoreData['wrong_answers'] > 0) {
            $deduction = $scoreData['wrong_answers'] * $exam->negative_marks_per_question;
            $scoreData['score'] -= $deduction;
            $scoreData['percentage'] = $scoreData['total_marks'] > 0 ? ($scoreData['score'] / $scoreData['total_marks']) * 100 : 0;
        }

        $result->update([
            'completed_at' => now(),
            'correct_answers' => $scoreData['correct_answers'],
            'wrong_answers' => $scoreData['wrong_answers'],
            'unanswered' => $scoreData['unanswered'],
            'score' => $scoreData['score'],
            'percentage' => $scoreData['percentage'],
            'status' => 'completed',
            'answers' => $answers,
        ]);

        return redirect()->route('student.exams.result', $exam)
            ->with('success', 'Exam submitted successfully!');
    }

    /**
     * Calculate quiz score and record individual question statistics
     */
    private function calculateScore(Exam $exam, array $answers, $studentId, $examResultId)
    {
        $score = 0;
        $correctAnswers = 0;
        $wrongAnswers = 0;
        $unanswered = 0;
        $totalMarks = 0;
        
        $questions = $exam->questions()->orderBy('pivot_order')->get();

        foreach ($questions as $question) {
            $questionId = $question->id;
            $studentAnswer = $answers[$questionId] ?? null;
            $questionMarks = $question->pivot->marks ?? 1;
            $totalMarks += $questionMarks;

            // Determine if the answer is correct, wrong, or unanswered
            $isAnswered = !empty($studentAnswer);
            $isCorrect = false;
            $isSkipped = false;
            $answerMetadata = null;

            if ($studentAnswer === null || $studentAnswer === '') {
                $unanswered++;
                $isSkipped = true;
            } else {
                if ($question->question_type === 'mcq') {
                    if ($studentAnswer === $question->correct_answer) {
                        $score += $questionMarks;
                        $correctAnswers++;
                        $isCorrect = true;
                    } else {
                        $wrongAnswers++;
                        // Apply negative marking for wrong answers if enabled
                        if ($exam->has_negative_marking) {
                            $negativeMarks = $exam->negative_marks_per_question ?? 0;
                            $score -= $negativeMarks;
                        }
                    }
                } else {
                    // For descriptive questions, give partial marks based on word count
                    $wordCount = str_word_count($studentAnswer);
                    $minWords = $question->min_words ?? 10;
                    $maxWords = $question->max_words ?? 100;
                    
                    $answerMetadata = [
                        'word_count' => $wordCount,
                        'min_words_required' => $minWords,
                        'max_words_expected' => $maxWords,
                    ];
                    
                    if ($wordCount >= $minWords) {
                        $partialScore = $questionMarks * min(1, $wordCount / $maxWords);
                        $score += $partialScore;
                        $correctAnswers++; // Count as correct if meets minimum word requirement
                        $isCorrect = true;
                    } else {
                        $wrongAnswers++;
                        // Apply negative marking for descriptive questions that don't meet word requirements
                        if ($exam->has_negative_marking) {
                            $negativeMarks = $exam->negative_marks_per_question ?? 0;
                            $score -= $negativeMarks;
                        }
                    }
                }
            }

            // Record individual question statistics
            \App\Models\QuestionStat::create([
                'question_id' => $questionId,
                'exam_id' => $exam->id,
                'student_id' => $studentId,
                'exam_result_id' => $examResultId,
                'student_answer' => $studentAnswer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect,
                'is_answered' => $isAnswered,
                'is_skipped' => $isSkipped,
                'question_order' => $question->pivot->order ?? 0,
                'marks' => $questionMarks,
                'question_type' => $question->question_type,
                'answer_metadata' => $answerMetadata,
                'question_answered_at' => now(),
            ]);
        }

        // Ensure score doesn't go below 0
        $score = max(0, $score);
        
        $percentage = $totalMarks > 0 ? ($score / $totalMarks) * 100 : 0;

        return [
            'score' => $score,
            'percentage' => $percentage,
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
            'unanswered' => $unanswered,
            'total_marks' => $totalMarks,
            'total_questions' => $questions->count(),
        ];
    }

    public function showResult(Exam $exam)
    {
        // Check if results should be shown immediately
        if (!$exam->show_results_immediately) {
            return redirect()->route('student.exams.available')
                ->with('info', 'Results are not available immediately. Please contact your instructor.');
        }

        $studentId = 1; // Default student ID
        
        $result = ExamResult::where('student_id', $studentId)
            ->where('exam_id', $exam->id)
            ->with(['student.partner', 'exam'])
            ->firstOrFail();

        $questions = $exam->questions()->orderBy('pivot_order')->get();

        return view('student.exams.result', compact('exam', 'result', 'questions'));
    }

    public function history()
    {
        $studentId = 1; // Default student ID
        
        $results = ExamResult::where('student_id', $studentId)
            ->with(['exam'])
            ->latest()
            ->paginate(15);

        return view('student.exams.history', compact('results'));
    }
}
