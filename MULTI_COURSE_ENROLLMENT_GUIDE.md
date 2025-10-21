# 🎓 Multi-Course Enrollment System - Implementation Guide

## 📋 Overview

This guide explains the **industry-standard many-to-many enrollment system** that allows students to enroll in multiple courses simultaneously.

### **What Changed?**

**Before (Old System):**
- ❌ One student → One course only
- ❌ Direct `course_id` foreign key in `students` table
- ❌ Limited enrollment tracking
- ❌ No enrollment history or status management

**After (New System):**
- ✅ One student → Multiple courses
- ✅ Dedicated `enrollments` pivot table
- ✅ Complete enrollment lifecycle management
- ✅ Enrollment history, status tracking, and analytics

---

## 🗂️ Database Structure

### **New `enrollments` Table**

| Column | Type | Description |
|--------|------|-------------|
| `id` | BIGINT | Primary key |
| `student_id` | BIGINT | Foreign key to students |
| `course_id` | BIGINT | Foreign key to courses |
| `batch_id` | BIGINT | Foreign key to batches (nullable) |
| `partner_id` | BIGINT | Foreign key to partners |
| `enrolled_at` | DATE | Enrollment date |
| `status` | ENUM | active, completed, dropped, suspended, transferred |
| `completion_date` | DATE | Date when course was completed (nullable) |
| `final_grade` | DECIMAL(5,2) | Final grade 0-100 (nullable) |
| `grade_letter` | VARCHAR(2) | A+, A, B+, etc. (nullable) |
| `remarks` | TEXT | Additional notes (nullable) |
| `transferred_to_course_id` | BIGINT | If transferred to another course (nullable) |
| `transferred_at` | DATE | Transfer date (nullable) |
| `enrolled_by` | BIGINT | Who enrolled the student (nullable) |
| `updated_by` | BIGINT | Who last updated (nullable) |
| `created_at` | TIMESTAMP | Record creation time |
| `updated_at` | TIMESTAMP | Last update time |
| `deleted_at` | TIMESTAMP | Soft delete (nullable) |

### **Enrollment Statuses**

| Status | Description | Use Case |
|--------|-------------|----------|
| `active` | Currently enrolled and attending | Default status for new enrollments |
| `completed` | Successfully completed the course | Student finished course with final grade |
| `dropped` | Student dropped out | Student voluntarily left or was removed |
| `suspended` | Temporarily suspended | On hold, may resume later |
| `transferred` | Moved to another course | Migration to different course |

---

## 🚀 Installation & Migration

### **Step 1: Run Migrations**

```bash
# Run migrations to create enrollments table
php artisan migrate

# This will:
# 1. Create the 'enrollments' table
# 2. Migrate existing student enrollments from 'students.course_id' to 'enrollments'
```

### **Step 2: Verify Migration**

```bash
# Check if enrollments were created
php artisan tinker

# In Tinker:
App\Models\Enrollment::count();  // Should show number of migrated enrollments
```

### **Step 3: (Optional) Remove Old course_id Column**

⚠️ **WARNING:** Only do this after ensuring all data is migrated correctly!

Create a new migration:
```bash
php artisan make:migration remove_course_id_from_students_table
```

```php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCourseIdFromStudentsTable extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['course_id']);  // Drop foreign key first
            $table->dropColumn('course_id');     // Then drop column
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id')->nullable()->index();
            // Add back foreign key if needed
        });
    }
}
```

---

## 💻 Usage Examples

### **1. Enroll a Student in a Course**

```php
use App\Models\Student;
use App\Models\Enrollment;

$student = Student::find(1);

// Method 1: Using Student model helper
$enrollment = $student->enrollInCourse(
    courseId: 5,
    batchId: 2,
    enrolledAt: now(),
    enrolledBy: auth()->id()
);

// Method 2: Direct Enrollment creation
$enrollment = Enrollment::create([
    'student_id' => $student->id,
    'course_id' => 5,
    'batch_id' => 2,
    'partner_id' => $student->partner_id,
    'enrolled_at' => now(),
    'status' => Enrollment::STATUS_ACTIVE,
    'enrolled_by' => auth()->id(),
]);
```

