use Illuminate\Support\Facades\DB;

$foreignKeys = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'question_history' AND COLUMN_NAME = 'created_by' AND REFERENCED_TABLE_NAME = 'users'");

file_put_contents('temp_fk_output.txt', var_export($foreignKeys, true));