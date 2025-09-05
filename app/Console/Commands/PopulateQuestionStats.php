<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExamResult;
use App\Models\QuestionStat;

class PopulateQuestionStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analytics:populate-question-stats {--exam-id= : Specific exam ID to process} {--dry-run : Show what would be done without actually doing it}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate question statistics for existing exam results';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $examId = $this->option('exam-id');
        $dryRun = $this->option('dry-run');

        $this->info('Starting to populate question statistics...');

        // Get exam results to process
        $query = ExamResult::where('status', 'completed')
            ->whereNotNull('answers')
            ->with(['exam.questions']);

        if ($examId) {
            $query->where('exam_id', $examId);
        }

        $examResults = $query->get();

        if ($examResults->isEmpty()) {
            $this->warn('No completed exam results found to process.');
            return;
        }

        $this->info("Found {$examResults->count()} exam results to process.");

        $bar = $this->output->createProgressBar($examResults->count());
        $bar->start();

        $processed = 0;
        $skipped = 0;

        foreach ($examResults as $result) {
            // Check if question stats already exist for this result
            $existingStats = QuestionStat::where('exam_result_id', $result->id)->count();
            
            if ($existingStats > 0) {
                $skipped++;
                $bar->advance();
                continue;
            }

            if (!$dryRun) {
                $this->processExamResult($result);
            }
            
            $processed++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        if ($dryRun) {
            $this->info("Dry run completed. Would process {$processed} exam results and skip {$skipped}.");
        } else {
            $this->info("Completed! Processed {$processed} exam results and skipped {$skipped}.");
        }
    }

    /**
     * Process a single exam result
     */
    private function processExamResult(ExamResult $result)
    {
        $answers = $result->answers ?? [];
        $questions = $result->exam->questions()->orderBy('pivot_order')->get();

        foreach ($questions as $question) {
            $questionId = $question->id;
            $studentAnswer = $answers[$questionId] ?? null;

            // Determine if the answer is correct, wrong, or unanswered
            $isAnswered = !empty($studentAnswer);
            $isCorrect = false;
            $isSkipped = false;
            $answerMetadata = null;

            if ($studentAnswer === null || $studentAnswer === '') {
                $isSkipped = true;
            } else {
                if ($question->question_type === 'mcq') {
                    if ($studentAnswer === $question->correct_answer) {
                        $isCorrect = true;
                    }
                } else {
                    // For descriptive questions, check word count
                    $wordCount = str_word_count($studentAnswer);
                    $minWords = $question->min_words ?? 10;
                    $maxWords = $question->max_words ?? 100;
                    
                    $answerMetadata = [
                        'word_count' => $wordCount,
                        'min_words_required' => $minWords,
                        'max_words_expected' => $maxWords,
                    ];
                    
                    if ($wordCount >= $minWords) {
                        $isCorrect = true;
                    }
                }
            }

            // Create question statistic record
            QuestionStat::create([
                'question_id' => $questionId,
                'exam_id' => $result->exam_id,
                'student_id' => $result->student_id,
                'exam_result_id' => $result->id,
                'student_answer' => $studentAnswer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect,
                'is_answered' => $isAnswered,
                'is_skipped' => $isSkipped,
                'question_order' => $question->pivot->order ?? 0,
                'marks' => $question->pivot->marks ?? 1,
                'question_type' => $question->question_type,
                'answer_metadata' => $answerMetadata,
                'question_answered_at' => $result->completed_at,
                'created_at' => $result->created_at,
                'updated_at' => $result->updated_at,
            ]);
        }
    }
}