### **2. Get Student's Active Courses**

```php
$student = Student::find(1);

// Get all active courses
$activeCourses = $student->activeCourses;

// Check if enrolled in specific course
if ($student->isEnrolledIn(5)) {
    echo "Student is enrolled in course 5";
}

// Get all enrollments with details
$enrollments = $student->enrollments;

foreach ($enrollments as $enrollment) {
    echo "Course: {$enrollment->course->name}";
    echo "Status: {$enrollment->status}";
    echo "Enrolled: {$enrollment->enrolled_at->format('Y-m-d')}";
}
```

### **3. Get Course's Enrolled Students**

```php
use App\Models\Course;

$course = Course::find(5);

// Get all active students
$activeStudents = $course->activeStudents;

// Get all enrollments (all statuses)
$enrollments = $course->enrollments;

// Get statistics
$stats = $course->getEnrollmentStatistics();
/*
Returns:
[
    'total' => 150,
    'active' => 120,
    'completed' => 25,
    'dropped' => 3,
    'suspended' => 2,
    'transferred' => 0,
    'average_completion_time' => 180 // days
]
*/
```

### **4. Manage Enrollment Status**

```php
$enrollment = Enrollment::find(10);

// Mark as completed
$enrollment->markAsCompleted(
    finalGrade: 85.5,
    gradeLetter: 'A',
    remarks: 'Excellent performance'
);

// Mark as dropped
$enrollment->markAsDropped('Personal reasons');

// Mark as suspended
$enrollment->markAsSuspended('Temporary leave');

// Transfer to another course
$enrollment->markAsTransferred(
    toCourseId: 7,
    remarks: 'Moved to advanced course'
);

// Reactivate suspended enrollment
$enrollment->reactivate('Returned from leave');
```

### **5. Get Enrollment History**

```php
$student = Student::find(1);

$history = $student->getEnrollmentHistory();

foreach ($history as $enrollment) {
    echo "{$enrollment->course->name} - {$enrollment->status} ({$enrollment->enrolled_at->format('Y-m-d')})";
}
```

### **6. Query with Scopes**

```php
// Get all active enrollments
$activeEnrollments = Enrollment::active()->get();

// Get completed enrollments for a partner
$completedEnrollments = Enrollment::completed()
    ->forPartner(1)
    ->with(['student', 'course'])
    ->get();

// Get all enrollments for a specific student
$studentEnrollments = Enrollment::forStudent(1)
    ->orderBy('enrolled_at', 'desc')
    ->get();
```

### **7. Validation Before Enrollment**

```php
use App\Models\Enrollment;

$studentId = 1;
$courseId = 5;

// Check if student can be enrolled
if (Enrollment::canEnroll($studentId, $courseId)) {
    // Proceed with enrollment
    Enrollment::create([...]);
} else {
    echo "Student is already actively enrolled in this course!";
}
```

---

## 🔄 Backward Compatibility

The old `$student->course` relationship still works for backward compatibility, but it's **deprecated**.

### **Migration Path:**

**Old Code:**
```php
$student = Student::find(1);
$course = $student->course;  // ⚠️ Deprecated - returns single course
```

**New Code:**
```php
$student = Student::find(1);

// Get all courses
$courses = $student->courses;

// Get active courses
$activeCourses = $student->activeCourses;

// Get primary/current course (if you need just one)
$currentCourse = $student->activeCourses()->first();
```

---

## 🎯 Controller Examples

### **EnrollmentController.php**

