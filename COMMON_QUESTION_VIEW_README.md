# Common Question View Feature

## Overview
A professional, mobile-responsive common question view that can display all types of questions (MCQ, Descriptive, True/False, Fill in the Blanks) in a unified interface.

## Features

### 🎨 Professional Design
- Modern, clean interface with gradient headers
- Card-based layout with subtle shadows and animations
- Professional color scheme with proper contrast ratios
- Smooth transitions and hover effects

### 📱 Mobile Responsive
- Mobile-first design approach
- Responsive grid layouts that adapt to screen size
- Touch-friendly buttons and interactive elements
- Optimized typography for different screen sizes
- Swipe gestures for navigation (swipe left to go back)

### 🔧 Universal Compatibility
- Supports all question types: MCQ, Descriptive, True/False, Fill in the Blanks
- Dynamic content rendering based on question type
- Proper handling of optional fields and relationships
- Image support with responsive sizing

### ♿ Accessibility Features
- Keyboard navigation support
- Proper ARIA labels and semantic HTML
- High contrast ratios for readability
- Screen reader friendly structure
- Focus management for better navigation

### 🎯 Key Components

#### Question Header
- Question ID and type badge with appropriate icons
- Difficulty level indicator with color coding
- Marks allocation display
- Professional gradient background

#### Question Content
- Responsive question text rendering
- Image support with proper scaling
- Options display for MCQ and True/False questions
- Special fields for descriptive questions (sample answers, key concepts, etc.)

#### Question Metadata
- Course, Subject, Topic information
- Question type and time allocation
- Creation date and status
- Tags display

#### Action Buttons
- Back to questions list
- Edit question (type-specific routing)
- Print functionality
- Loading states and smooth transitions

## Technical Implementation

### Route
```php
Route::get('questions/{question}/view', [QuestionController::class, 'commonView'])
    ->name('questions.common-view');
```

### Controller Method
```php
public function commonView(Question $question)
{
    $partnerId = $this->getPartnerId();
    
    if ($question->partner_id !== $partnerId) {
        abort(403, 'Unauthorized access to question.');
    }
    
    $question->load(['course', 'subject', 'topic', 'questionType', 'partner']);
    
    return view('partner.questions.common-question-view', compact('question'));
}
```

### View File
- Location: `resources/views/partner/questions/common-question-view.blade.php`
- Self-contained CSS and JavaScript
- Mobile-responsive design with breakpoints
- Print-friendly styles

## Usage

### From Questions List
All "View" buttons in the questions list (`/questions/all`) now link to the common view:
```php
<a href="{{ route('partner.questions.common-view', $question) }}">
    View Question
</a>
```

### Direct Access
Access any question directly via:
```
/partner/questions/{question_id}/view
```

## Responsive Breakpoints

- **Mobile**: < 768px
- **Tablet**: 768px - 1024px  
- **Desktop**: > 1024px

## Browser Support
- Modern browsers (Chrome, Firefox, Safari, Edge)
- Mobile browsers (iOS Safari, Chrome Mobile)
- Progressive enhancement for older browsers

## Performance Features
- Optimized CSS with minimal external dependencies
- Efficient JavaScript with event delegation
- Lazy loading for images
- Smooth animations using CSS transforms

## Security
- Partner-based access control
- CSRF protection on forms
- XSS prevention through proper escaping
- Authorization checks for question access

## Future Enhancements
- Dark mode support
- Question analytics integration
- Export functionality (PDF, Word)
- Collaborative features
- Advanced filtering and search
