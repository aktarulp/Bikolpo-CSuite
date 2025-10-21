# Course-Batch Relationship Documentation

## Overview
Batches are now child items of Courses. A batch can only be created under a specific course, establishing a proper parent-child hierarchy.

## Database Structure

```
courses
├─ id
├─ name
├─ code
├─ description
├─ start_date
├─ end_date
├─ status
├─ partner_id
└─ created_by

batches
├─ id
├─ name
├─ year
├─ course_id  ← Foreign key to courses.id
├─ start_date
├─ end_date
├─ status
├─ partner_id
└─ created_by
```

## Relationship

### Course Model (`app/Models/Course.php`)

```php
/**
 * Get all batches for this course.
 */
public function batches()
{
    return $this->hasMany(Batch::class);
}
```

**Usage Examples:**
```php
// Get all batches for a course
$course = Course::find(1);
$batches = $course->batches;

// Get active batches for a course
$activeBatches = $course->batches()->where('status', 'active')->get();

// Count batches
$batchCount = $course->batches()->count();

// Create a batch for a course
$course->batches()->create([
    'name' => 'Morning Batch',
    'year' => 2025,
    'start_date' => '2025-01-01',
    'end_date' => '2025-12-31',
    'status' => 'active',
    'partner_id' => 1,
    'created_by' => auth()->id(),
]);
```

### Batch Model (`app/Models/Batch.php`)

```php
/**
 * Get the course that this batch belongs to.
 */
public function course()
{
    return $this->belongsTo(Course::class);
}
```

**Usage Examples:**
```php
// Get the course for a batch
$batch = Batch::find(1);
$course = $batch->course;

// Access course properties
echo $batch->course->name;
echo $batch->course->code;

// Eager load course with batch
$batches = Batch::with('course')->get();

// Query batches by course
$batches = Batch::where('course_id', 1)->get();
```

## Hierarchy Structure

```
Course: Web Development (WD-101)
├─ Batch: Morning Batch (2025)
├─ Batch: Evening Batch (2025)
└─ Batch: Weekend Batch (2025)

Course: Mobile App Development (MAD-201)
├─ Batch: Full-time Batch (2025)
└─ Batch: Part-time Batch (2025)
```

## Benefits

1. **Data Integrity**
   - Batches are always associated with a course
   - Prevents orphaned batches
   - Clear ownership hierarchy

2. **Logical Organization**
   - Easy to find all batches for a course
   - Simple course-batch navigation
   - Better data structure

3. **Query Efficiency**
   - Eager loading support
   - Efficient filtering
   - Better performance with relationships

4. **Enrollment Clarity**
   - Students enroll in a course
   - Students are assigned to a batch within that course
   - Clear enrollment hierarchy

## Enrollment Hierarchy

```
Student
└─ Enrollment
    ├─ Course (e.g., Web Development)
    └─ Batch (e.g., Morning Batch - under Web Development course)
```

**Example:**
```php
// Enrollment with course and batch
$enrollment = Enrollment::create([
    'student_id' => 1,
    'course_id' => 5,      // Web Development
    'batch_id' => 12,      // Morning Batch (must be under course_id 5)
    'partner_id' => 1,
    'enrolled_at' => now(),
    'status' => 'active',
]);
```

## Validation Rules

When creating/updating batches, ensure:

```php
'course_id' => 'required|exists:courses,id',  // Must belong to an existing course
```

When creating enrollments, ensure batch belongs to course:

```php
// Validate that batch belongs to the selected course
$batch = Batch::findOrFail($request->batch_id);
if ($batch->course_id !== $request->course_id) {
    throw ValidationException::withMessages([
        'batch_id' => 'The selected batch does not belong to the chosen course.'
    ]);
}
```

## Best Practices

1. **Always specify course_id when creating batches**
   ```php
   Batch::create([
       'name' => 'Morning Batch',
       'course_id' => $courseId,  // Required!
       // ... other fields
   ]);
   ```

2. **Validate course-batch relationship in enrollments**
   - Ensure batch belongs to the selected course
   - Prevents data inconsistency

3. **Use eager loading to prevent N+1 queries**
   ```php
   // Good
   $batches = Batch::with('course')->get();
   
   // Bad (N+1 query problem)
   $batches = Batch::all();
   foreach ($batches as $batch) {
       echo $batch->course->name;  // Queries course for each batch!
   }
   ```

4. **Filter batches by course in dropdowns**
   ```php
   // In enrollment form, load only batches for selected course
   $batches = Batch::where('course_id', $request->course_id)
       ->where('status', 'active')
       ->get();
   ```

## Updated Database Schema

The relationship is already reflected in the migration:

```php
Schema::create('batches', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->integer('year');
    $table->unsignedBigInteger('course_id')->nullable();  // ← Course relationship
    // ... other fields
    
    $table->foreign('course_id')
          ->references('id')
          ->on('courses')
          ->onDelete('cascade');  // Delete batches when course is deleted
});
```

## Migration Notes

If you need to enforce the relationship for existing data:

```bash
# In Tinker or migration
php artisan tinker

# Update existing batches without course_id
Batch::whereNull('course_id')->update(['course_id' => 1]); // Set a default course

# Or delete orphaned batches
Batch::whereNull('course_id')->delete();
```

## Summary

✅ **Relationship Established**: Course → hasMany → Batch, Batch → belongsTo → Course  
✅ **Foreign Key**: `batches.course_id` references `courses.id`  
✅ **Cascade Delete**: Deleting a course deletes its batches  
✅ **Models Updated**: Both Course and Batch models have relationship methods  
✅ **Ready to Use**: Relationship is fully functional and ready for queries  

---

**Created:** {{ now() }}  
**Version:** 1.0

