# 🌐 Frontend Access Guide - Multi-Course Enrollment System

## 📋 Overview

This guide explains how to access and use the enrollment system from the frontend interface.

---

## 🔗 Available URLs (Routes)

### **Main Enrollment Management**

| URL | Description |
|-----|-------------|
| `/partner/enrollments` | View all enrollments |
| `/partner/enrollments/create` | Enroll a student in a course |
| `/partner/enrollments/{id}` | View enrollment details |
| `/partner/enrollments/{id}/edit` | Edit enrollment |

### **Student-Specific**

| URL | Description |
|-----|-------------|
| `/partner/students/{id}/enrollments` | View student's enrollment history |
| `/partner/students` | Student list (now shows all enrolled courses) |

### **Course-Specific**

| URL | Description |
|-----|-------------|
| `/partner/courses/{id}/enrollments` | View all students enrolled in a course |

### **Quick Actions**

| URL | Action |
|-----|--------|
| `PATCH /partner/enrollments/{id}/complete` | Mark enrollment as completed |
| `PATCH /partner/enrollments/{id}/drop` | Mark student as dropped |
| `PATCH /partner/enrollments/{id}/suspend` | Suspend enrollment |
| `PATCH /partner/enrollments/{id}/reactivate` | Reactivate suspended enrollment |

---

## 🎯 How to Access

### **1. From Partner Dashboard**

```
http://your-domain.com/partner/enrollments
```

This shows all enrollments with filters for:
- Status (active, completed, dropped, suspended)
- Course
- Student search

### **2. Enroll a Student**

**Option A: From Enrollments Page**
```
http://your-domain.com/partner/enrollments/create
```

**Option B: From Student List** 
Click "Enroll in Course" button next to student

### **3. View Student's Courses**

**From Student List:**
```
http://your-domain.com/partner/students/{student-id}/enrollments
```

Shows:
- All active enrollments
- Completed courses
- Enrollment history

### **4. View Course Enrollments**

```
http://your-domain.com/partner/courses/{course-id}/enrollments
```

Shows:
- All students enrolled in the course
- Enrollment statistics
- Status breakdown

---

## 📱 User Interface Features

### **Enrollment Index Page**

Features:
- ✅ Paginated list of all enrollments
- ✅ Filter by status, course, student
- ✅ Search by student name/ID
- ✅ Quick status badges (color-coded)
- ✅ Bulk actions support
- ✅ Export to Excel/PDF

**Filters:**
```html
- Status: All | Active | Completed | Dropped | Suspended | Transferred
- Course: All Courses | [List of courses]
- Search: Student name, ID, or email
```

### **Create Enrollment Form**

Fields:
- Student (searchable dropdown)
- Course (dropdown)
- Batch (optional)
- Enrollment Date
- Remarks (optional)

### **Enrollment Details Page**

Shows:
- Student information
- Course details
- Enrollment status
- Dates (enrolled, completed)
- Grades (if completed)
- Action buttons (complete, drop, suspend)

---

## 🎨 Adding to Navigation Menu

Add to your partner sidebar menu:

```blade
<!-- In resources/views/layouts/partner-layout.blade.php -->

<li class="mb-2">
    <a href="{{ route('partner.enrollments.index') }}" 
       class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200 {{ request()->routeIs('partner.enrollments.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300' }}">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
        </svg>
        <span>Enrollments</span>
    </a>
</li>
```

---

## 🔧 Quick Integration Examples

### **1. Add "Enroll" Button to Student List**

```blade
<!-- In resources/views/partner/students/index.blade.php -->

<a href="{{ route('partner.enrollments.create', ['student_id' => $student->id]) }}" 
   class="btn btn-sm btn-primary">
    <i class="fas fa-plus"></i> Enroll in Course
</a>
```

### **2. Show Active Courses on Student Card**

```blade
<!-- Display student's active courses -->
<div class="student-courses">
    <h4>Active Courses ({{ $student->activeCourses()->count() }})</h4>
    <ul>
        @foreach($student->activeCourses as $course)
            <li>
                <span class="badge badge-success">{{ $course->name }}</span>
            </li>
        @endforeach
    </ul>
</div>
```

### **3. Enrollment Statistics Widget**

```blade
<!-- Dashboard widget showing enrollment stats -->
<div class="stats-card">
    <h3>Enrollment Stats</h3>
    <div class="stats-grid">
        <div class="stat">
            <span class="value">{{ Enrollment::forPartner($partner->id)->active()->count() }}</span>
            <span class="label">Active</span>
        </div>
        <div class="stat">
            <span class="value">{{ Enrollment::forPartner($partner->id)->completed()->count() }}</span>
            <span class="label">Completed</span>
        </div>
    </div>
</div>
```

---

## 🎬 Usage Workflow

### **Scenario 1: Enroll a Student**

1. Go to `/partner/enrollments/create`
2. Select student from dropdown
3. Select course
4. Choose batch (optional)
5. Set enrollment date
6. Click "Enroll Student"

### **Scenario 2: Mark Enrollment as Completed**

1. Go to `/partner/enrollments`
2. Find the enrollment
3. Click "View Details"
4. Click "Mark as Completed"
5. Enter final grade and letter grade
6. Add remarks (optional)
7. Submit

### **Scenario 3: View Student's Enrollment History**

1. Go to `/partner/students`
2. Find the student
3. Click "View Enrollments" or "Enrollment History"
4. See all courses (active, completed, dropped)

---

## 📊 Status Badge Colors

```html
Active:      Green badge with checkmark
Completed:   Blue badge with graduation cap
Dropped:     Red badge with X
Suspended:   Yellow badge with pause icon
Transferred: Purple badge with arrow
```

---

## 🔐 Permissions & Access Control

The enrollment system respects your existing partner context:

✅ Partners can only see/manage enrollments for their own students  
✅ Partners can only enroll students in their own courses  
✅ All actions are logged with user ID  

---

## 🚀 Quick Start Checklist

- [ ] Add "Enrollments" link to sidebar navigation
- [ ] Test enrolling a student in multiple courses
- [ ] View enrollment history for a student
- [ ] Mark an enrollment as completed
- [ ] Check enrollment statistics on dashboard
- [ ] Export enrollment report

---

## 📞 Next Steps

1. **Customize Views:** Edit blade files in `resources/views/partner/enrollments/`
2. **Add Permissions:** Integrate with your access control system
3. **Add Notifications:** Send emails when enrollments change status
4. **Add Reporting:** Create enrollment reports and analytics

---

## 🎨 View Files Created

- `resources/views/partner/enrollments/index.blade.php` - Main list
- `resources/views/partner/enrollments/create.blade.php` - Enrollment form
- `resources/views/partner/enrollments/show.blade.php` - Details view
- `resources/views/partner/enrollments/edit.blade.php` - Edit form
- `resources/views/partner/enrollments/student-history.blade.php` - Student history
- `resources/views/partner/enrollments/course-enrollments.blade.php` - Course list

---

**All set! Your multi-course enrollment system is now accessible from the frontend.** 🎉

For detailed usage examples and code samples, see `MULTI_COURSE_ENROLLMENT_GUIDE.md`

