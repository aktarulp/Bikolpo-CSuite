# Demo Students Seeder with Bangladeshi Names

This seeder creates realistic demo students with authentic Bangladeshi names, addresses, and educational information for testing purposes.

## Features

### 🌟 **Authentic Bangladeshi Names**
- **60 unique names** including male, female, and unisex options
- **Traditional naming patterns** (e.g., Ahmed Rahman, Fatima Begum)
- **Gender detection** based on name suffixes

### 🏫 **Realistic Educational Data**
- **20 major Bangladeshi cities** (Dhaka, Chittagong, Sylhet, etc.)
- **26 authentic schools/colleges** from different regions
- **Class grades** (9, 10, 11, 12, HSC, A Level)

### 📍 **Geographic Details**
- **City-specific areas** (e.g., Gulshan, Banani for Dhaka)
- **Realistic addresses** with house and road numbers
- **Bangladeshi phone numbers** (+880 format)

### 👨‍👩‍👧‍👦 **Family Information**
- **Parent names** generated based on student names
- **Contact information** for parents
- **Age-appropriate** birth dates (15-25 years old)

## Usage

### Option 1: Run All Seeders
```bash
php artisan db:seed
```

### Option 2: Run Only Demo Students Seeder
```bash
php artisan db:seed --class=DemoStudentsSeeder
```

### Option 3: Run Specific Seeder
```bash
php artisan db:seed --class=DemoStudentsSeeder
```

## What Gets Created

1. **Demo Partner**: "Demo Bangladesh Institute"
2. **Demo User**: Admin account for the partner
3. **60 Demo Students** with:
   - Unique student IDs (BD0001, BD0002, etc.)
   - Authentic Bangladeshi names
   - Realistic addresses and contact info
   - Educational background details

## Sample Data

### Example Student
```json
{
  "full_name": "Ahmed Rahman",
  "student_id": "BD0001",
  "gender": "male",
  "city": "Dhaka",
  "school_college": "Dhaka College",
  "class_grade": "12",
  "address": "House #123, Road #15, Gulshan, Dhaka",
  "phone": "+8801712345678",
  "email": "ahmed.rahman@demo.bd"
}
```

## Customization

You can modify the seeder to:
- Add more names to the `$bangladeshiNames` array
- Include additional cities in `$bangladeshiCities`
- Add more schools in `$bangladeshiSchools`
- Adjust age ranges in `generateRandomDOB()`
- Modify address generation logic

## Database Requirements

Make sure you have:
- `partners` table
- `users` table  
- `students` table

## Notes

- The seeder is **idempotent** - running it multiple times won't create duplicates
- All students are created under the "Demo Bangladesh Institute" partner
- Passwords for demo accounts are set to "password"
- All students have "active" status

## Troubleshooting

If you encounter issues:
1. Check that all required tables exist
2. Ensure the database connection is working
3. Verify that the Partner and User models are accessible
4. Check for any validation errors in the Student model

## Support

For questions or issues with the seeder, check:
- Laravel logs in `storage/logs/`
- Database error messages
- Model validation rules
