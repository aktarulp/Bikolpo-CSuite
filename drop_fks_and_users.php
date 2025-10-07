use Illuminate\Support\Facades\Schema;

Schema::table('ac_role_permissions', function ($table) { $table->dropForeign('role_permissions_granted_by_foreign'); });
Schema::table('exam_results', function ($table) { $table->dropForeign('student_exam_results_created_by_foreign'); });
Schema::table('exams', function ($table) { $table->dropForeign('exams_created_by_foreign'); });
Schema::table('question_history', function ($table) { $table->dropForeign('question_history_created_by_foreign'); });
Schema::dropIfExists('users');