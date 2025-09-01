# Bulk Upload Questions Feature - Simplified Two-Step Process

This feature allows partners to upload multiple questions at once using a simplified CSV file format, with a two-step process for easy management.

## ✨ New Simplified Process

### **Step 1: Upload Questions (Easy)**
- Prepare CSV with only question content
- **No need to know course/subject/topic IDs!**
- Questions are automatically saved as drafts
- Simple 6-column format

### **Step 2: Review & Publish (Organized)**
- Review all uploaded questions in one place
- Assign course, subject, and topic using dropdowns
- Set marks and difficulty level
- Publish questions when ready

## Features

- **Simplified CSV Import**: Only 6 required columns instead of 12+
- **Draft Management**: Questions are saved as drafts for review
- **Two-Step Workflow**: Upload first, organize later
- **Bulk Operations**: Select multiple questions for batch operations
- **Smart Validation**: Automatic validation of question data
- **Error Handling**: Detailed error reporting for failed imports
- **Template Download**: Downloadable CSV template with sample data
- **Progress Tracking**: Success/error counts for each import session

## How to Use

### 1. Access the Bulk Upload Feature

Navigate to the Questions page (`/questions/all`) and click the **"Bulk Upload"** button (green button with upload icon).

### 2. Prepare Your CSV File

Your CSV file only needs these **6 essential columns**:

| Column | Required | Description | Example |
|--------|----------|-------------|---------|
| `question_text` | Yes | The actual question text | "What is the capital of France?" |
| `option_a` | Yes | First multiple choice option | "London" |
| `option_b` | Yes | Second multiple choice option | "Paris" |
| `option_c` | Yes | Third multiple choice option | "Berlin" |
| `option_d` | Yes | Fourth multiple choice option | "Madrid" |
| `correct_answer` | Yes | The correct answer (a, b, c, or d) | "b" |

**Optional Column:**
| Column | Required | Description | Example |
|--------|----------|-------------|---------|
| `explanation` | No | Explanation of the answer | "Paris is the capital of France" |

### 3. Download Template

Click the **"Download CSV Template"** button to get a sample CSV file with the correct format and example data.

### 4. Upload Your File

1. Click **"Upload a file"** or drag and drop your CSV file
2. Ensure the file is in CSV format and under 2MB
3. Click **"Upload Questions as Drafts"** to process the file

### 5. Review & Publish Drafts

After upload, you'll be redirected to the **Drafts page** where you can:

1. **Review Questions**: See all uploaded questions in a table format
2. **Assign Metadata**: Use dropdowns to select course, subject, and topic
3. **Set Properties**: Adjust marks and difficulty level
4. **Bulk Operations**: Select multiple questions for batch processing
5. **Publish**: Convert drafts to active questions

## File Requirements

- **Format**: CSV (Comma Separated Values) or TXT
- **Size**: Maximum 2MB
- **Encoding**: UTF-8 recommended
- **Headers**: Must include the 6 required column names exactly as shown above

## CSV Template Example

```csv
question_text,option_a,option_b,option_c,option_d,correct_answer,explanation
"What is the capital of France?","London","Paris","Berlin","Madrid","b","Paris is the capital and largest city of France."
"What is 2 + 2?","3","4","5","6","b","Basic addition: 2 + 2 = 4"
"Which planet is closest to the Sun?","Venus","Mercury","Earth","Mars","b","Mercury is the first planet from the Sun."
```

## Validation Rules

The system validates:
- **Required fields**: All 6 mandatory columns must be present
- **Correct answer format**: Must be 'a', 'b', 'c', or 'd' (case insensitive)
- **Data integrity**: Question text and options cannot be empty

## Error Handling

Common errors and solutions:

| Error | Cause | Solution |
|-------|-------|----------|
| "Missing required headers" | CSV doesn't have all 6 required columns | Use the template and ensure all columns are present |
| "Correct answer must be 'a', 'b', 'c', or 'd'" | Invalid correct answer format | Use only single letters a, b, c, or d |
| "Error processing file" | File format or encoding issue | Ensure file is valid CSV with UTF-8 encoding |

## Best Practices

1. **Start small**: Begin with 5-10 questions to test the process
2. **Use the template**: Download and modify the provided template
3. **Check formatting**: Ensure correct answer uses single letters (a, b, c, d)
4. **Review drafts**: Always review questions before publishing
5. **Batch operations**: Use bulk selection for efficiency

## Workflow Benefits

### **Before (Old Process)**
- ❌ Need to know course/subject/topic IDs
- ❌ Complex 12+ column CSV format
- ❌ Questions published immediately
- ❌ Difficult to make corrections
- ❌ Time-consuming setup

### **After (New Process)**
- ✅ Simple 6-column CSV format
- ✅ No need to know internal IDs
- ✅ Questions saved as drafts for review
- ✅ Easy to organize and categorize
- ✅ Bulk operations for efficiency
- ✅ Two-step process reduces errors

## Technical Details

- **File processing**: Uses PHP's built-in CSV functions for reliability
- **Draft status**: Questions are saved with `status = 'draft'`
- **Partner isolation**: Questions are automatically assigned to the authenticated partner
- **Audit trail**: All questions are marked with the creator's user ID
- **Bulk operations**: Efficient batch processing for metadata assignment

## Support

If you encounter issues:

1. **Check the template**: Ensure your CSV matches the provided template
2. **Verify format**: Confirm correct answer uses single letters (a, b, c, d)
3. **Review errors**: Check the error messages for specific guidance
4. **Start small**: Test with a few questions first

## Navigation

- **Bulk Upload**: `/questions/bulk-upload` - Upload new questions
- **Drafts**: `/questions/drafts` - Review and publish draft questions
- **All Questions**: `/questions/all` - View published questions

---

**The new simplified process makes bulk upload much easier and more user-friendly!** 🎉
