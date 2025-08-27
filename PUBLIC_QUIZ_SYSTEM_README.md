# Public Quiz System - CSuite

A comprehensive public quiz system where students can take exams without registration using phone numbers and unique access codes.

## Features

- **No Student Registration Required**: Students access quizzes using phone numbers and 6-digit access codes
- **Secure Access Control**: Unique access codes for each student-exam combination
- **Timer-Based Exams**: Configurable time limits with countdown timer
- **Multiple Question Types**: Support for MCQ and descriptive questions
- **Auto-Submission**: Automatic submission when time expires
- **Result Tracking**: Comprehensive scoring and performance analytics
- **Bulk Operations**: Efficient student assignment and management

## System Flow

### 1. Teacher Setup
1. **Create Exam**: Set title, description, duration, and time window
2. **Add Questions**: Create question sets with MCQ and descriptive questions
3. **Assign Students**: Select students from database and generate access codes
4. **Publish Exam**: Make exam available for students

### 2. Student Access
1. **Access Page**: Students visit `/quiz` and enter phone + access code
2. **Verification**: System validates credentials and prevents duplicate attempts
3. **Quiz Start**: Students review exam details and start the quiz
4. **Take Quiz**: Answer questions with real-time timer
5. **Submit**: Automatic or manual submission with results

## Usage Instructions

### For Teachers

#### Managing Student Assignments
1. Navigate to **Exams** → Select an exam → Click **Assign**
2. Select students from the available list
3. Click **Assign Selected Students** to generate access codes
4. Export assignments as CSV for distribution

#### Access Code Management
- **Regenerate Codes**: Individual or bulk regeneration of access codes
- **Remove Assignments**: Remove students from exams
- **Monitor Status**: Track which students have used their codes

#### Public Quiz Access
- Click **Public Quiz Access** in sidebar to test the student experience
- Use this to verify the quiz flow and appearance

### For Students

#### Taking a Quiz
1. Visit `/quiz` (public access page)
2. Enter your phone number and 6-digit access code
3. Review exam details and instructions
4. Click **Start Exam Now**
5. Answer questions within the time limit
6. Submit or wait for auto-submission

#### Quiz Features
- **Real-time Timer**: Visual countdown with color-coded warnings
- **Question Navigation**: Clear question display with type indicators
- **Auto-save**: Progress is saved automatically
- **Responsive Design**: Works on all devices

## Technical Implementation

### Database Schema
- **exam_access_codes**: Stores student-exam assignments with unique codes
- **student_exam_results**: Tracks quiz attempts and scores
- **exams**: Exam configuration and settings
- **questions**: Question content and metadata

### Controllers
- **PublicQuizController**: Handles student quiz access and submission
- **ExamAssignmentController**: Manages student assignments and access codes
- **ExamController**: Enhanced with assignment functionality

### Routes
- **Public Routes**: `/quiz/*` - No authentication required
- **Partner Routes**: `/partner/exams/*/assign` - Teacher management

### Security Features
- **Unique Access Codes**: 6-digit codes prevent unauthorized access
- **Phone Verification**: Students must match phone numbers in database
- **Session Management**: Secure quiz sessions with validation
- **Duplicate Prevention**: Students cannot retake completed exams

## File Structure

```
resources/views/
├── public/quiz/
│   ├── access.blade.php      # Student access page
│   ├── start.blade.php       # Quiz start/instructions
│   ├── take.blade.php        # Quiz taking interface
│   └── result.blade.php      # Results display
└── partner/exams/
    └── assign.blade.php      # Student assignment management

app/Http/Controllers/
├── PublicQuizController.php      # Public quiz logic
└── ExamAssignmentController.php  # Student assignment logic

app/Models/
└── ExamAccessCode.php           # Access code model

database/migrations/
└── exam_access_codes_table.php  # Database schema
```

## Configuration

### Exam Settings
- **Duration**: Set time limit in minutes
- **Time Window**: Configure start and end times
- **Passing Marks**: Define minimum score for passing
- **Question Types**: Mix MCQ and descriptive questions

### Access Code Settings
- **Code Length**: 6-digit numeric codes
- **Expiration**: Codes expire when exam ends
- **Usage Tracking**: Monitor when codes are used

## Best Practices

### For Teachers
1. **Test the System**: Use public quiz access to verify student experience
2. **Clear Instructions**: Provide students with clear access code distribution
3. **Monitor Progress**: Check assignment status and completion rates
4. **Backup Codes**: Keep access codes secure and accessible

### For Students
1. **Stable Connection**: Ensure reliable internet during quiz
2. **Time Management**: Monitor timer and pace yourself
3. **Save Progress**: Don't refresh or close browser during quiz
4. **Contact Support**: Reach out if you encounter issues

## Troubleshooting

### Common Issues
- **Invalid Access Code**: Verify phone number and code combination
- **Timer Issues**: Check system time and refresh if needed
- **Submission Problems**: Ensure all questions are answered
- **Session Errors**: Clear browser cache and try again

### Support
- Contact your teacher for access code issues
- Technical support available through partner portal
- Check exam status and time windows

## Future Enhancements

- **Offline Mode**: Support for offline quiz taking
- **Advanced Analytics**: Detailed performance insights
- **Question Randomization**: Dynamic question ordering
- **Multi-language Support**: Internationalization features
- **Mobile App**: Native mobile application

---

**Note**: This system is designed for educational institutions and requires proper student data management. Ensure compliance with data protection regulations and educational standards.
