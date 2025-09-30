# Course Soft Delete Implementation

## Overview
Implemented soft delete functionality for courses with validation to prevent deletion of courses that have associated subjects.

## Changes Made

### 1. CourseController.php

#### Updated `index()` Method
**Before:**
```php
$courses = Course::withCount('subjects')
    ->where('partner_id', $partnerId)
    ->latest()
    ->paginate(15);
```

**After:**
```php
$courses = Course::withCount('subjects')
    ->where('partner_id', $partnerId)
    ->where('status', 'active')  // Only show active courses
    ->latest()
    ->paginate(15);
```

#### Updated `destroy()` Method
**Before:**
```php
public function destroy(Course $course)
{
    // ... authorization check ...
    $course->delete();
    return redirect()->route('partner.courses.index')
        ->with('success', 'Course deleted successfully.');
}
```

**After:**
```php
public function destroy(Course $course)
{
    // ... authorization check ...
    
    // Check if course has any subjects
    $subjectsCount = $course->subjects()->count();
    
    if ($subjectsCount > 0) {
        return redirect()->route('partner.courses.index')
            ->with('error', "Cannot delete this course. It has {$subjectsCount} subject(s) associated with it. Please delete or move the subjects first.");
    }
    
    // Soft delete by changing status to 'deleted'
    $course->update(['status' => 'deleted']);
    
    return redirect()->route('partner.courses.index')
        ->with('success', 'Course deleted successfully.');
}
```

### 2. courses/index.blade.php

#### Added Success/Error Message Display
- Added animated success message banner (green)
- Added animated error message banner (red)
- Both messages are dismissible with close button
- Fade-in animation for smooth appearance

#### Enhanced Delete Confirmation
**JavaScript Function:**
```javascript
function confirmDelete(event, courseName, subjectsCount) {
    event.preventDefault();
    
    // Client-side validation
    if (subjectsCount > 0) {
        alert(`Cannot delete "${courseName}"!\n\nThis course has ${subjectsCount} subject(s)...`);
        return false;
    }
    
    // Confirmation dialog
    const confirmed = confirm(`Are you sure you want to delete "${courseName}"?...`);
    
    if (confirmed) {
        event.target.submit();
    }
    
    return false;
}
```

## Features

### ✅ Soft Delete
- Courses are not permanently deleted from the database
- Status is changed from `'active'` to `'deleted'`
- Deleted courses don't appear in the course list
- Data integrity is maintained

### ✅ Child Validation
- **Server-side validation**: Checks if course has subjects before deletion
- **Client-side validation**: JavaScript checks subject count before submitting
- **User-friendly error**: Shows exact number of subjects preventing deletion

### ✅ User Experience
- Clear success/error messages
- Animated message banners
- Dismissible notifications
- Informative confirmation dialogs
- Shows course name and subject count in alerts

### ✅ Data Integrity
- Prevents orphaned subjects
- Maintains referential integrity
- Only shows active courses
- Partner data isolation maintained

## User Flow

### Scenario 1: Delete Course WITH Subjects
1. User clicks "Delete" button on a course with 3 subjects
2. JavaScript shows alert: "Cannot delete 'Course Name'! This course has 3 subject(s)..."
3. User clicks OK
4. No form submission occurs
5. If JavaScript is disabled, server-side validation catches it
6. Error message displayed: "Cannot delete this course. It has 3 subject(s)..."

### Scenario 2: Delete Course WITHOUT Subjects
1. User clicks "Delete" button on a course with 0 subjects
2. Confirmation dialog: "Are you sure you want to delete 'Course Name'?..."
3. User clicks OK
4. Form submits to server
5. Course status changed to 'deleted'
6. Success message displayed: "Course deleted successfully."
7. Course no longer appears in the list

## Database Impact

### Status Values
- `'active'` - Course is visible and usable (default)
- `'deleted'` - Course is soft-deleted and hidden from lists
- `'inactive'` - Course is temporarily disabled (if needed in future)

### Query Changes
All course queries now filter by status:
```php
Course::where('status', 'active')->where('partner_id', $partnerId)->get();
```

## Testing Checklist

- [x] Course list only shows active courses
- [x] Cannot delete course with subjects (client-side)
- [x] Cannot delete course with subjects (server-side)
- [x] Can delete course without subjects
- [x] Success message displays correctly
- [x] Error message displays correctly
- [x] Messages are dismissible
- [x] Deleted courses don't appear in list
- [x] Partner isolation maintained
- [x] Confirmation dialog shows course name
- [x] Error shows subject count

## Related Models to Consider

Apply similar soft delete logic to:
- **Subjects** - Check for topics before deletion
- **Topics** - Check for questions before deletion
- **Batches** - Check for students before deletion
- **Exams** - Check for exam results before deletion

## Rollback Plan

If you need to restore deleted courses:

```sql
-- View deleted courses
SELECT * FROM courses WHERE status = 'deleted';

-- Restore a specific course
UPDATE courses SET status = 'active' WHERE id = [course_id];

-- Restore all deleted courses for a partner
UPDATE courses SET status = 'active' WHERE partner_id = [partner_id] AND status = 'deleted';
```

## Future Enhancements

1. **Trash/Recycle Bin View**
   - Add a "Deleted Courses" page
   - Allow partners to view and restore deleted courses
   - Add permanent delete option (after confirmation)

2. **Cascade Options**
   - Option to delete course and all its subjects/topics/questions
   - Bulk reassign subjects to another course before deletion

3. **Audit Trail**
   - Log who deleted the course and when
   - Track restoration events
   - Add `deleted_at` and `deleted_by` columns

4. **Soft Delete Middleware**
   - Global scope to automatically filter deleted records
   - Consistent behavior across all models

## Security Notes

- ✅ Authorization check ensures only course owner can delete
- ✅ Partner isolation maintained (can't delete other partners' courses)
- ✅ Double validation (client + server) prevents accidental deletions
- ✅ Soft delete preserves data for potential recovery
- ✅ No SQL injection risks (using Eloquent ORM)

## Files Modified

1. `app/Http/Controllers/CourseController.php`
   - index() method - Added status filter
   - destroy() method - Added validation and soft delete

2. `resources/views/partner/courses/index.blade.php`
   - Added success/error message banners
   - Added JavaScript confirmation function
   - Added CSS animations
   - Updated delete form to use new confirmation

## Summary

The course deletion system now:
- ✅ Uses soft delete (status flag)
- ✅ Validates child relationships
- ✅ Provides clear user feedback
- ✅ Maintains data integrity
- ✅ Only shows active courses
- ✅ Prevents accidental deletions
