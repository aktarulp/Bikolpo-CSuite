<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Permission Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration defines all menus and their associated button permissions.
    | Each menu has a set of buttons that can be controlled individually.
    |
    */

    'menus' => [
        'dashboard' => [
            'label' => 'Dashboard',
            'buttons' => [
                'view-stats' => 'View Statistics',
                'export-data' => 'Export Data',
            ]
        ],
        'students' => [
            'label' => 'Students',
            'buttons' => [
                'add' => 'Add Student',
                'edit' => 'Edit Student',
                'delete' => 'Delete Student',
                'view' => 'View Student Details',
                'export' => 'Export Students',
                'import' => 'Import Students',
                'assign-course' => 'Assign Course',
                'manage-grades' => 'Manage Grades',
            ]
        ],
        'teachers' => [
            'label' => 'Teachers',
            'buttons' => [
                'add' => 'Add Teacher',
                'edit' => 'Edit Teacher',
                'delete' => 'Delete Teacher',
                'view' => 'View Teacher Details',
                'export' => 'Export Teachers',
                'import' => 'Import Teachers',
                'assign-course' => 'Assign Course',
                'assign-subject' => 'Assign Subject',
            ]
        ],
        'courses' => [
            'label' => 'Courses',
            'buttons' => [
                'add' => 'Add Course',
                'edit' => 'Edit Course',
                'delete' => 'Delete Course',
                'view' => 'View Course Details',
                'assign-student' => 'Assign Student',
                'assign-teacher' => 'Assign Teacher',
                'manage-content' => 'Manage Content',
                'export' => 'Export Courses',
            ]
        ],
        'exams' => [
            'label' => 'Exams',
            'buttons' => [
                'add' => 'Add Exam',
                'edit' => 'Edit Exam',
                'delete' => 'Delete Exam',
                'view' => 'View Exam Details',
                'manage-questions' => 'Manage Questions',
                'view-results' => 'View Results',
                'export-results' => 'Export Results',
                'schedule' => 'Schedule Exam',
            ]
        ],
        'questions' => [
            'label' => 'Questions',
            'buttons' => [
                'add' => 'Add Question',
                'edit' => 'Edit Question',
                'delete' => 'Delete Question',
                'view' => 'View Question Details',
                'import' => 'Import Questions',
                'export' => 'Export Questions',
                'categorize' => 'Categorize Questions',
            ]
        ],
        'results' => [
            'label' => 'Results',
            'buttons' => [
                'view' => 'View Results',
                'export' => 'Export Results',
                'analyze' => 'Analyze Performance',
                'generate-reports' => 'Generate Reports',
            ]
        ],
        'users' => [
            'label' => 'User Management',
            'buttons' => [
                'add' => 'Add User',
                'edit' => 'Edit User',
                'delete' => 'Delete User',
                'view' => 'View User Details',
                'manage-roles' => 'Manage Roles',
                'manage-permissions' => 'Manage Permissions',
                'export' => 'Export Users',
            ]
        ],
        'settings' => [
            'label' => 'Settings',
            'buttons' => [
                'view' => 'View Settings',
                'edit' => 'Edit Settings',
                'backup' => 'Backup System',
                'restore' => 'Restore System',
                'manage-integrations' => 'Manage Integrations',
            ]
        ],
        'reports' => [
            'label' => 'Reports',
            'buttons' => [
                'view' => 'View Reports',
                'generate' => 'Generate Reports',
                'export' => 'Export Reports',
                'schedule' => 'Schedule Reports',
            ]
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Role Definitions
    |--------------------------------------------------------------------------
    |
    | Define the roles and their default permissions.
    |
    */

    'roles' => [
        'Admin' => [
            'description' => 'Full system access with all permissions',
            'permissions' => 'all', // Special case: all permissions
        ],
        'Teacher' => [
            'description' => 'Teacher access with limited permissions',
            'permissions' => [
                // Menu permissions
                'menu-dashboard',
                'menu-students',
                'menu-courses',
                'menu-exams',
                'menu-questions',
                'menu-results',
                
                // Dashboard permissions
                'dashboard-view-stats',
                
                // Student permissions
                'students-view',
                'students-export',
                'students-assign-course',
                'students-manage-grades',
                
                // Course permissions
                'courses-view',
                'courses-assign-student',
                'courses-manage-content',
                
                // Exam permissions
                'exams-add',
                'exams-edit',
                'exams-view',
                'exams-manage-questions',
                'exams-view-results',
                'exams-schedule',
                
                // Question permissions
                'questions-add',
                'questions-edit',
                'questions-view',
                'questions-import',
                'questions-export',
                'questions-categorize',
                
                // Results permissions
                'results-view',
                'results-export',
                'results-analyze',
                'results-generate-reports',
            ]
        ],
        'Student' => [
            'description' => 'Student access with limited permissions',
            'permissions' => [
                // Menu permissions
                'menu-dashboard',
                'menu-courses',
                'menu-exams',
                'menu-results',
                
                // Dashboard permissions
                'dashboard-view-stats',
                
                // Course permissions (view only)
                'courses-view',
                
                // Exam permissions (limited)
                'exams-view',
                
                // Results permissions (own results only)
                'results-view',
            ]
        ],
        'Operator' => [
            'description' => 'System operator with administrative permissions',
            'permissions' => [
                // Menu permissions
                'menu-dashboard',
                'menu-students',
                'menu-teachers',
                'menu-courses',
                'menu-users',
                'menu-settings',
                'menu-reports',
                
                // Dashboard permissions
                'dashboard-view-stats',
                'dashboard-export-data',
                
                // Student permissions
                'students-add',
                'students-edit',
                'students-view',
                'students-export',
                'students-import',
                
                // Teacher permissions
                'teachers-add',
                'teachers-edit',
                'teachers-view',
                'teachers-export',
                'teachers-import',
                
                // Course permissions
                'courses-add',
                'courses-edit',
                'courses-view',
                'courses-assign-student',
                'courses-assign-teacher',
                
                // User permissions
                'users-add',
                'users-edit',
                'users-view',
                'users-export',
                
                // Settings permissions
                'settings-view',
                'settings-edit',
                
                // Reports permissions
                'reports-view',
                'reports-generate',
                'reports-export',
            ]
        ],
    ],
];
