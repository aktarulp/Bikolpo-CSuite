<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Question;
use App\Models\Exam;
use App\Models\StudentExamResult;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerDashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated user's ID
        $partnerId = auth()->id();
        
        $stats = [
            'total_questions' => Question::where('partner_id', $partnerId)->count(),

            'total_exams' => Exam::where('partner_id', $partnerId)->count(),
            'total_students' => \App\Models\Student::whereHas('examResults.exam', function($query) use ($partnerId) {
                $query->where('partner_id', $partnerId);
            })->distinct()->count(),
        ];

        $recent_exams = Exam::where('partner_id', $partnerId)
            // ->with('questionSet')
            ->latest()
            ->take(5)
            ->get();

        $recent_results = StudentExamResult::whereHas('exam', function($query) use ($partnerId) {
            $query->where('partner_id', $partnerId);
        })
        ->with(['student', 'exam'])
        ->latest()
        ->take(10)
        ->get();

        return view('partner.dashboard', compact('stats', 'recent_exams', 'recent_results'));
    }

    /**
     * Seed demo students for the current partner
     */
    public function seedDemoStudents()
    {
        try {
            // Get the authenticated user
            $user = Auth::user();
            
            if (!$user || !$user->isPartner()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Partner login required.'
                ], 403);
            }

            // Get the partner associated with the authenticated user
            $partner = Partner::where('user_id', $user->id)->first();
            
            if (!$partner) {
                return response()->json([
                    'success' => false,
                    'message' => 'No partner profile found for the authenticated user.'
                ], 404);
            }

            // Check if students already exist
            $existingCount = Student::where('partner_id', $partner->id)->count();
            
            if ($existingCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Students already exist for this partner ({$existingCount} students found)."
                ], 400);
            }

            // Demo student data
            $demoStudents = [
                [
                    'full_name' => 'আহমেদ রহমান',
                    'student_id' => 'STU' . str_pad($partner->id, 3, '0', STR_PAD_LEFT) . '001',
                    'date_of_birth' => '2005-03-15',
                    'gender' => 'male',
                    'email' => 'ahmed.student' . $partner->id . '@demo.com',
                    'phone' => '+880 1712345678',
                    'address' => 'রংপুর, বাংলাদেশ',
                    'city' => 'রংপুর',
                    'school_college' => 'রংপুর সরকারি কলেজ',
                    'class_grade' => 'Class 12',
                    'parent_name' => 'মোঃ আব্দুল রহমান',
                    'parent_phone' => '+880 1812345678',
                    'status' => 'active',
                    'partner_id' => $partner->id,
                    'user_id' => null,
                ],
                [
                    'full_name' => 'ফাতেমা খাতুন',
                    'student_id' => 'STU' . str_pad($partner->id, 3, '0', STR_PAD_LEFT) . '002',
                    'date_of_birth' => '2006-07-22',
                    'gender' => 'female',
                    'email' => 'fatema.student' . $partner->id . '@demo.com',
                    'phone' => '+880 1723456789',
                    'address' => 'ঢাকা, বাংলাদেশ',
                    'city' => 'ঢাকা',
                    'school_college' => 'ঢাকা সরকারি কলেজ',
                    'class_grade' => 'Class 11',
                    'parent_name' => 'মোঃ আব্দুল খালেক',
                    'parent_phone' => '+880 1823456789',
                    'status' => 'active',
                    'partner_id' => $partner->id,
                    'user_id' => null,
                ],
                [
                    'full_name' => 'সাবরিনা আক্তার',
                    'student_id' => 'STU' . str_pad($partner->id, 3, '0', STR_PAD_LEFT) . '003',
                    'date_of_birth' => '2005-11-08',
                    'gender' => 'female',
                    'email' => 'sabrina.student' . $partner->id . '@demo.com',
                    'phone' => '+880 1734567890',
                    'address' => 'চট্টগ্রাম, বাংলাদেশ',
                    'city' => 'চট্টগ্রাম',
                    'school_college' => 'চট্টগ্রাম সরকারি কলেজ',
                    'class_grade' => 'Class 12',
                    'parent_name' => 'মোঃ আব্দুল মালেক',
                    'parent_phone' => '+880 1834567890',
                    'status' => 'active',
                    'partner_id' => $partner->id,
                    'user_id' => null,
                ],
                [
                    'full_name' => 'রাকিব হাসান',
                    'student_id' => 'STU' . str_pad($partner->id, 3, '0', STR_PAD_LEFT) . '004',
                    'date_of_birth' => '2004-09-12',
                    'gender' => 'male',
                    'email' => 'rakib.student' . $partner->id . '@demo.com',
                    'phone' => '+880 1745678901',
                    'address' => 'সিলেট, বাংলাদেশ',
                    'city' => 'সিলেট',
                    'school_college' => 'সিলেট সরকারি কলেজ',
                    'class_grade' => 'Class 12',
                    'parent_name' => 'মোঃ আব্দুল হামিদ',
                    'parent_phone' => '+880 1845678901',
                    'status' => 'active',
                    'partner_id' => $partner->id,
                    'user_id' => null,
                ],
                [
                    'full_name' => 'নুসরাত জাহান',
                    'student_id' => 'STU' . str_pad($partner->id, 3, '0', STR_PAD_LEFT) . '005',
                    'date_of_birth' => '2006-01-25',
                    'gender' => 'female',
                    'email' => 'nusrat.student' . $partner->id . '@demo.com',
                    'phone' => '+880 1756789012',
                    'address' => 'খুলনা, বাংলাদেশ',
                    'city' => 'খুলনা',
                    'school_college' => 'খুলনা সরকারি কলেজ',
                    'class_grade' => 'Class 11',
                    'parent_name' => 'মোঃ আব্দুল করিম',
                    'parent_phone' => '+880 1856789012',
                    'status' => 'active',
                    'partner_id' => $partner->id,
                    'user_id' => null,
                ]
            ];

            // Create students
            foreach ($demoStudents as $studentData) {
                Student::create($studentData);
            }

            return response()->json([
                'success' => true,
                'message' => 'Demo students created successfully!',
                'count' => count($demoStudents)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating demo students: ' . $e->getMessage()
            ], 500);
        }
    }
}