```php
<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Enroll a student in a course
     */
    public function store(Request $request)
    {
        $validated = $request->validate(Enrollment::getValidationRules());

        // Check if already enrolled
        if (!Enrollment::canEnroll($validated['student_id'], $validated['course_id'])) {
            return back()->withErrors(['error' => 'Student is already enrolled in this course.']);
        }

        $enrollment = Enrollment::create([
            ...$validated,
            'enrolled_by' => auth()->id(),
        ]);

        return redirect()
            ->route('enrollments.index')
            ->with('success', 'Student enrolled successfully!');
    }

    /**
     * Show student's enrollment history
     */
    public function studentHistory($studentId)
    {
        $student = Student::findOrFail($studentId);
        $enrollments = $student->getEnrollmentHistory();

        return view('enrollments.history', compact('student', 'enrollments'));
    }

    /**
     * Show course enrollment list
     */
    public function courseEnrollments($courseId)
    {
        $course = Course::findOrFail($courseId);
        $enrollments = $course->activeEnrollments()->with('student')->get();
        $stats = $course->getEnrollmentStatistics();

        return view('enrollments.course', compact('course', 'enrollments', 'stats'));
    }

    /**
     * Complete an enrollment
     */
    public function complete(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'final_grade' => 'required|numeric|min:0|max:100',
            'grade_letter' => 'required|string|max:2',
            'remarks' => 'nullable|string',
        ]);

        $enrollment->markAsCompleted(
            $validated['final_grade'],
            $validated['grade_letter'],
            $validated['remarks'] ?? null
        );

        return back()->with('success', 'Enrollment marked as completed!');
    }

    /**
     * Drop an enrollment
     */
    public function drop(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'remarks' => 'required|string',
        ]);

        $enrollment->markAsDropped($validated['remarks']);

        return back()->with('success', 'Enrollment marked as dropped!');
    }
}
```

---

## 📊 Views Examples

### **Student Enrollment Form**

```blade
{{-- resources/views/enrollments/create.blade.php --}}

<form method="POST" action="{{ route('enrollments.store') }}">
    @csrf
    
    <div class="form-group">
        <label for="student_id">Student</label>
        <select name="student_id" id="student_id" class="form-control" required>
            <option value="">Select Student</option>
            @foreach($students as $student)
                <option value="{{ $student->id }}">{{ $student->full_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="course_id">Course</label>
        <select name="course_id" id="course_id" class="form-control" required>
            <option value="">Select Course</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="batch_id">Batch (Optional)</label>
        <select name="batch_id" id="batch_id" class="form-control">
            <option value="">Select Batch</option>
            @foreach($batches as $batch)
                <option value="{{ $batch->id }}">{{ $batch->display_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="enrolled_at">Enrollment Date</label>
        <input type="date" name="enrolled_at" id="enrolled_at" class="form-control" value="{{ date('Y-m-d') }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Enroll Student</button>
</form>
```

### **Student's Course List**

```blade
{{-- resources/views/students/courses.blade.php --}}

<h2>{{ $student->full_name }}'s Courses</h2>

<h3>Active Enrollments</h3>
<table class="table">
    <thead>
        <tr>
            <th>Course</th>
            <th>Batch</th>
            <th>Enrolled Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($student->activeEnrollments as $enrollment)
        <tr>
            <td>{{ $enrollment->course->name }}</td>
            <td>{{ $enrollment->batch->display_name ?? 'N/A' }}</td>
            <td>{{ $enrollment->enrolled_at->format('Y-m-d') }}</td>
            <td><span class="badge badge-success">{{ ucfirst($enrollment->status) }}</span></td>
            <td>
                <a href="{{ route('enrollments.show', $enrollment->id) }}" class="btn btn-sm btn-info">View</a>
                <form action="{{ route('enrollments.complete', $enrollment->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-success">Mark Complete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3>Enrollment History</h3>
<table class="table">
    <thead>
        <tr>
            <th>Course</th>
            <th>Enrolled</th>
            <th>Completed</th>
            <th>Status</th>
            <th>Grade</th>
        </tr>
    </thead>
    <tbody>
        @foreach($student->completedEnrollments as $enrollment)
        <tr>
            <td>{{ $enrollment->course->name }}</td>
            <td>{{ $enrollment->enrolled_at->format('Y-m-d') }}</td>
            <td>{{ $enrollment->completion_date?->format('Y-m-d') ?? 'N/A' }}</td>
            <td><span class="badge badge-{{ $enrollment->status === 'completed' ? 'primary' : 'secondary' }}">{{ ucfirst($enrollment->status) }}</span></td>
            <td>{{ $enrollment->grade_letter ?? 'N/A' }} ({{ $enrollment->final_grade ?? 'N/A' }})</td>
        </tr>
        @endforeach
    </tbody>
</table>
```

