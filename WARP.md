# WARP.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Project Overview

This is **Bikolpo Live**, a comprehensive Laravel-based educational quiz and exam management system designed for coaching institutes and educational partners. The system features multi-role architecture with Partners (educators/coaching centers) and Students, advanced quiz management, real-time analytics, and a public quiz system.

## Essential Development Commands

### Environment Setup
```bash
# Copy environment configuration
cp ".env - Copy.example" .env

# Install PHP dependencies
composer install

# Install Node.js dependencies  
npm install

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate

# Run database migrations with fresh start
php artisan migrate:fresh

# Seed database with demo data
php artisan db:seed
```

### Development Server
```bash
# Start development environment (includes server, queue, logs, and Vite)
composer run dev

# Alternative: Start individual services
php artisan serve          # Laravel server
php artisan queue:listen    # Queue worker
php artisan pail            # Log viewer
npm run dev                 # Vite development server
```

### Testing
```bash
# Run all tests using Pest framework
composer run test

# Run specific test types
./vendor/bin/pest tests/Feature
./vendor/bin/pest tests/Unit

# Run tests with coverage
./vendor/bin/pest --coverage
```

### Database Operations
```bash
# Fresh migration with seeding
php artisan migrate:fresh --seed

# Check database schema
php check_schema.php

# Run custom commands for data population
php artisan seed:demo-students
php artisan seed:mcq-questions
php artisan seed:complete-mcq-data
php artisan populate:question-stats
php artisan update:exam-statuses
```

### Asset Management
```bash
# Build assets for production
npm run build

# Build assets for development
npm run dev

# Clear various caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

## High-Level Architecture

### Multi-Tenant Role-Based System
The application operates with a sophisticated multi-role architecture:

- **Partners**: Educational institutions/coaching centers who create and manage exams
- **Students**: Learners who take exams and view results
- **Role-Based Permissions**: Dynamic permission system with granular access control

### Core Domain Models
- **Partners**: Represent educational institutions with detailed profile information
- **Students**: Student profiles with course/batch assignments and migration tracking
- **Courses & Subjects**: Hierarchical curriculum structure with many-to-many relationships
- **Questions**: Multi-type questions (MCQ, Descriptive, True/False) with analytics tracking
- **Exams**: Comprehensive exam management with time-based scheduling and access control
- **Exam Results**: Detailed result tracking with question-level analytics

### Public Quiz System Architecture
The system features a sophisticated public quiz interface:
- **Access Code System**: Students access exams using phone numbers + 6-digit access codes
- **Session Management**: Secure quiz sessions with CSRF protection and validation
- **Real-time Timer**: JavaScript-based countdown with auto-submission
- **Result Tracking**: Immediate or scheduled result display with detailed analytics

### Advanced Analytics Engine
- **Question Analytics**: Difficulty calculation, answer distribution, performance metrics
- **Student Analytics**: Comprehensive performance tracking across exams and question types
- **Exam Review System**: Detailed post-exam review with tabbed interface for correct/incorrect answers
- **Performance Comparison**: Student ranking and percentile calculations

## Key Directory Structure

```
app/
├── Http/Controllers/          # Main application logic
│   ├── PartnerController.php     # Partner management
│   ├── StudentController.php     # Student management  
│   ├── ExamController.php        # Exam creation and management
│   ├── PublicQuizController.php  # Public quiz access logic
│   ├── QuestionController.php    # Question management with bulk operations
│   └── AnalyticsController.php   # Performance analytics
├── Models/                    # Eloquent models with complex relationships
├── Console/Commands/          # Custom Artisan commands for data operations
├── Services/                  # Business logic services
└── Traits/                    # Reusable traits (HasPartnerContext)

database/
├── migrations/               # Database schema definitions
│   └── 0001_01_01_000000_create_complete_database_structure.php
└── factories/               # Model factories for testing

resources/views/
├── partner/                 # Partner dashboard and management views
├── student/                 # Student dashboard and exam interfaces  
├── public/quiz/             # Public quiz access system
└── components/              # Blade components

routes/
├── web.php                  # Main application routes with middleware groups
├── auth.php                 # Authentication routes
└── api.php                  # API endpoints for analytics and review
```

## Development Patterns & Guidelines

### Partner Context Pattern
Many operations are scoped to partners using the `HasPartnerContext` trait. When working with partner-scoped data, ensure proper context filtering.

### Multi-Type Question System
Questions support multiple types (MCQ, Descriptive, True/False) with type-specific controllers and views. When adding question features, consider all question types.

### Exam Assignment Workflow
Exams follow a specific workflow: Creation → Question Assignment → Student Assignment → Publishing → Analytics. Each step has dedicated controllers and validation.

### Public Quiz Security
Public quiz routes implement special middleware (`RefreshCSRFToken`) and session management for non-authenticated users. Maintain security patterns when modifying quiz flow.

### Analytics Data Pipeline
The system tracks detailed question-level statistics in `question_statistics` table. This powers the comprehensive analytics engine. When modifying exam submission logic, ensure analytics data integrity.

## Configuration Notes

- **Timezone**: Set to 'Asia/Dhaka' for Bangladesh locale
- **Database**: MySQL with comprehensive indexing for performance
- **Queue System**: Database-based queue for background processing
- **Testing Framework**: Pest PHP for expressive testing
- **Frontend**: Blade templates with Alpine.js and TailwindCSS
- **PDF Generation**: Spatie Browsershot for exam paper generation

## Special Features to Consider

### Student Migration System
Students can be migrated between courses/batches with full history tracking. The `StudentMigrationService` handles complex migration logic.

### Bulk Operations Support  
The system supports bulk operations for question import/export, student assignments, and access code management.

### Advanced Permission System
Dynamic role-based permissions with module-specific access control. The system supports permission inheritance and custom role creation.

### Real-time Exam Monitoring
Partners can monitor exam progress in real-time, including waiting students and submission status.

### Multi-language Considerations
The system is designed for Bengali/English content with proper UTF-8 handling and font support.