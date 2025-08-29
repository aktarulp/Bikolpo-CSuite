<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Partner;
use App\Models\User;

class DemoStudentsSeeder extends Seeder
{
    public function run(): void
    {
        // Bangladeshi names for demo students
        $bangladeshiNames = [
            // Male names
            'Ahmed Rahman', 'Mohammad Ali', 'Abdul Karim', 'Hassan Khan', 'Rashid Ahmed',
            'Imran Hossain', 'Fazal Rahman', 'Shahid Islam', 'Kamal Uddin', 'Nurul Amin',
            'Rafiqul Islam', 'Jahangir Alam', 'Mizanur Rahman', 'Shafiqul Islam', 'Azizul Haque',
            'Mahbubur Rahman', 'Mominul Islam', 'Shahjahan Ali', 'Nasir Uddin', 'Rashidul Islam',
            'Firoz Ahmed', 'Tariqul Islam', 'Shahidul Islam', 'Mamunur Rashid', 'Nazrul Islam',
            'Habibur Rahman', 'Shafiqul Haque', 'Mizanur Rahman', 'Rafiqul Islam', 'Jahangir Alam',
            
            // Female names
            'Fatima Begum', 'Ayesha Rahman', 'Nusrat Jahan', 'Sabina Yasmin', 'Rehana Khatun',
            'Nasreen Akter', 'Shahana Begum', 'Momena Khatun', 'Rashida Begum', 'Fahima Akter',
            'Tahmina Begum', 'Shahida Khatun', 'Mamata Begum', 'Nazma Akter', 'Rahima Begum',
            'Shahana Akter', 'Momena Begum', 'Rashida Khatun', 'Fahima Begum', 'Tahmina Akter',
            'Shahida Begum', 'Mamata Khatun', 'Nazma Begum', 'Rahima Akter', 'Shahana Khatun',
            'Momena Akter', 'Rashida Begum', 'Fahima Khatun', 'Tahmina Begum', 'Shahida Akter',
            
            // Unisex names
            'Rahman Ali', 'Islam Khan', 'Haque Ahmed', 'Uddin Rahman', 'Amin Islam',
            'Karim Hossain', 'Hassan Ali', 'Rashid Khan', 'Imran Ahmed', 'Fazal Rahman',
            'Shahid Islam', 'Kamal Ali', 'Nurul Khan', 'Rafiqul Ahmed', 'Jahangir Rahman',
            'Mizanur Islam', 'Shafiqul Ali', 'Azizul Khan', 'Mahbubur Ahmed', 'Mominul Rahman',
            'Shahjahan Islam', 'Nasir Ali', 'Rashidul Khan', 'Firoz Ahmed', 'Tariqul Rahman',
            'Shahidul Islam', 'Mamunur Ali', 'Nazrul Khan', 'Habibur Ahmed', 'Shafiqul Rahman'
        ];

        // Bangladeshi cities
        $bangladeshiCities = [
            'Dhaka', 'Chittagong', 'Sylhet', 'Rajshahi', 'Khulna',
            'Barisal', 'Rangpur', 'Mymensingh', 'Comilla', 'Noakhali',
            'Jessore', 'Bogra', 'Dinajpur', 'Pabna', 'Kushtia',
            'Faridpur', 'Tangail', 'Narayanganj', 'Gazipur', 'Narsingdi'
        ];

        // Bangladeshi schools/colleges
        $bangladeshiSchools = [
            'Dhaka College', 'Chittagong College', 'Sylhet Government College', 'Rajshahi College',
            'Khulna Government College', 'Barisal Government College', 'Rangpur Government College',
            'Mymensingh Government College', 'Comilla Victoria College', 'Noakhali Government College',
            'Jessore Government College', 'Bogra Government College', 'Dinajpur Government College',
            'Pabna Government College', 'Kushtia Government College', 'Faridpur Government College',
            'Tangail Government College', 'Narayanganj Government College', 'Gazipur Government College',
            'Narsingdi Government College', 'Dhaka Residential Model College', 'Chittagong Government High School',
            'Sylhet Government High School', 'Rajshahi Government High School', 'Khulna Government High School',
            'Barisal Government High School', 'Rangpur Government High School', 'Mymensingh Government High School'
        ];

        // Get or create a demo partner
        $partner = Partner::firstOrCreate(
            ['slug' => 'demo-bangladesh'],
            [
                'name' => 'Demo Bangladesh Institute',
                'email' => 'demo.bangladesh@example.com', // Required field
                'slug' => 'demo-bangladesh',
                'description' => 'Demo institute for testing with Bangladeshi students',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Get or create a demo user for the partner
        $user = User::firstOrCreate(
            ['email' => 'demo.bangladesh@example.com'],
            [
                'name' => 'Demo Bangladesh Admin',
                'email' => 'demo.bangladesh@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'role' => 'partner',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Associate user with partner if not already associated
        if (!$partner->user_id) {
            $partner->update(['user_id' => $user->id]);
        }

        $this->command->info("Creating demo students for partner: {$partner->name}");

        // Create demo students
        for ($i = 0; $i < count($bangladeshiNames); $i++) {
            $name = $bangladeshiNames[$i];
            $city = $bangladeshiCities[array_rand($bangladeshiCities)];
            $school = $bangladeshiSchools[array_rand($bangladeshiSchools)];
            $gender = $this->determineGender($name);
            $dob = $this->generateRandomDOB();
            $classGrade = $this->generateRandomClassGrade();
            
            // Generate unique email for each student
            $email = $this->generateUniqueEmail($name, $i);

            try {
                Student::create([
                    'user_id' => $user->id,
                    'partner_id' => $partner->id,
                    'full_name' => $name,
                    'student_id' => 'BD' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                    'date_of_birth' => $dob,
                    'gender' => $gender,
                    'photo' => null,
                    'email' => $email, // Required field
                    'phone' => '+8801' . rand(3, 9) . rand(10000000, 99999999),
                    'address' => $this->generateRandomAddress($city),
                    'city' => $city,
                    'school_college' => $school,
                    'class_grade' => $classGrade,
                    'parent_name' => $this->generateParentName($name, $gender),
                    'parent_phone' => '+8801' . rand(3, 9) . rand(10000000, 99999999),
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                $this->command->info("Created student: {$name} ({$email})");
            } catch (\Exception $e) {
                $this->command->error("Failed to create student {$name}: " . $e->getMessage());
            }
        }

        $this->command->info("Successfully created demo students with Bangladeshi names!");
    }

    /**
     * Generate unique email for each student
     */
    private function generateUniqueEmail($name, $index): string
    {
        $baseName = strtolower(str_replace(' ', '.', $name));
        $email = $baseName . '.' . $index . '@demo.bd';
        
        // Ensure email is unique by checking if it exists
        $counter = 0;
        while (Student::where('email', $email)->exists()) {
            $counter++;
            $email = $baseName . '.' . $index . '.' . $counter . '@demo.bd';
        }
        
        return $email;
    }

    /**
     * Determine gender based on name patterns
     */
    private function determineGender($name): string
    {
        $femaleSuffixes = ['Begum', 'Khatun', 'Akter', 'Yasmin', 'Jahan'];
        $maleSuffixes = ['Rahman', 'Ali', 'Khan', 'Ahmed', 'Islam', 'Hossain', 'Uddin', 'Amin', 'Karim', 'Hassan', 'Rashid', 'Imran', 'Fazal', 'Shahid', 'Kamal', 'Nurul', 'Rafiqul', 'Jahangir', 'Mizanur', 'Shafiqul', 'Azizul', 'Mahbubur', 'Mominul', 'Shahjahan', 'Nasir', 'Rashidul', 'Firoz', 'Tariqul', 'Shahidul', 'Mamunur', 'Nazrul', 'Habibur'];
        
        foreach ($femaleSuffixes as $suffix) {
            if (str_contains($name, $suffix)) {
                return 'female';
            }
        }
        
        foreach ($maleSuffixes as $suffix) {
            if (str_contains($name, $suffix)) {
                return 'male';
            }
        }
        
        return 'other';
    }

    /**
     * Generate random date of birth (ages 15-25)
     */
    private function generateRandomDOB(): string
    {
        $year = rand(1998, 2008);
        $month = rand(1, 12);
        $day = rand(1, 28); // Safe day range
        
        return sprintf('%04d-%02d-%02d', $year, $month, $day);
    }

    /**
     * Generate random class grade
     */
    private function generateRandomClassGrade(): string
    {
        $grades = ['9', '10', '11', '12', 'HSC', 'A Level'];
        return $grades[array_rand($grades)];
    }

    /**
     * Generate random address
     */
    private function generateRandomAddress($city): string
    {
        $areas = [
            'Dhaka' => ['Gulshan', 'Banani', 'Dhanmondi', 'Mohammadpur', 'Lalmatia', 'Mirpur', 'Uttara', 'Bashundhara'],
            'Chittagong' => ['Agrabad', 'Nasirabad', 'Halishahar', 'Patenga', 'Faujdarhat', 'Pahartali'],
            'Sylhet' => ['Zindabazar', 'Bondor', 'Subhanighat', 'Tilagor', 'Mirabazar'],
            'Rajshahi' => ['Shaheb Bazar', 'Laxmipur', 'Kazihata', 'Binodpur', 'Damkura'],
            'Khulna' => ['Khalishpur', 'Boyra', 'Sonadanga', 'Fultala', 'Dumuria']
        ];
        
        $cityAreas = $areas[$city] ?? ['Central Area', 'Main Street', 'City Center'];
        $area = $cityAreas[array_rand($cityAreas)];
        $houseNumber = rand(1, 999);
        $roadNumber = rand(1, 50);
        
        return "House #{$houseNumber}, Road #{$roadNumber}, {$area}, {$city}";
    }

    /**
     * Generate parent name based on student name and gender
     */
    private function generateParentName($studentName, $gender): string
    {
        $nameParts = explode(' ', $studentName);
        $lastName = end($nameParts);
        
        if ($gender === 'female') {
            return "Mr. " . $this->generateMaleName() . " " . $lastName;
        } else {
            return "Mr. " . $this->generateMaleName() . " " . $lastName;
        }
    }

    /**
     * Generate a male name for parent
     */
    private function generateMaleName(): string
    {
        $maleNames = ['Abdul', 'Mohammad', 'Ahmed', 'Hassan', 'Rashid', 'Imran', 'Fazal', 'Shahid', 'Kamal', 'Nurul', 'Rafiqul', 'Jahangir', 'Mizanur', 'Shafiqul', 'Azizul', 'Mahbubur', 'Mominul', 'Shahjahan', 'Nasir', 'Rashidul', 'Firoz', 'Tariqul', 'Shahidul', 'Mamunur', 'Nazrul', 'Habibur'];
        return $maleNames[array_rand($maleNames)];
    }
}
