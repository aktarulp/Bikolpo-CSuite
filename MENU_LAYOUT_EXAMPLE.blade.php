{{-- Example: How to update partner-layout.blade.php with menu permissions --}}

{{-- OLD WAY (without permission check) --}}
<a href="{{ route('partner.dashboard') }}">
    <span>Dashboard</span>
</a>

{{-- NEW WAY (with permission check) --}}
@canAccessMenu('dashboard')
<a href="{{ route('partner.dashboard') }}">
    <span>Dashboard</span>
</a>
@endcanAccessMenu

{{-- Example for Students Menu --}}
@canAccessMenu('students')
<a href="{{ route('partner.students.index') }}"
   class="group flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg">
    <div class="w-8 h-8 flex-shrink-0 rounded-lg flex items-center justify-center">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
        </svg>
    </div>
    <span class="ml-2 flex-1">Students</span>
    <span class="ml-auto">{{ $stats['total_students'] ?? 0 }}</span>
</a>
@endcanAccessMenu

{{-- Example for Teachers Menu --}}
@canAccessMenu('teachers')
<a href="{{ route('partner.teachers.index') }}"
   class="group flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg">
    <div class="w-8 h-8 flex-shrink-0 rounded-lg flex items-center justify-center">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
    </div>
    <span class="ml-2 flex-1">Teachers</span>
    <span class="ml-auto">{{ $stats['total_teachers'] ?? 0 }}</span>
</a>
@endcanAccessMenu

{{-- Example for Settings Menu (check multiple permissions) --}}
@canAccessAnyMenu('settings', 'users', 'access-control')
<a href="{{ route('partner.settings.index') }}"
   class="group flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg">
    <div class="w-8 h-8 flex-shrink-0 rounded-lg flex items-center justify-center">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
    </div>
    <span class="ml-2 flex-1">Settings</span>
</a>
@endcanAccessAnyMenu

{{-- Complete Menu Section Example --}}
<nav class="flex-1 px-2 py-4 space-y-1">
    @canAccessMenu('dashboard')
    <a href="{{ route('partner.dashboard') }}">Dashboard</a>
    @endcanAccessMenu
    
    @canAccessMenu('students')
    <a href="{{ route('partner.students.index') }}">Students</a>
    @endcanAccessMenu
    
    @canAccessMenu('teachers')
    <a href="{{ route('partner.teachers.index') }}">Teachers</a>
    @endcanAccessMenu
    
    @canAccessMenu('courses')
    <a href="{{ route('partner.courses.index') }}">Courses</a>
    @endcanAccessMenu
    
    @canAccessMenu('exams')
    <a href="{{ route('partner.exams.index') }}">Exams</a>
    @endcanAccessMenu
    
    @canAccessMenu('settings')
    <a href="{{ route('partner.settings.index') }}">Settings</a>
    @endcanAccessMenu
</nav>
