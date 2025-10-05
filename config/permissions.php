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
        'students' => [
            'label' => 'Students',
            'buttons' => [
                'add' => 'Add Student',
                'edit' => 'Edit Student',
                'delete' => 'Delete Student',
                'view' => 'View Student Details',
            ]
        ],
        'teachers' => [
            'label' => 'Teachers',
            'buttons' => [
                'add' => 'Add Teacher',
                'edit' => 'Edit Teacher',
                'delete' => 'Delete Teacher',
                'view' => 'View Teacher Details',
            ]
        ],
        'courses' => [
            'label' => 'Courses',
            'buttons' => [
                'add' => 'Add Course',
                'edit' => 'Edit Course',
                'delete' => 'Delete Course',
                'view' => 'View Course Details',
                'manage-content' => 'Manage Content'
            ]
        ],
        'subjects' => [
            'label' => 'Subjects',
            'buttons' => [
                'add' => 'Add Subject',
                'edit' => 'Edit Subject',
                'delete' => 'Delete Subject',
                'view' => 'View Subject Details'
            ]
        ],
        'topics' => [
            'label' => 'Topics',
            'buttons' => [
                'add' => 'Add Topic',
                'edit' => 'Edit Topic',
                'delete' => 'Delete Topic',
                'view' => 'View Topic Details'
            ]
        ],
        'batches' => [
            'label' => 'Batches',
            'buttons' => [
                'add' => 'Add Batch',
                'edit' => 'Edit Batch',
                'delete' => 'Delete Batch',
                'view' => 'View Batch Details'
            ]
        ],
        'questions' => [
            'label' => 'Questions',
            'buttons' => [
                'add' => 'Add Question',
                'edit' => 'Edit Question',
                'delete' => 'Delete Question',
                'view' => 'View Question Details',
            ]
        ],
        'exams' => [
            'label' => 'Exams',
            'buttons' => [
                'add' => 'Add Exam',
                'edit' => 'Edit Exam',
                'delete' => 'Delete Exam',
                'view' => 'View Exam Details',
            ]
        ],
        'analytics' => [
            'label' => 'Analytics',
            'buttons' => [
                'view' => 'View Analytics',
            ]
        ],
        'sms' => [
            'label' => 'SMS',
            'buttons' => [
                'view' => 'View SMS',
            ]
        ],
        'settings' => [
            'label' => 'Settings',
            'buttons' => [
                'view' => 'View Settings',
                'edit' => 'Edit Settings',
                'backup' => 'Backup System',
                'restore' => 'Restore System',
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
        'partner' => [
            'description' => 'Organization super user with full access control within their institution',
            'permissions' => 'all', // Special case: all permissions for organization-level control
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
                // Menu permissions (dashboard implicit for all users)
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