---

## 🛣️ Routes Example

```php
// routes/web.php

use App\Http\Controllers\EnrollmentController;

Route::middleware(['auth', 'partner'])->group(function () {
    
    // Enrollment management
    Route::resource('enrollments', EnrollmentController::class);
    
    // Student enrollment history
    Route::get('/students/{student}/enrollments', [EnrollmentController::class, 'studentHistory'])
        ->name('students.enrollments');
    
    // Course enrollments
    Route::get('/courses/{course}/enrollments', [EnrollmentController::class, 'courseEnrollments'])
        ->name('courses.enrollments');
    
    // Enrollment actions
    Route::patch('/enrollments/{enrollment}/complete', [EnrollmentController::class, 'complete'])
        ->name('enrollments.complete');
    
    Route::patch('/enrollments/{enrollment}/drop', [EnrollmentController::class, 'drop'])
        ->name('enrollments.drop');
    
    Route::patch('/enrollments/{enrollment}/suspend', [EnrollmentController::class, 'suspend'])
        ->name('enrollments.suspend');
    
    Route::patch('/enrollments/{enrollment}/reactivate', [EnrollmentController::class, 'reactivate'])
        ->name('enrollments.reactivate');
});
```

---

## ✅ Benefits of This System

1. **Flexibility:** Students can enroll in multiple courses simultaneously
2. **History Tracking:** Complete enrollment history with status changes
3. **Analytics:** Detailed statistics and reporting
4. **Lifecycle Management:** Track entire enrollment journey (enrollment → completion)
5. **Data Integrity:** Soft deletes, foreign keys, unique constraints
6. **Scalability:** Industry-standard pivot table approach
7. **Backward Compatible:** Old code continues to work during transition

---

## 🔍 Testing

```php
// tests/Feature/EnrollmentTest.php

use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;

test('student can enroll in multiple courses', function () {
    $student = Student::factory()->create();
    $course1 = Course::factory()->create();
    $course2 = Course::factory()->create();

    $student->enrollInCourse($course1->id);
    $student->enrollInCourse($course2->id);

    expect($student->activeCourses)->toHaveCount(2);
});

test('cannot enroll in same course twice', function () {
    $student = Student::factory()->create();
    $course = Course::factory()->create();

    $student->enrollInCourse($course->id);
    
    expect(fn() => $student->enrollInCourse($course->id))
        ->toThrow(\Exception::class);
});

test('can mark enrollment as completed', function () {
    $enrollment = Enrollment::factory()->create();
    
    $enrollment->markAsCompleted(85.5, 'A', 'Great work');
    
    expect($enrollment->status)->toBe(Enrollment::STATUS_COMPLETED);
    expect($enrollment->final_grade)->toBe(85.5);
    expect($enrollment->grade_letter)->toBe('A');
});
```

---

## 📝 Summary

You now have a **production-ready, industry-standard enrollment system** that:

✅ Allows students to enroll in multiple courses  
✅ Tracks complete enrollment lifecycle  
✅ Provides detailed analytics and reporting  
✅ Maintains backward compatibility  
✅ Follows Laravel best practices  

---

## 🚀 Next Steps

1. ✅ Run migrations: `php artisan migrate`
2. ✅ Verify data migration
3. ✅ Update controllers to use new relationships
4. ✅ Update views to show multiple courses
5. ✅ Test enrollment workflows
6. ✅ (Optional) Remove old `course_id` column after testing

---

**Questions or Issues?** Check the code examples above or refer to the model methods for detailed usage!

