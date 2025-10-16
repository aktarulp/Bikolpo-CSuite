<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;

class AdministrativeDivisionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data (disable foreign key checks temporarily)
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Upazila::truncate();
        District::truncate();
        Division::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Bangladesh administrative divisions data - Complete list from bangladesh-geocode
        $divisions = [
            ['name' => 'Chittagong', 'name_bangla' => 'চট্টগ্রাম', 'code' => 'CTG', 'sort_order' => 1],
            ['name' => 'Rajshahi', 'name_bangla' => 'রাজশাহী', 'code' => 'RAJ', 'sort_order' => 2],
            ['name' => 'Khulna', 'name_bangla' => 'খুলনা', 'code' => 'KHU', 'sort_order' => 3],
            ['name' => 'Barisal', 'name_bangla' => 'বরিশাল', 'code' => 'BAR', 'sort_order' => 4],
            ['name' => 'Sylhet', 'name_bangla' => 'সিলেট', 'code' => 'SYL', 'sort_order' => 5],
            ['name' => 'Dhaka', 'name_bangla' => 'ঢাকা', 'code' => 'DHA', 'sort_order' => 6],
            ['name' => 'Rangpur', 'name_bangla' => 'রংপুর', 'code' => 'RAN', 'sort_order' => 7],
            ['name' => 'Mymensingh', 'name_bangla' => 'ময়মনসিংহ', 'code' => 'MYM', 'sort_order' => 8],
        ];

        foreach ($divisions as $divisionData) {
            $division = Division::create($divisionData);
            $this->createDistrictsForDivision($division);
        }
    }

    private function createDistrictsForDivision(Division $division)
    {
        $districtsData = $this->getDistrictsData($division->name);
        
        foreach ($districtsData as $index => $districtData) {
            $district = District::create([
                'division_id' => $division->id,
                'name' => $districtData['name'],
                'name_bangla' => $districtData['name_bangla'],
                'code' => $districtData['code'],
                'sort_order' => $index + 1,
            ]);
            
            $this->createUpazilasForDistrict($district, $districtData['upazilas'] ?? []);
        }
    }

    private function createUpazilasForDistrict(District $district, array $upazilasData)
    {
        foreach ($upazilasData as $index => $upazilaData) {
            Upazila::create([
                'district_id' => $district->id,
                'name' => $upazilaData['name'],
                'name_bangla' => $upazilaData['name_bangla'] ?? null,
                'code' => $upazilaData['code'],
                'sort_order' => $index + 1,
            ]);
        }
    }

    private function getDistrictsData(string $divisionName): array
    {
        // Complete districts data from Bangladesh GeoCode project
        $districtsData = [
            'Chittagong' => [
                [
                    'name' => 'Comilla',
                    'name_bangla' => 'কুমিল্লা',
                    'code' => 'CTG-01',
                    'upazilas' => [
                        ['name' => 'Comilla Sadar', 'name_bangla' => 'কুমিল্লা সদর', 'code' => 'CTG-01-01'],
                        ['name' => 'Laksham', 'name_bangla' => 'লাকসাম', 'code' => 'CTG-01-02'],
                        ['name' => 'Monohargonj', 'name_bangla' => 'মনোহরগঞ্জ', 'code' => 'CTG-01-03'],
                        ['name' => 'Meghna', 'name_bangla' => 'মেঘনা', 'code' => 'CTG-01-04'],
                        ['name' => 'Homna', 'name_bangla' => 'হোমনা', 'code' => 'CTG-01-05'],
                        ['name' => 'Burichang', 'name_bangla' => 'বুড়িচং', 'code' => 'CTG-01-06'],
                        ['name' => 'Debidwar', 'name_bangla' => 'দেবিদ্বার', 'code' => 'CTG-01-07'],
                        ['name' => 'Daudkandi', 'name_bangla' => 'দাউদকান্দি', 'code' => 'CTG-01-08'],
                        ['name' => 'Muradnagar', 'name_bangla' => 'মুরাদনগর', 'code' => 'CTG-01-09'],
                        ['name' => 'Nangalkot', 'name_bangla' => 'নাঙ্গলকোট', 'code' => 'CTG-01-10'],
                        ['name' => 'Chandina', 'name_bangla' => 'চান্দিনা', 'code' => 'CTG-01-11'],
                        ['name' => 'Titas', 'name_bangla' => 'তিতাস', 'code' => 'CTG-01-12'],
                        ['name' => 'Barura', 'name_bangla' => 'বরুড়া', 'code' => 'CTG-01-13'],
                    ]
                ],
                [
                    'name' => 'Feni',
                    'name_bangla' => 'ফেনী',
                    'code' => 'CTG-02',
                    'upazilas' => [
                        ['name' => 'Feni Sadar', 'name_bangla' => 'ফেনী সদর', 'code' => 'CTG-02-01'],
                        ['name' => 'Sonagazi', 'name_bangla' => 'সোনাগাজী', 'code' => 'CTG-02-02'],
                        ['name' => 'Daganbhuiyan', 'name_bangla' => 'দাগনভূঞা', 'code' => 'CTG-02-03'],
                        ['name' => 'Parshuram', 'name_bangla' => 'পরশুরাম', 'code' => 'CTG-02-04'],
                        ['name' => 'Fulgazi', 'name_bangla' => 'ফুলগাজী', 'code' => 'CTG-02-05'],
                        ['name' => 'Chhagalnaiya', 'name_bangla' => 'ছাগলনাইয়া', 'code' => 'CTG-02-06'],
                    ]
                ],
                [
                    'name' => 'Brahmanbaria',
                    'name_bangla' => 'ব্রাহ্মণবাড়িয়া',
                    'code' => 'CTG-03',
                    'upazilas' => [
                        ['name' => 'Brahmanbaria Sadar', 'name_bangla' => 'ব্রাহ্মণবাড়িয়া সদর', 'code' => 'CTG-03-01'],
                        ['name' => 'Kasba', 'name_bangla' => 'কসবা', 'code' => 'CTG-03-02'],
                        ['name' => 'Nasirnagar', 'name_bangla' => 'নাসিরনগর', 'code' => 'CTG-03-03'],
                        ['name' => 'Sarail', 'name_bangla' => 'সরাইল', 'code' => 'CTG-03-04'],
                        ['name' => 'Ashuganj', 'name_bangla' => 'আশুগঞ্জ', 'code' => 'CTG-03-05'],
                        ['name' => 'Akhaura', 'name_bangla' => 'আখাউড়া', 'code' => 'CTG-03-06'],
                        ['name' => 'Nabinagar', 'name_bangla' => 'নবীনগর', 'code' => 'CTG-03-07'],
                        ['name' => 'Bancharampur', 'name_bangla' => 'বাঞ্ছারামপুর', 'code' => 'CTG-03-08'],
                    ]
                ],
                [
                    'name' => 'Rangamati',
                    'name_bangla' => 'রাঙ্গামাটি',
                    'code' => 'CTG-04',
                    'upazilas' => [
                        ['name' => 'Rangamati Sadar', 'name_bangla' => 'রাঙ্গামাটি সদর', 'code' => 'CTG-04-01'],
                        ['name' => 'Kaptai', 'name_bangla' => 'কাপ্তাই', 'code' => 'CTG-04-02'],
                        ['name' => 'Kawkhali', 'name_bangla' => 'কাউখালী', 'code' => 'CTG-04-03'],
                        ['name' => 'Baghaichhari', 'name_bangla' => 'বাঘাইছড়ি', 'code' => 'CTG-04-04'],
                        ['name' => 'Barkal', 'name_bangla' => 'বরকল', 'code' => 'CTG-04-05'],
                        ['name' => 'Langadu', 'name_bangla' => 'লংগদু', 'code' => 'CTG-04-06'],
                        ['name' => 'Rajasthali', 'name_bangla' => 'রাজস্থলী', 'code' => 'CTG-04-07'],
                        ['name' => 'Belaichhari', 'name_bangla' => 'বিলাইছড়ি', 'code' => 'CTG-04-08'],
                        ['name' => 'Juraichhari', 'name_bangla' => 'জুরাইছড়ি', 'code' => 'CTG-04-09'],
                        ['name' => 'Naniarchar', 'name_bangla' => 'নানিয়ারচর', 'code' => 'CTG-04-10'],
                    ]
                ],
                [
                    'name' => 'Noakhali',
                    'name_bangla' => 'নোয়াখালী',
                    'code' => 'CTG-05',
                    'upazilas' => [
                        ['name' => 'Noakhali Sadar', 'name_bangla' => 'নোয়াখালী সদর', 'code' => 'CTG-05-01'],
                        ['name' => 'Companigonj', 'name_bangla' => 'কোম্পানীগঞ্জ', 'code' => 'CTG-05-02'],
                        ['name' => 'Begumganj', 'name_bangla' => 'বেগমগঞ্জ', 'code' => 'CTG-05-03'],
                        ['name' => 'Chatkhil', 'name_bangla' => 'চাটখিল', 'code' => 'CTG-05-04'],
                        ['name' => 'Senbagh', 'name_bangla' => 'সেনবাগ', 'code' => 'CTG-05-05'],
                        ['name' => 'Sonaimuri', 'name_bangla' => 'সোনাইমুড়ি', 'code' => 'CTG-05-06'],
                        ['name' => 'Subarnachar', 'name_bangla' => 'সুবর্ণচর', 'code' => 'CTG-05-07'],
                        ['name' => 'Hatiya', 'name_bangla' => 'হাতিয়া', 'code' => 'CTG-05-08'],
                        ['name' => 'Kabirhat', 'name_bangla' => 'কবিরহাট', 'code' => 'CTG-05-09'],
                    ]
                ],
                [
                    'name' => 'Chandpur',
                    'name_bangla' => 'চাঁদপুর',
                    'code' => 'CTG-06',
                    'upazilas' => [
                        ['name' => 'Chandpur Sadar', 'name_bangla' => 'চাঁদপুর সদর', 'code' => 'CTG-06-01'],
                        ['name' => 'Haimchar', 'name_bangla' => 'হাইমচর', 'code' => 'CTG-06-02'],
                        ['name' => 'Kachua', 'name_bangla' => 'কচুয়া', 'code' => 'CTG-06-03'],
                        ['name' => 'Shahrasti', 'name_bangla' => 'শাহরাস্তি', 'code' => 'CTG-06-04'],
                        ['name' => 'Matlab North', 'name_bangla' => 'মতলব উত্তর', 'code' => 'CTG-06-05'],
                        ['name' => 'Matlab South', 'name_bangla' => 'মতলব দক্ষিণ', 'code' => 'CTG-06-06'],
                        ['name' => 'Faridganj', 'name_bangla' => 'ফরিদগঞ্জ', 'code' => 'CTG-06-07'],
                        ['name' => 'Hajiganj', 'name_bangla' => 'হাজীগঞ্জ', 'code' => 'CTG-06-08'],
                    ]
                ],
                [
                    'name' => 'Lakshmipur',
                    'name_bangla' => 'লক্ষ্মীপুর',
                    'code' => 'CTG-07',
                    'upazilas' => [
                        ['name' => 'Lakshmipur Sadar', 'name_bangla' => 'লক্ষ্মীপুর সদর', 'code' => 'CTG-07-01'],
                        ['name' => 'Kamalnagar', 'name_bangla' => 'কমলনগর', 'code' => 'CTG-07-02'],
                        ['name' => 'Raipur', 'name_bangla' => 'রায়পুর', 'code' => 'CTG-07-03'],
                        ['name' => 'Ramganj', 'name_bangla' => 'রামগঞ্জ', 'code' => 'CTG-07-04'],
                        ['name' => 'Ramgati', 'name_bangla' => 'রামগতি', 'code' => 'CTG-07-05'],
                    ]
                ],
                [
                    'name' => 'Chattogram',
                    'name_bangla' => 'চট্টগ্রাম',
                    'code' => 'CTG-08',
                    'upazilas' => [
                        ['name' => 'Chattogram Sadar', 'name_bangla' => 'চট্টগ্রাম সদর', 'code' => 'CTG-08-01'],
                        ['name' => 'Hathazari', 'name_bangla' => 'হাটহাজারী', 'code' => 'CTG-08-02'],
                        ['name' => 'Raujan', 'name_bangla' => 'রাউজান', 'code' => 'CTG-08-03'],
                        ['name' => 'Fatikchhari', 'name_bangla' => 'ফটিকছড়ি', 'code' => 'CTG-08-04'],
                        ['name' => 'Sandwip', 'name_bangla' => 'সন্দ্বীপ', 'code' => 'CTG-08-05'],
                        ['name' => 'Sitakunda', 'name_bangla' => 'সীতাকুণ্ড', 'code' => 'CTG-08-06'],
                        ['name' => 'Mirsharai', 'name_bangla' => 'মীরসরাই', 'code' => 'CTG-08-07'],
                        ['name' => 'Patiya', 'name_bangla' => 'পটিয়া', 'code' => 'CTG-08-08'],
                        ['name' => 'Banshkhali', 'name_bangla' => 'বাঁশখালী', 'code' => 'CTG-08-09'],
                        ['name' => 'Boalkhali', 'name_bangla' => 'বোয়ালখালী', 'code' => 'CTG-08-10'],
                        ['name' => 'Anwara', 'name_bangla' => 'আনোয়ারা', 'code' => 'CTG-08-11'],
                        ['name' => 'Chandanaish', 'name_bangla' => 'চন্দনাইশ', 'code' => 'CTG-08-12'],
                        ['name' => 'Satkania', 'name_bangla' => 'সাতকানিয়া', 'code' => 'CTG-08-13'],
                        ['name' => 'Lohagara', 'name_bangla' => 'লোহাগাড়া', 'code' => 'CTG-08-14'],
                        ['name' => 'Karnaphuli', 'name_bangla' => 'কর্ণফুলী', 'code' => 'CTG-08-15'],
                    ]
                ],
                [
                    'name' => 'Coxsbazar',
                    'name_bangla' => 'কক্সবাজার',
                    'code' => 'CTG-09',
                    'upazilas' => [
                        ['name' => 'Coxsbazar Sadar', 'name_bangla' => 'কক্সবাজার সদর', 'code' => 'CTG-09-01'],
                        ['name' => 'Chakaria', 'name_bangla' => 'চকরিয়া', 'code' => 'CTG-09-02'],
                        ['name' => 'Kutubdia', 'name_bangla' => 'কুতুবদিয়া', 'code' => 'CTG-09-03'],
                        ['name' => 'Ukhiya', 'name_bangla' => 'উখিয়া', 'code' => 'CTG-09-04'],
                        ['name' => 'Teknaf', 'name_bangla' => 'টেকনাফ', 'code' => 'CTG-09-05'],
                        ['name' => 'Pekua', 'name_bangla' => 'পেকুয়া', 'code' => 'CTG-09-06'],
                        ['name' => 'Ramu', 'name_bangla' => 'রামু', 'code' => 'CTG-09-07'],
                    ]
                ],
                [
                    'name' => 'Khagrachhari',
                    'name_bangla' => 'খাগড়াছড়ি',
                    'code' => 'CTG-10',
                    'upazilas' => [
                        ['name' => 'Khagrachhari Sadar', 'name_bangla' => 'খাগড়াছড়ি সদর', 'code' => 'CTG-10-01'],
                        ['name' => 'Dighinala', 'name_bangla' => 'দিঘিনালা', 'code' => 'CTG-10-02'],
                        ['name' => 'Panchari', 'name_bangla' => 'পানছড়ি', 'code' => 'CTG-10-03'],
                        ['name' => 'Laxmichhari', 'name_bangla' => 'লক্ষীছড়ি', 'code' => 'CTG-10-04'],
                        ['name' => 'Mahalchhari', 'name_bangla' => 'মহালছড়ি', 'code' => 'CTG-10-05'],
                        ['name' => 'Manikchhari', 'name_bangla' => 'মানিকছড়ি', 'code' => 'CTG-10-06'],
                        ['name' => 'Ramgarh', 'name_bangla' => 'রামগড়', 'code' => 'CTG-10-07'],
                        ['name' => 'Matiranga', 'name_bangla' => 'মাটিরাঙ্গা', 'code' => 'CTG-10-08'],
                        ['name' => 'Guimara', 'name_bangla' => 'গুইমারা', 'code' => 'CTG-10-09'],
                    ]
                ],
                [
                    'name' => 'Bandarban',
                    'name_bangla' => 'বান্দরবান',
                    'code' => 'CTG-11',
                    'upazilas' => [
                        ['name' => 'Bandarban Sadar', 'name_bangla' => 'বান্দরবান সদর', 'code' => 'CTG-11-01'],
                        ['name' => 'Lama', 'name_bangla' => 'লামা', 'code' => 'CTG-11-02'],
                        ['name' => 'Nawabganj', 'name_bangla' => 'নবাবগঞ্জ', 'code' => 'CTG-11-03'],
                        ['name' => 'Ruma', 'name_bangla' => 'রুমা', 'code' => 'CTG-11-04'],
                        ['name' => 'Thanchi', 'name_bangla' => 'থানচি', 'code' => 'CTG-11-05'],
                        ['name' => 'Rowangchhari', 'name_bangla' => 'রোয়াংছড়ি', 'code' => 'CTG-11-06'],
                        ['name' => 'Alikadam', 'name_bangla' => 'আলীকদম', 'code' => 'CTG-11-07'],
                    ]
                ],
            ],
            'Rajshahi' => [
                [
                    'name' => 'Sirajganj',
                    'name_bangla' => 'সিরাজগঞ্জ',
                    'code' => 'RAJ-01',
                    'upazilas' => [
                        ['name' => 'Sirajganj Sadar', 'name_bangla' => 'সিরাজগঞ্জ সদর', 'code' => 'RAJ-01-01'],
                        ['name' => 'Belkuchi', 'name_bangla' => 'বেলকুচি', 'code' => 'RAJ-01-02'],
                        ['name' => 'Chauhali', 'name_bangla' => 'চৌহালি', 'code' => 'RAJ-01-03'],
                        ['name' => 'Kamarkhanda', 'name_bangla' => 'কামারখন্দ', 'code' => 'RAJ-01-04'],
                        ['name' => 'Kazipur', 'name_bangla' => 'কাজীপুর', 'code' => 'RAJ-01-05'],
                        ['name' => 'Raiganj', 'name_bangla' => 'রায়গঞ্জ', 'code' => 'RAJ-01-06'],
                        ['name' => 'Shahjadpur', 'name_bangla' => 'শাহজাদপুর', 'code' => 'RAJ-01-07'],
                        ['name' => 'Tarash', 'name_bangla' => 'তারাশ', 'code' => 'RAJ-01-08'],
                        ['name' => 'Ullahpara', 'name_bangla' => 'উল্লাপাড়া', 'code' => 'RAJ-01-09'],
                    ]
                ],
                [
                    'name' => 'Pabna',
                    'name_bangla' => 'পাবনা',
                    'code' => 'RAJ-02',
                    'upazilas' => [
                        ['name' => 'Pabna Sadar', 'name_bangla' => 'পাবনা সদর', 'code' => 'RAJ-02-01'],
                        ['name' => 'Atgharia', 'name_bangla' => 'আটঘরিয়া', 'code' => 'RAJ-02-02'],
                        ['name' => 'Bera', 'name_bangla' => 'বেড়া', 'code' => 'RAJ-02-03'],
                        ['name' => 'Bhangura', 'name_bangla' => 'ভাঙ্গুড়া', 'code' => 'RAJ-02-04'],
                        ['name' => 'Chatmohar', 'name_bangla' => 'চাটমোহর', 'code' => 'RAJ-02-05'],
                        ['name' => 'Faridpur', 'name_bangla' => 'ফরিদপুর', 'code' => 'RAJ-02-06'],
                        ['name' => 'Ishwardi', 'name_bangla' => 'ঈশ্বরদী', 'code' => 'RAJ-02-07'],
                        ['name' => 'Pabna Sadar', 'name_bangla' => 'পাবনা সদর', 'code' => 'RAJ-02-08'],
                        ['name' => 'Santhia', 'name_bangla' => 'সাঁথিয়া', 'code' => 'RAJ-02-09'],
                        ['name' => 'Sujanagar', 'name_bangla' => 'সুজানগর', 'code' => 'RAJ-02-10'],
                    ]
                ],
                [
                    'name' => 'Bogura',
                    'name_bangla' => 'বগুড়া',
                    'code' => 'RAJ-03',
                    'upazilas' => [
                        ['name' => 'Bogura Sadar', 'name_bangla' => 'বগুড়া সদর', 'code' => 'RAJ-03-01'],
                        ['name' => 'Adamdighi', 'name_bangla' => 'আদমদিঘী', 'code' => 'RAJ-03-02'],
                        ['name' => 'Dhunat', 'name_bangla' => 'ধুনট', 'code' => 'RAJ-03-03'],
                        ['name' => 'Dupchanchia', 'name_bangla' => 'দুপচাঁচিয়া', 'code' => 'RAJ-03-04'],
                        ['name' => 'Gabtali', 'name_bangla' => 'গাবতলী', 'code' => 'RAJ-03-05'],
                        ['name' => 'Kahaloo', 'name_bangla' => 'কাহালু', 'code' => 'RAJ-03-06'],
                        ['name' => 'Nandigram', 'name_bangla' => 'নন্দীগ্রাম', 'code' => 'RAJ-03-07'],
                        ['name' => 'Sahajanpur', 'name_bangla' => 'সাহজানপুর', 'code' => 'RAJ-03-08'],
                        ['name' => 'Sariakandi', 'name_bangla' => 'সারিয়াকান্দি', 'code' => 'RAJ-03-09'],
                        ['name' => 'Shibganj', 'name_bangla' => 'শিবগঞ্জ', 'code' => 'RAJ-03-10'],
                        ['name' => 'Sonatala', 'name_bangla' => 'সোনাতলা', 'code' => 'RAJ-03-11'],
                        ['name' => 'Sherpur', 'name_bangla' => 'শেরপুর', 'code' => 'RAJ-03-12'],
                    ]
                ],
                [
                    'name' => 'Rajshahi',
                    'name_bangla' => 'রাজশাহী',
                    'code' => 'RAJ-04',
                    'upazilas' => [
                        ['name' => 'Rajshahi Sadar', 'name_bangla' => 'রাজশাহী সদর', 'code' => 'RAJ-04-01'],
                        ['name' => 'Bagha', 'name_bangla' => 'বাঘা', 'code' => 'RAJ-04-02'],
                        ['name' => 'Bagmara', 'name_bangla' => 'বাগমারা', 'code' => 'RAJ-04-03'],
                        ['name' => 'Charghat', 'name_bangla' => 'চারঘাট', 'code' => 'RAJ-04-04'],
                        ['name' => 'Godagari', 'name_bangla' => 'গোদাগাড়ী', 'code' => 'RAJ-04-05'],
                        ['name' => 'Mohanpur', 'name_bangla' => 'মোহনপুর', 'code' => 'RAJ-04-06'],
                        ['name' => 'Paba', 'name_bangla' => 'পবা', 'code' => 'RAJ-04-07'],
                        ['name' => 'Puthia', 'name_bangla' => 'পুঠিয়া', 'code' => 'RAJ-04-08'],
                        ['name' => 'Tanore', 'name_bangla' => 'তানোর', 'code' => 'RAJ-04-09'],
                    ]
                ],
                [
                    'name' => 'Natore',
                    'name_bangla' => 'নাটোর',
                    'code' => 'RAJ-05',
                    'upazilas' => [
                        ['name' => 'Natore Sadar', 'name_bangla' => 'নাটোর সদর', 'code' => 'RAJ-05-01'],
                        ['name' => 'Baraigram', 'name_bangla' => 'বড়াইগ্রাম', 'code' => 'RAJ-05-02'],
                        ['name' => 'Gurudaspur', 'name_bangla' => 'গুরুদাসপুর', 'code' => 'RAJ-05-03'],
                        ['name' => 'Lalpur', 'name_bangla' => 'লালপুর', 'code' => 'RAJ-05-04'],
                        ['name' => 'Naldanga', 'name_bangla' => 'নলডাঙ্গা', 'code' => 'RAJ-05-05'],
                        ['name' => 'Singra', 'name_bangla' => 'সিংড়া', 'code' => 'RAJ-05-06'],
                    ]
                ],
                [
                    'name' => 'Joypurhat',
                    'name_bangla' => 'জয়পুরহাট',
                    'code' => 'RAJ-06',
                    'upazilas' => [
                        ['name' => 'Joypurhat Sadar', 'name_bangla' => 'জয়পুরহাট সদর', 'code' => 'RAJ-06-01'],
                        ['name' => 'Akkelpur', 'name_bangla' => 'আক্কেলপুর', 'code' => 'RAJ-06-02'],
                        ['name' => 'Kalai', 'name_bangla' => 'কালাই', 'code' => 'RAJ-06-03'],
                        ['name' => 'Khetlal', 'name_bangla' => 'খেতলাল', 'code' => 'RAJ-06-04'],
                        ['name' => 'Panchbibi', 'name_bangla' => 'পাঁচবিবি', 'code' => 'RAJ-06-05'],
                    ]
                ],
                [
                    'name' => 'Chapainawabganj',
                    'name_bangla' => 'চাঁপাইনবাবগঞ্জ',
                    'code' => 'RAJ-07',
                    'upazilas' => [
                        ['name' => 'Chapainawabganj Sadar', 'name_bangla' => 'চাঁপাইনবাবগঞ্জ সদর', 'code' => 'RAJ-07-01'],
                        ['name' => 'Gomastapur', 'name_bangla' => 'গোমস্তাপুর', 'code' => 'RAJ-07-02'],
                        ['name' => 'Nachole', 'name_bangla' => 'নাচোল', 'code' => 'RAJ-07-03'],
                        ['name' => 'Bholahat', 'name_bangla' => 'ভোলাহাট', 'code' => 'RAJ-07-04'],
                        ['name' => 'Shibganj', 'name_bangla' => 'শিবগঞ্জ', 'code' => 'RAJ-07-05'],
                    ]
                ],
                [
                    'name' => 'Naogaon',
                    'name_bangla' => 'নওগাঁ',
                    'code' => 'RAJ-08',
                    'upazilas' => [
                        ['name' => 'Naogaon Sadar', 'name_bangla' => 'নওগাঁ সদর', 'code' => 'RAJ-08-01'],
                        ['name' => 'Atrai', 'name_bangla' => 'আত্রাই', 'code' => 'RAJ-08-02'],
                        ['name' => 'Badalgachhi', 'name_bangla' => 'বদলগাছী', 'code' => 'RAJ-08-03'],
                        ['name' => 'Dhamoirhat', 'name_bangla' => 'ধামইরহাট', 'code' => 'RAJ-08-04'],
                        ['name' => 'Manda', 'name_bangla' => 'মান্দা', 'code' => 'RAJ-08-05'],
                        ['name' => 'Mohadevpur', 'name_bangla' => 'মহাদেবপুর', 'code' => 'RAJ-08-06'],
                        ['name' => 'Niamatpur', 'name_bangla' => 'নিয়ামতপুর', 'code' => 'RAJ-08-07'],
                        ['name' => 'Patnitala', 'name_bangla' => 'পত্নীতলা', 'code' => 'RAJ-08-08'],
                        ['name' => 'Porsha', 'name_bangla' => 'পোরশা', 'code' => 'RAJ-08-09'],
                        ['name' => 'Raninagar', 'name_bangla' => 'রাণীনগর', 'code' => 'RAJ-08-10'],
                        ['name' => 'Sapahar', 'name_bangla' => 'সাপাহার', 'code' => 'RAJ-08-11'],
                    ]
                ],
            ],
            'Khulna' => [
                [
                    'name' => 'Jashore',
                    'name_bangla' => 'যশোর',
                    'code' => 'KHU-01',
                    'upazilas' => [
                        ['name' => 'Jashore Sadar', 'name_bangla' => 'যশোর সদর', 'code' => 'KHU-01-01'],
                        ['name' => 'Abhaynagar', 'name_bangla' => 'অভয়নগর', 'code' => 'KHU-01-02'],
                        ['name' => 'Bagherpara', 'name_bangla' => 'বাঘেরপাড়া', 'code' => 'KHU-01-03'],
                        ['name' => 'Chaugachha', 'name_bangla' => 'চৌগাছা', 'code' => 'KHU-01-04'],
                        ['name' => 'Jhikargachha', 'name_bangla' => 'ঝিকরগাছা', 'code' => 'KHU-01-05'],
                        ['name' => 'Keshabpur', 'name_bangla' => 'কেশবপুর', 'code' => 'KHU-01-06'],
                        ['name' => 'Manirampur', 'name_bangla' => 'মনিরামপুর', 'code' => 'KHU-01-07'],
                        ['name' => 'Sharsha', 'name_bangla' => 'শার্শা', 'code' => 'KHU-01-08'],
                    ]
                ],
                [
                    'name' => 'Satkhira',
                    'name_bangla' => 'সাতক্ষীরা',
                    'code' => 'KHU-02',
                    'upazilas' => [
                        ['name' => 'Satkhira Sadar', 'name_bangla' => 'সাতক্ষীরা সদর', 'code' => 'KHU-02-01'],
                        ['name' => 'Assasuni', 'name_bangla' => 'আশাশুনি', 'code' => 'KHU-02-02'],
                        ['name' => 'Debhata', 'name_bangla' => 'দেবহাটা', 'code' => 'KHU-02-03'],
                        ['name' => 'Kalaroa', 'name_bangla' => 'কলারোয়া', 'code' => 'KHU-02-04'],
                        ['name' => 'Kaliganj', 'name_bangla' => 'কালিগঞ্জ', 'code' => 'KHU-02-05'],
                        ['name' => 'Patkelghata', 'name_bangla' => 'পাটকেলঘাটা', 'code' => 'KHU-02-06'],
                        ['name' => 'Shyamnagar', 'name_bangla' => 'শ্যামনগর', 'code' => 'KHU-02-07'],
                        ['name' => 'Tala', 'name_bangla' => 'তালা', 'code' => 'KHU-02-08'],
                    ]
                ],
                [
                    'name' => 'Meherpur',
                    'name_bangla' => 'মেহেরপুর',
                    'code' => 'KHU-03',
                    'upazilas' => [
                        ['name' => 'Meherpur Sadar', 'name_bangla' => 'মেহেরপুর সদর', 'code' => 'KHU-03-01'],
                        ['name' => 'Gangni', 'name_bangla' => 'গাংনী', 'code' => 'KHU-03-02'],
                        ['name' => 'Mujibnagar', 'name_bangla' => 'মুজিবনগর', 'code' => 'KHU-03-03'],
                    ]
                ],
                [
                    'name' => 'Narail',
                    'name_bangla' => 'নড়াইল',
                    'code' => 'KHU-04',
                    'upazilas' => [
                        ['name' => 'Narail Sadar', 'name_bangla' => 'নড়াইল সদর', 'code' => 'KHU-04-01'],
                        ['name' => 'Kalia', 'name_bangla' => 'কালিয়া', 'code' => 'KHU-04-02'],
                        ['name' => 'Lohagara', 'name_bangla' => 'লোহাগাড়া', 'code' => 'KHU-04-03'],
                    ]
                ],
                [
                    'name' => 'Chuadanga',
                    'name_bangla' => 'চুয়াডাঙ্গা',
                    'code' => 'KHU-05',
                    'upazilas' => [
                        ['name' => 'Chuadanga Sadar', 'name_bangla' => 'চুয়াডাঙ্গা সদর', 'code' => 'KHU-05-01'],
                        ['name' => 'Alamdanga', 'name_bangla' => 'আলমডাঙ্গা', 'code' => 'KHU-05-02'],
                        ['name' => 'Damurhuda', 'name_bangla' => 'দামুড়হুদা', 'code' => 'KHU-05-03'],
                        ['name' => 'Jibannagar', 'name_bangla' => 'জীবননগর', 'code' => 'KHU-05-04'],
                    ]
                ],
                [
                    'name' => 'Kushtia',
                    'name_bangla' => 'কুষ্টিয়া',
                    'code' => 'KHU-06',
                    'upazilas' => [
                        ['name' => 'Kushtia Sadar', 'name_bangla' => 'কুষ্টিয়া সদর', 'code' => 'KHU-06-01'],
                        ['name' => 'Bheramara', 'name_bangla' => 'ভেড়ামারা', 'code' => 'KHU-06-02'],
                        ['name' => 'Daulatpur', 'name_bangla' => 'দৌলতপুর', 'code' => 'KHU-06-03'],
                        ['name' => 'Khoksa', 'name_bangla' => 'খোকসা', 'code' => 'KHU-06-04'],
                        ['name' => 'Kumarkhali', 'name_bangla' => 'কুমারখালী', 'code' => 'KHU-06-05'],
                        ['name' => 'Mirpur', 'name_bangla' => 'মিরপুর', 'code' => 'KHU-06-06'],
                    ]
                ],
                [
                    'name' => 'Magura',
                    'name_bangla' => 'মাগুরা',
                    'code' => 'KHU-07',
                    'upazilas' => [
                        ['name' => 'Magura Sadar', 'name_bangla' => 'মাগুরা সদর', 'code' => 'KHU-07-01'],
                        ['name' => 'Mohammadpur', 'name_bangla' => 'মোহাম্মদপুর', 'code' => 'KHU-07-02'],
                        ['name' => 'Shalikha', 'name_bangla' => 'শালিখা', 'code' => 'KHU-07-03'],
                        ['name' => 'Sreepur', 'name_bangla' => 'শ্রীপুর', 'code' => 'KHU-07-04'],
                    ]
                ],
                [
                    'name' => 'Khulna',
                    'name_bangla' => 'খুলনা',
                    'code' => 'KHU-08',
                    'upazilas' => [
                        ['name' => 'Khulna Sadar', 'name_bangla' => 'খুলনা সদর', 'code' => 'KHU-08-01'],
                        ['name' => 'Batiaghata', 'name_bangla' => 'বাটিয়াঘাটা', 'code' => 'KHU-08-02'],
                        ['name' => 'Dacope', 'name_bangla' => 'দাকোপ', 'code' => 'KHU-08-03'],
                        ['name' => 'Dumuria', 'name_bangla' => 'ডুমুরিয়া', 'code' => 'KHU-08-04'],
                        ['name' => 'Dighalia', 'name_bangla' => 'দিঘলিয়া', 'code' => 'KHU-08-05'],
                        ['name' => 'Koyra', 'name_bangla' => 'কয়রা', 'code' => 'KHU-08-06'],
                        ['name' => 'Paikgachha', 'name_bangla' => 'পাইকগাছা', 'code' => 'KHU-08-07'],
                        ['name' => 'Phultala', 'name_bangla' => 'ফুলতলা', 'code' => 'KHU-08-08'],
                        ['name' => 'Rupsa', 'name_bangla' => 'রূপসা', 'code' => 'KHU-08-09'],
                        ['name' => 'Terokhada', 'name_bangla' => 'তেরখাদা', 'code' => 'KHU-08-10'],
                    ]
                ],
                [
                    'name' => 'Bagerhat',
                    'name_bangla' => 'বাগেরহাট',
                    'code' => 'KHU-09',
                    'upazilas' => [
                        ['name' => 'Bagerhat Sadar', 'name_bangla' => 'বাগেরহাট সদর', 'code' => 'KHU-09-01'],
                        ['name' => 'Chitalmari', 'name_bangla' => 'চিতলমারী', 'code' => 'KHU-09-02'],
                        ['name' => 'Fakirhat', 'name_bangla' => 'ফকিরহাট', 'code' => 'KHU-09-03'],
                        ['name' => 'Kachua', 'name_bangla' => 'কচুয়া', 'code' => 'KHU-09-04'],
                        ['name' => 'Mollahat', 'name_bangla' => 'মোল্লাহাট', 'code' => 'KHU-09-05'],
                        ['name' => 'Mongla', 'name_bangla' => 'মংলা', 'code' => 'KHU-09-06'],
                        ['name' => 'Morrelganj', 'name_bangla' => 'মরেলগঞ্জ', 'code' => 'KHU-09-07'],
                        ['name' => 'Rampal', 'name_bangla' => 'রামপাল', 'code' => 'KHU-09-08'],
                        ['name' => 'Sarankhola', 'name_bangla' => 'সারানখোলা', 'code' => 'KHU-09-09'],
                    ]
                ],
                [
                    'name' => 'Jhenaidah',
                    'name_bangla' => 'ঝিনাইদহ',
                    'code' => 'KHU-10',
                    'upazilas' => [
                        ['name' => 'Jhenaidah Sadar', 'name_bangla' => 'ঝিনাইদহ সদর', 'code' => 'KHU-10-01'],
                        ['name' => 'Harinakunda', 'name_bangla' => 'হরিণাকুণ্ড', 'code' => 'KHU-10-02'],
                        ['name' => 'Kaliganj', 'name_bangla' => 'কালিগঞ্জ', 'code' => 'KHU-10-03'],
                        ['name' => 'Kotchandpur', 'name_bangla' => 'কোটচাঁদপুর', 'code' => 'KHU-10-04'],
                        ['name' => 'Maheshpur', 'name_bangla' => 'মহেশপুর', 'code' => 'KHU-10-05'],
                        ['name' => 'Shailkupa', 'name_bangla' => 'শৈলকুপা', 'code' => 'KHU-10-06'],
                    ]
                ],
            ],
            'Barisal' => [
                [
                    'name' => 'Jhalakathi',
                    'name_bangla' => 'ঝালকাঠি',
                    'code' => 'BAR-01',
                    'upazilas' => [
                        ['name' => 'Jhalakathi Sadar', 'name_bangla' => 'ঝালকাঠি সদর', 'code' => 'BAR-01-01'],
                        ['name' => 'Kathalia', 'name_bangla' => 'কাঠালিয়া', 'code' => 'BAR-01-02'],
                        ['name' => 'Nalchity', 'name_bangla' => 'নলছিটি', 'code' => 'BAR-01-03'],
                        ['name' => 'Rajapur', 'name_bangla' => 'রাজাপুর', 'code' => 'BAR-01-04'],
                    ]
                ],
                [
                    'name' => 'Patuakhali',
                    'name_bangla' => 'পটুয়াখালী',
                    'code' => 'BAR-02',
                    'upazilas' => [
                        ['name' => 'Patuakhali Sadar', 'name_bangla' => 'পটুয়াখালী সদর', 'code' => 'BAR-02-01'],
                        ['name' => 'Bauphal', 'name_bangla' => 'বাউফল', 'code' => 'BAR-02-02'],
                        ['name' => 'Dashmina', 'name_bangla' => 'দশমিনা', 'code' => 'BAR-02-03'],
                        ['name' => 'Galachipa', 'name_bangla' => 'গলাচিপা', 'code' => 'BAR-02-04'],
                        ['name' => 'Kalapara', 'name_bangla' => 'কলাপাড়া', 'code' => 'BAR-02-05'],
                        ['name' => 'Rangabali', 'name_bangla' => 'রাঙ্গাবালী', 'code' => 'BAR-02-06'],
                        ['name' => 'Dumki', 'name_bangla' => 'দুমকি', 'code' => 'BAR-02-07'],
                    ]
                ],
                [
                    'name' => 'Pirojpur',
                    'name_bangla' => 'পিরোজপুর',
                    'code' => 'BAR-03',
                    'upazilas' => [
                        ['name' => 'Pirojpur Sadar', 'name_bangla' => 'পিরোজপুর সদর', 'code' => 'BAR-03-01'],
                        ['name' => 'Bhandaria', 'name_bangla' => 'ভান্ডারিয়া', 'code' => 'BAR-03-02'],
                        ['name' => 'Kawkhali', 'name_bangla' => 'কাউখালী', 'code' => 'BAR-03-03'],
                        ['name' => 'Mathbaria', 'name_bangla' => 'মঠবাড়িয়া', 'code' => 'BAR-03-04'],
                        ['name' => 'Nazirpur', 'name_bangla' => 'নাজিরপুর', 'code' => 'BAR-03-05'],
                        ['name' => 'Nesarabad', 'name_bangla' => 'নেসারাবাদ', 'code' => 'BAR-03-06'],
                        ['name' => 'Zianagar', 'name_bangla' => 'জিয়ানগর', 'code' => 'BAR-03-07'],
                    ]
                ],
                [
                    'name' => 'Barisal',
                    'name_bangla' => 'বরিশাল',
                    'code' => 'BAR-04',
                    'upazilas' => [
                        ['name' => 'Barisal Sadar', 'name_bangla' => 'বরিশাল সদর', 'code' => 'BAR-04-01'],
                        ['name' => 'Agailjhara', 'name_bangla' => 'আগৈলঝাড়া', 'code' => 'BAR-04-02'],
                        ['name' => 'Babuganj', 'name_bangla' => 'বাবুগঞ্জ', 'code' => 'BAR-04-03'],
                        ['name' => 'Bakerganj', 'name_bangla' => 'বাকেরগঞ্জ', 'code' => 'BAR-04-04'],
                        ['name' => 'Banaripara', 'name_bangla' => 'বানারীপাড়া', 'code' => 'BAR-04-05'],
                        ['name' => 'Gaurnadi', 'name_bangla' => 'গৌরনদী', 'code' => 'BAR-04-06'],
                        ['name' => 'Hizla', 'name_bangla' => 'হিজলা', 'code' => 'BAR-04-07'],
                        ['name' => 'Mehendiganj', 'name_bangla' => 'মেহেন্দিগঞ্জ', 'code' => 'BAR-04-08'],
                        ['name' => 'Muladi', 'name_bangla' => 'মুলাদী', 'code' => 'BAR-04-09'],
                        ['name' => 'Wazirpur', 'name_bangla' => 'ওয়াজিরপুর', 'code' => 'BAR-04-10'],
                    ]
                ],
                [
                    'name' => 'Bhola',
                    'name_bangla' => 'ভোলা',
                    'code' => 'BAR-05',
                    'upazilas' => [
                        ['name' => 'Bhola Sadar', 'name_bangla' => 'ভোলা সদর', 'code' => 'BAR-05-01'],
                        ['name' => 'Borhanuddin', 'name_bangla' => 'বোরহানউদ্দিন', 'code' => 'BAR-05-02'],
                        ['name' => 'Char Fasson', 'name_bangla' => 'চরফ্যাশন', 'code' => 'BAR-05-03'],
                        ['name' => 'Daulatkhan', 'name_bangla' => 'দৌলতখান', 'code' => 'BAR-05-04'],
                        ['name' => 'Lalmohan', 'name_bangla' => 'লালমোহন', 'code' => 'BAR-05-05'],
                        ['name' => 'Manpura', 'name_bangla' => 'মনপুরা', 'code' => 'BAR-05-06'],
                        ['name' => 'Tazumuddin', 'name_bangla' => 'তজুমদ্দিন', 'code' => 'BAR-05-07'],
                    ]
                ],
                [
                    'name' => 'Barguna',
                    'name_bangla' => 'বরগুনা',
                    'code' => 'BAR-06',
                    'upazilas' => [
                        ['name' => 'Barguna Sadar', 'name_bangla' => 'বরগুনা সদর', 'code' => 'BAR-06-01'],
                        ['name' => 'Amtali', 'name_bangla' => 'আমতলী', 'code' => 'BAR-06-02'],
                        ['name' => 'Bamna', 'name_bangla' => 'বামনা', 'code' => 'BAR-06-03'],
                        ['name' => 'Betagi', 'name_bangla' => 'বেতাগী', 'code' => 'BAR-06-04'],
                        ['name' => 'Patharghata', 'name_bangla' => 'পাথরঘাটা', 'code' => 'BAR-06-05'],
                        ['name' => 'Taltali', 'name_bangla' => 'তালতলী', 'code' => 'BAR-06-06'],
                    ]
                ],
            ],
            'Sylhet' => [
                [
                    'name' => 'Sylhet',
                    'name_bangla' => 'সিলেট',
                    'code' => 'SYL-01',
                    'upazilas' => [
                        ['name' => 'Sylhet Sadar', 'name_bangla' => 'সিলেট সদর', 'code' => 'SYL-01-01'],
                        ['name' => 'Beanibazar', 'name_bangla' => 'বিয়ানীবাজার', 'code' => 'SYL-01-02'],
                        ['name' => 'Bishwanath', 'name_bangla' => 'বিশ্বনাথ', 'code' => 'SYL-01-03'],
                        ['name' => 'Balaganj', 'name_bangla' => 'বালাগঞ্জ', 'code' => 'SYL-01-04'],
                        ['name' => 'Companigonj', 'name_bangla' => 'কোম্পানীগঞ্জ', 'code' => 'SYL-01-05'],
                        ['name' => 'Fenchuganj', 'name_bangla' => 'ফেঞ্চুগঞ্জ', 'code' => 'SYL-01-06'],
                        ['name' => 'Golapganj', 'name_bangla' => 'গোলাপগঞ্জ', 'code' => 'SYL-01-07'],
                        ['name' => 'Gowainghat', 'name_bangla' => 'গোয়াইনঘাট', 'code' => 'SYL-01-08'],
                        ['name' => 'Jaintiapur', 'name_bangla' => 'জৈন্তাপুর', 'code' => 'SYL-01-09'],
                        ['name' => 'Kanaighat', 'name_bangla' => 'কানাইঘাট', 'code' => 'SYL-01-10'],
                        ['name' => 'Osmani Nagar', 'name_bangla' => 'ওসমানী নগর', 'code' => 'SYL-01-11'],
                        ['name' => 'Zakiganj', 'name_bangla' => 'জকিগঞ্জ', 'code' => 'SYL-01-12'],
                    ]
                ],
                [
                    'name' => 'Moulvibazar',
                    'name_bangla' => 'মৌলভীবাজার',
                    'code' => 'SYL-02',
                    'upazilas' => [
                        ['name' => 'Moulvibazar Sadar', 'name_bangla' => 'মৌলভীবাজার সদর', 'code' => 'SYL-02-01'],
                        ['name' => 'Barlekha', 'name_bangla' => 'বড়লেখা', 'code' => 'SYL-02-02'],
                        ['name' => 'Juri', 'name_bangla' => 'জুড়ি', 'code' => 'SYL-02-03'],
                        ['name' => 'Kamalganj', 'name_bangla' => 'কমলগঞ্জ', 'code' => 'SYL-02-04'],
                        ['name' => 'Kulaura', 'name_bangla' => 'কুলাউড়া', 'code' => 'SYL-02-05'],
                        ['name' => 'Rajnagar', 'name_bangla' => 'রাজনগর', 'code' => 'SYL-02-06'],
                        ['name' => 'Sreemangal', 'name_bangla' => 'শ্রীমঙ্গল', 'code' => 'SYL-02-07'],
                    ]
                ],
                [
                    'name' => 'Habiganj',
                    'name_bangla' => 'হবিগঞ্জ',
                    'code' => 'SYL-03',
                    'upazilas' => [
                        ['name' => 'Habiganj Sadar', 'name_bangla' => 'হবিগঞ্জ সদর', 'code' => 'SYL-03-01'],
                        ['name' => 'Ajmiriganj', 'name_bangla' => 'আজমিরিগঞ্জ', 'code' => 'SYL-03-02'],
                        ['name' => 'Bahubal', 'name_bangla' => 'বাহুবল', 'code' => 'SYL-03-03'],
                        ['name' => 'Baniyachong', 'name_bangla' => 'বানিয়াচং', 'code' => 'SYL-03-04'],
                        ['name' => 'Chunarughat', 'name_bangla' => 'চুনারুঘাট', 'code' => 'SYL-03-05'],
                        ['name' => 'Lakhai', 'name_bangla' => 'লাখাই', 'code' => 'SYL-03-06'],
                        ['name' => 'Madhabpur', 'name_bangla' => 'মাধবপুর', 'code' => 'SYL-03-07'],
                        ['name' => 'Nabiganj', 'name_bangla' => 'নবীগঞ্জ', 'code' => 'SYL-03-08'],
                        ['name' => 'Shaistaganj', 'name_bangla' => 'শায়েস্তাগঞ্জ', 'code' => 'SYL-03-09'],
                    ]
                ],
                [
                    'name' => 'Sunamganj',
                    'name_bangla' => 'সুনামগঞ্জ',
                    'code' => 'SYL-04',
                    'upazilas' => [
                        ['name' => 'Sunamganj Sadar', 'name_bangla' => 'সুনামগঞ্জ সদর', 'code' => 'SYL-04-01'],
                        ['name' => 'Bishwamvarpur', 'name_bangla' => 'বিশ্বম্ভরপুর', 'code' => 'SYL-04-02'],
                        ['name' => 'Chhatak', 'name_bangla' => 'ছাতক', 'code' => 'SYL-04-03'],
                        ['name' => 'Derai', 'name_bangla' => 'দিরাই', 'code' => 'SYL-04-04'],
                        ['name' => 'Dharampasha', 'name_bangla' => 'ধর্মপাশা', 'code' => 'SYL-04-05'],
                        ['name' => 'Dowarabazar', 'name_bangla' => 'দোয়ারাবাজার', 'code' => 'SYL-04-06'],
                        ['name' => 'Jagannathpur', 'name_bangla' => 'জগন্নাথপুর', 'code' => 'SYL-04-07'],
                        ['name' => 'Jamalganj', 'name_bangla' => 'জামালগঞ্জ', 'code' => 'SYL-04-08'],
                        ['name' => 'Sullah', 'name_bangla' => 'সুল্লা', 'code' => 'SYL-04-09'],
                        ['name' => 'Tahirpur', 'name_bangla' => 'তাহিরপুর', 'code' => 'SYL-04-10'],
                    ]
                ],
            ],
            'Rangpur' => [
                [
                    'name' => 'Panchagarh',
                    'name_bangla' => 'পঞ্চগড়',
                    'code' => 'RAN-01',
                    'upazilas' => [
                        ['name' => 'Panchagarh Sadar', 'name_bangla' => 'পঞ্চগড় সদর', 'code' => 'RAN-01-01'],
                        ['name' => 'Atwari', 'name_bangla' => 'আটোয়ারী', 'code' => 'RAN-01-02'],
                        ['name' => 'Boda', 'name_bangla' => 'বোদা', 'code' => 'RAN-01-03'],
                        ['name' => 'Debiganj', 'name_bangla' => 'দেবীগঞ্জ', 'code' => 'RAN-01-04'],
                        ['name' => 'Tetulia', 'name_bangla' => 'তেতুলিয়া', 'code' => 'RAN-01-05'],
                    ]
                ],
                [
                    'name' => 'Dinajpur',
                    'name_bangla' => 'দিনাজপুর',
                    'code' => 'RAN-02',
                    'upazilas' => [
                        ['name' => 'Dinajpur Sadar', 'name_bangla' => 'দিনাজপুর সদর', 'code' => 'RAN-02-01'],
                        ['name' => 'Birampur', 'name_bangla' => 'বিরামপুর', 'code' => 'RAN-02-02'],
                        ['name' => 'Birganj', 'name_bangla' => 'বীরগঞ্জ', 'code' => 'RAN-02-03'],
                        ['name' => 'Biral', 'name_bangla' => 'বিরল', 'code' => 'RAN-02-04'],
                        ['name' => 'Bochaganj', 'name_bangla' => 'বোচাগঞ্জ', 'code' => 'RAN-02-05'],
                        ['name' => 'Chirirbandar', 'name_bangla' => 'চিরিরবন্দর', 'code' => 'RAN-02-06'],
                        ['name' => 'Fulbari', 'name_bangla' => 'ফুলবাড়ী', 'code' => 'RAN-02-07'],
                        ['name' => 'Ghoraghat', 'name_bangla' => 'ঘোড়াঘাট', 'code' => 'RAN-02-08'],
                        ['name' => 'Hakimpur', 'name_bangla' => 'হাকিমপুর', 'code' => 'RAN-02-09'],
                        ['name' => 'Kaharole', 'name_bangla' => 'কাহারোল', 'code' => 'RAN-02-10'],
                        ['name' => 'Khansama', 'name_bangla' => 'খানসামা', 'code' => 'RAN-02-11'],
                        ['name' => 'Nawabganj', 'name_bangla' => 'নবাবগঞ্জ', 'code' => 'RAN-02-12'],
                        ['name' => 'Parbatipur', 'name_bangla' => 'পার্বতীপুর', 'code' => 'RAN-02-13'],
                    ]
                ],
                [
                    'name' => 'Lalmonirhat',
                    'name_bangla' => 'লালমনিরহাট',
                    'code' => 'RAN-03',
                    'upazilas' => [
                        ['name' => 'Lalmonirhat Sadar', 'name_bangla' => 'লালমনিরহাট সদর', 'code' => 'RAN-03-01'],
                        ['name' => 'Aditmari', 'name_bangla' => 'আদিতমারী', 'code' => 'RAN-03-02'],
                        ['name' => 'Hatibandha', 'name_bangla' => 'হাতীবান্ধা', 'code' => 'RAN-03-03'],
                        ['name' => 'Kaliganj', 'name_bangla' => 'কালীগঞ্জ', 'code' => 'RAN-03-04'],
                        ['name' => 'Patgram', 'name_bangla' => 'পাটগ্রাম', 'code' => 'RAN-03-05'],
                    ]
                ],
                [
                    'name' => 'Nilphamari',
                    'name_bangla' => 'নীলফামারী',
                    'code' => 'RAN-04',
                    'upazilas' => [
                        ['name' => 'Nilphamari Sadar', 'name_bangla' => 'নীলফামারী সদর', 'code' => 'RAN-04-01'],
                        ['name' => 'Dimla', 'name_bangla' => 'ডিমলা', 'code' => 'RAN-04-02'],
                        ['name' => 'Domar', 'name_bangla' => 'ডোমার', 'code' => 'RAN-04-03'],
                        ['name' => 'Jaldhaka', 'name_bangla' => 'জলঢাকা', 'code' => 'RAN-04-04'],
                        ['name' => 'Kishoreganj', 'name_bangla' => 'কিশোরগঞ্জ', 'code' => 'RAN-04-05'],
                        ['name' => 'Saidpur', 'name_bangla' => 'সৈয়দপুর', 'code' => 'RAN-04-06'],
                    ]
                ],
                [
                    'name' => 'Gaibandha',
                    'name_bangla' => 'গাইবান্ধা',
                    'code' => 'RAN-05',
                    'upazilas' => [
                        ['name' => 'Gaibandha Sadar', 'name_bangla' => 'গাইবান্ধা সদর', 'code' => 'RAN-05-01'],
                        ['name' => 'Fulchhari', 'name_bangla' => 'ফুলছড়ি', 'code' => 'RAN-05-02'],
                        ['name' => 'Gobindaganj', 'name_bangla' => 'গোবিন্দগঞ্জ', 'code' => 'RAN-05-03'],
                        ['name' => 'Palashbari', 'name_bangla' => 'পলাশবাড়ী', 'code' => 'RAN-05-04'],
                        ['name' => 'Sadullapur', 'name_bangla' => 'সাদুল্লাপুর', 'code' => 'RAN-05-05'],
                        ['name' => 'Saghata', 'name_bangla' => 'সাঘাটা', 'code' => 'RAN-05-06'],
                        ['name' => 'Sundarganj', 'name_bangla' => 'সুন্দরগঞ্জ', 'code' => 'RAN-05-07'],
                    ]
                ],
                [
                    'name' => 'Thakurgaon',
                    'name_bangla' => 'ঠাকুরগাঁও',
                    'code' => 'RAN-06',
                    'upazilas' => [
                        ['name' => 'Thakurgaon Sadar', 'name_bangla' => 'ঠাকুরগাঁও সদর', 'code' => 'RAN-06-01'],
                        ['name' => 'Baliadangi', 'name_bangla' => 'বালিয়াডাঙ্গী', 'code' => 'RAN-06-02'],
                        ['name' => 'Haripur', 'name_bangla' => 'হরিপুর', 'code' => 'RAN-06-03'],
                        ['name' => 'Pirganj', 'name_bangla' => 'পীরগঞ্জ', 'code' => 'RAN-06-04'],
                        ['name' => 'Ranisankail', 'name_bangla' => 'রাণীশংকৈল', 'code' => 'RAN-06-05'],
                    ]
                ],
                [
                    'name' => 'Rangpur',
                    'name_bangla' => 'রংপুর',
                    'code' => 'RAN-07',
                    'upazilas' => [
                        ['name' => 'Rangpur Sadar', 'name_bangla' => 'রংপুর সদর', 'code' => 'RAN-07-01'],
                        ['name' => 'Badarganj', 'name_bangla' => 'বদরগঞ্জ', 'code' => 'RAN-07-02'],
                        ['name' => 'Gangachara', 'name_bangla' => 'গঙ্গাচড়া', 'code' => 'RAN-07-03'],
                        ['name' => 'Kaunia', 'name_bangla' => 'কাউনিয়া', 'code' => 'RAN-07-04'],
                        ['name' => 'Mithapukur', 'name_bangla' => 'মিঠাপুকুর', 'code' => 'RAN-07-05'],
                        ['name' => 'Pirgacha', 'name_bangla' => 'পীরগাছা', 'code' => 'RAN-07-06'],
                        ['name' => 'Pirganj', 'name_bangla' => 'পীরগঞ্জ', 'code' => 'RAN-07-07'],
                        ['name' => 'Taraganj', 'name_bangla' => 'তারাগঞ্জ', 'code' => 'RAN-07-08'],
                    ]
                ],
                [
                    'name' => 'Kurigram',
                    'name_bangla' => 'কুড়িগ্রাম',
                    'code' => 'RAN-08',
                    'upazilas' => [
                        ['name' => 'Kurigram Sadar', 'name_bangla' => 'কুড়িগ্রাম সদর', 'code' => 'RAN-08-01'],
                        ['name' => 'Bhurungamari', 'name_bangla' => 'ভুরুঙ্গামারী', 'code' => 'RAN-08-02'],
                        ['name' => 'Char Rajibpur', 'name_bangla' => 'চর রাজিবপুর', 'code' => 'RAN-08-03'],
                        ['name' => 'Chilmari', 'name_bangla' => 'চিলমারী', 'code' => 'RAN-08-04'],
                        ['name' => 'Fulbari', 'name_bangla' => 'ফুলবাড়ী', 'code' => 'RAN-08-05'],
                        ['name' => 'Nageshwari', 'name_bangla' => 'নাগেশ্বরী', 'code' => 'RAN-08-06'],
                        ['name' => 'Phulbari', 'name_bangla' => 'ফুলবাড়ী', 'code' => 'RAN-08-07'],
                        ['name' => 'Rajarhat', 'name_bangla' => 'রাজারহাট', 'code' => 'RAN-08-08'],
                        ['name' => 'Ulipur', 'name_bangla' => 'উলিপুর', 'code' => 'RAN-08-09'],
                    ]
                ],
            ],
            'Mymensingh' => [
                [
                    'name' => 'Sherpur',
                    'name_bangla' => 'শেরপুর',
                    'code' => 'MYM-01',
                    'upazilas' => [
                        ['name' => 'Sherpur Sadar', 'name_bangla' => 'শেরপুর সদর', 'code' => 'MYM-01-01'],
                        ['name' => 'Jhenaigati', 'name_bangla' => 'ঝিনাইগাতী', 'code' => 'MYM-01-02'],
                        ['name' => 'Nakla', 'name_bangla' => 'নকলা', 'code' => 'MYM-01-03'],
                        ['name' => 'Nalitabari', 'name_bangla' => 'নালিতাবাড়ী', 'code' => 'MYM-01-04'],
                        ['name' => 'Sreebardi', 'name_bangla' => 'শ্রীবর্দী', 'code' => 'MYM-01-05'],
                    ]
                ],
                [
                    'name' => 'Mymensingh',
                    'name_bangla' => 'ময়মনসিংহ',
                    'code' => 'MYM-02',
                    'upazilas' => [
                        ['name' => 'Mymensingh Sadar', 'name_bangla' => 'ময়মনসিংহ সদর', 'code' => 'MYM-02-01'],
                        ['name' => 'Bhaluka', 'name_bangla' => 'ভালুকা', 'code' => 'MYM-02-02'],
                        ['name' => 'Dhobaura', 'name_bangla' => 'ধোবাউড়া', 'code' => 'MYM-02-03'],
                        ['name' => 'Fulbaria', 'name_bangla' => 'ফুলবাড়িয়া', 'code' => 'MYM-02-04'],
                        ['name' => 'Gaffargaon', 'name_bangla' => 'গফরগাঁও', 'code' => 'MYM-02-05'],
                        ['name' => 'Gauripur', 'name_bangla' => 'গৌরীপুর', 'code' => 'MYM-02-06'],
                        ['name' => 'Haluaghat', 'name_bangla' => 'হালুয়াঘাট', 'code' => 'MYM-02-07'],
                        ['name' => 'Ishwarganj', 'name_bangla' => 'ঈশ্বরগঞ্জ', 'code' => 'MYM-02-08'],
                        ['name' => 'Muktagachha', 'name_bangla' => 'মুক্তাগাছা', 'code' => 'MYM-02-09'],
                        ['name' => 'Nandail', 'name_bangla' => 'নান্দাইল', 'code' => 'MYM-02-10'],
                        ['name' => 'Phulpur', 'name_bangla' => 'ফুলপুর', 'code' => 'MYM-02-11'],
                        ['name' => 'Tarakanda', 'name_bangla' => 'তারাকান্দা', 'code' => 'MYM-02-12'],
                    ]
                ],
                [
                    'name' => 'Jamalpur',
                    'name_bangla' => 'জামালপুর',
                    'code' => 'MYM-03',
                    'upazilas' => [
                        ['name' => 'Jamalpur Sadar', 'name_bangla' => 'জামালপুর সদর', 'code' => 'MYM-03-01'],
                        ['name' => 'Bakshiganj', 'name_bangla' => 'বকশীগঞ্জ', 'code' => 'MYM-03-02'],
                        ['name' => 'Dewanganj', 'name_bangla' => 'দেওয়ানগঞ্জ', 'code' => 'MYM-03-03'],
                        ['name' => 'Islampur', 'name_bangla' => 'ইসলামপুর', 'code' => 'MYM-03-04'],
                        ['name' => 'Madarganj', 'name_bangla' => 'মাদারগঞ্জ', 'code' => 'MYM-03-05'],
                        ['name' => 'Melandaha', 'name_bangla' => 'মেলান্দহ', 'code' => 'MYM-03-06'],
                        ['name' => 'Sarishabari', 'name_bangla' => 'সরিষাবাড়ী', 'code' => 'MYM-03-07'],
                    ]
                ],
                [
                    'name' => 'Netrokona',
                    'name_bangla' => 'নেত্রকোণা',
                    'code' => 'MYM-04',
                    'upazilas' => [
                        ['name' => 'Netrokona Sadar', 'name_bangla' => 'নেত্রকোণা সদর', 'code' => 'MYM-04-01'],
                        ['name' => 'Atpara', 'name_bangla' => 'আটপাড়া', 'code' => 'MYM-04-02'],
                        ['name' => 'Barhatta', 'name_bangla' => 'বারহাট্টা', 'code' => 'MYM-04-03'],
                        ['name' => 'Durgapur', 'name_bangla' => 'দুর্গাপুর', 'code' => 'MYM-04-04'],
                        ['name' => 'Khaliajuri', 'name_bangla' => 'খালিয়াজুরী', 'code' => 'MYM-04-05'],
                        ['name' => 'Kalmakanda', 'name_bangla' => 'কলমাকান্দা', 'code' => 'MYM-04-06'],
                        ['name' => 'Kendua', 'name_bangla' => 'কেন্দুয়া', 'code' => 'MYM-04-07'],
                        ['name' => 'Madan', 'name_bangla' => 'মদন', 'code' => 'MYM-04-08'],
                        ['name' => 'Mohanganj', 'name_bangla' => 'মোহনগঞ্জ', 'code' => 'MYM-04-09'],
                        ['name' => 'Purbadhala', 'name_bangla' => 'পূর্বধলা', 'code' => 'MYM-04-10'],
                    ]
                ],
            ],
            'Dhaka' => [
                [
                    'name' => 'Dhaka',
                    'name_bangla' => 'ঢাকা',
                    'code' => 'DHA-01',
                    'upazilas' => [
                        ['name' => 'Dhanmondi', 'name_bangla' => 'ধানমন্ডি', 'code' => 'DHA-01-01'],
                        ['name' => 'Gulshan', 'name_bangla' => 'গুলশান', 'code' => 'DHA-01-02'],
                        ['name' => 'Uttara', 'name_bangla' => 'উত্তরা', 'code' => 'DHA-01-03'],
                        ['name' => 'Banani', 'name_bangla' => 'বনানী', 'code' => 'DHA-01-04'],
                        ['name' => 'Wari', 'name_bangla' => 'ওয়ারী', 'code' => 'DHA-01-05'],
                        ['name' => 'Ramna', 'name_bangla' => 'রমনা', 'code' => 'DHA-01-06'],
                        ['name' => 'Motijheel', 'name_bangla' => 'মতিঝিল', 'code' => 'DHA-01-07'],
                        ['name' => 'Paltan', 'name_bangla' => 'পল্টন', 'code' => 'DHA-01-08'],
                        ['name' => 'Sutrapur', 'name_bangla' => 'সুত্রাপুর', 'code' => 'DHA-01-09'],
                        ['name' => 'Kotwali', 'name_bangla' => 'কোতয়ালী', 'code' => 'DHA-01-10'],
                        ['name' => 'Lalbagh', 'name_bangla' => 'লালবাগ', 'code' => 'DHA-01-11'],
                        ['name' => 'Hazaribagh', 'name_bangla' => 'হাজারীবাগ', 'code' => 'DHA-01-12'],
                        ['name' => 'Chawkbazar', 'name_bangla' => 'চকবাজার', 'code' => 'DHA-01-13'],
                        ['name' => 'Rangamati', 'name_bangla' => 'রাঙ্গামাটি', 'code' => 'DHA-01-14'],
                        ['name' => 'Sabujbagh', 'name_bangla' => 'সবুজবাগ', 'code' => 'DHA-01-15'],
                        ['name' => 'Demra', 'name_bangla' => 'ডেমরা', 'code' => 'DHA-01-16'],
                        ['name' => 'Dohar', 'name_bangla' => 'দোহার', 'code' => 'DHA-01-17'],
                        ['name' => 'Dhamrai', 'name_bangla' => 'ধামরাই', 'code' => 'DHA-01-18'],
                        ['name' => 'Keraniganj', 'name_bangla' => 'কেরানীগঞ্জ', 'code' => 'DHA-01-19'],
                        ['name' => 'Nawabganj', 'name_bangla' => 'নবাবগঞ্জ', 'code' => 'DHA-01-20'],
                        ['name' => 'Savar', 'name_bangla' => 'সাভার', 'code' => 'DHA-01-21'],
                        ['name' => 'Tejgaon', 'name_bangla' => 'তেজগাঁও', 'code' => 'DHA-01-22'],
                        ['name' => 'Tejgaon Industrial Area', 'name_bangla' => 'তেজগাঁও শিল্প এলাকা', 'code' => 'DHA-01-23'],
                        ['name' => 'Shyampur', 'name_bangla' => 'শ্যামপুর', 'code' => 'DHA-01-24'],
                        ['name' => 'Badda', 'name_bangla' => 'বাড্ডা', 'code' => 'DHA-01-25'],
                        ['name' => 'Cantonment', 'name_bangla' => 'ক্যান্টনমেন্ট', 'code' => 'DHA-01-26'],
                        ['name' => 'Pallabi', 'name_bangla' => 'পল্লবী', 'code' => 'DHA-01-27'],
                        ['name' => 'Kafrul', 'name_bangla' => 'কাফরুল', 'code' => 'DHA-01-28'],
                        ['name' => 'Khilgaon', 'name_bangla' => 'খিলগাঁও', 'code' => 'DHA-01-29'],
                        ['name' => 'Rampura', 'name_bangla' => 'রামপুরা', 'code' => 'DHA-01-30'],
                        ['name' => 'Biman Bandar', 'name_bangla' => 'বিমান বন্দর', 'code' => 'DHA-01-31'],
                        ['name' => 'Jatrabari', 'name_bangla' => 'যাত্রাবাড়ী', 'code' => 'DHA-01-32'],
                    ]
                ],
                [
                    'name' => 'Gazipur',
                    'name_bangla' => 'গাজীপুর',
                    'code' => 'DHA-02',
                    'upazilas' => [
                        ['name' => 'Gazipur Sadar', 'name_bangla' => 'গাজীপুর সদর', 'code' => 'DHA-02-01'],
                        ['name' => 'Kapasia', 'name_bangla' => 'কাপাসিয়া', 'code' => 'DHA-02-02'],
                        ['name' => 'Sreepur', 'name_bangla' => 'শ্রীপুর', 'code' => 'DHA-02-03'],
                        ['name' => 'Kaliakair', 'name_bangla' => 'কালিয়াকৈর', 'code' => 'DHA-02-04'],
                        ['name' => 'Tongi', 'name_bangla' => 'টঙ্গী', 'code' => 'DHA-02-05'],
                    ]
                ],
                [
                    'name' => 'Narayanganj',
                    'name_bangla' => 'নারায়ণগঞ্জ',
                    'code' => 'DHA-03',
                    'upazilas' => [
                        ['name' => 'Narayanganj Sadar', 'name_bangla' => 'নারায়ণগঞ্জ সদর', 'code' => 'DHA-03-01'],
                        ['name' => 'Sonargaon', 'name_bangla' => 'সোনারগাঁও', 'code' => 'DHA-03-02'],
                        ['name' => 'Bandar', 'name_bangla' => 'বন্দর', 'code' => 'DHA-03-03'],
                        ['name' => 'Rupganj', 'name_bangla' => 'রূপগঞ্জ', 'code' => 'DHA-03-04'],
                        ['name' => 'Araihazar', 'name_bangla' => 'আড়াইহাজার', 'code' => 'DHA-03-05'],
                    ]
                ],
                [
                    'name' => 'Narsingdi',
                    'name_bangla' => 'নরসিংদী',
                    'code' => 'DHA-04',
                    'upazilas' => [
                        ['name' => 'Narsingdi Sadar', 'name_bangla' => 'নরসিংদী সদর', 'code' => 'DHA-04-01'],
                        ['name' => 'Belabo', 'name_bangla' => 'বেলাবো', 'code' => 'DHA-04-02'],
                        ['name' => 'Monohardi', 'name_bangla' => 'মনোহরদী', 'code' => 'DHA-04-03'],
                        ['name' => 'Palash', 'name_bangla' => 'পলাশ', 'code' => 'DHA-04-04'],
                        ['name' => 'Raipura', 'name_bangla' => 'রায়পুরা', 'code' => 'DHA-04-05'],
                        ['name' => 'Shibpur', 'name_bangla' => 'শিবপুর', 'code' => 'DHA-04-06'],
                    ]
                ],
                [
                    'name' => 'Tangail',
                    'name_bangla' => 'টাঙ্গাইল',
                    'code' => 'DHA-05',
                    'upazilas' => [
                        ['name' => 'Tangail Sadar', 'name_bangla' => 'টাঙ্গাইল সদর', 'code' => 'DHA-05-01'],
                        ['name' => 'Sakhipur', 'name_bangla' => 'সখিপুর', 'code' => 'DHA-05-02'],
                        ['name' => 'Basail', 'name_bangla' => 'বাসাইল', 'code' => 'DHA-05-03'],
                        ['name' => 'Madhupur', 'name_bangla' => 'মধুপুর', 'code' => 'DHA-05-04'],
                        ['name' => 'Ghatail', 'name_bangla' => 'ঘাটাইল', 'code' => 'DHA-05-05'],
                        ['name' => 'Kalihati', 'name_bangla' => 'কালিহাতী', 'code' => 'DHA-05-06'],
                        ['name' => 'Nagarpur', 'name_bangla' => 'নাগরপুর', 'code' => 'DHA-05-07'],
                        ['name' => 'Mirzapur', 'name_bangla' => 'মির্জাপুর', 'code' => 'DHA-05-08'],
                        ['name' => 'Gopalganj', 'name_bangla' => 'গোপালগঞ্জ', 'code' => 'DHA-05-09'],
                        ['name' => 'Delduar', 'name_bangla' => 'দেলদুয়ার', 'code' => 'DHA-05-10'],
                        ['name' => 'Bhuapur', 'name_bangla' => 'ভুয়াপুর', 'code' => 'DHA-05-11'],
                        ['name' => 'Dhanbari', 'name_bangla' => 'ধানবাড়ী', 'code' => 'DHA-05-12'],
                    ]
                ],
            ],
        ];

        return $districtsData[$divisionName] ?? [];
    }
}