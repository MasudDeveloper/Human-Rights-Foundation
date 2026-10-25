<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use App\Models\Member;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with reset and official demo accounts.
     */
    public function run(): void
    {
        // 1. Disable foreign key checks and reset old data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        DB::table('witnesses')->truncate();
        DB::table('accused')->truncate();
        DB::table('complaints')->truncate();
        DB::table('members')->truncate();
        DB::table('users')->truncate();
        DB::table('admin_users')->truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Create Admin and Super Admin Accounts
        AdminUser::create([
            'username' => 'superadmin',
            'name' => 'সুপার অ্যাডমিন (Super Admin)',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
            'is_active' => 1,
        ]);

        AdminUser::create([
            'username' => 'admin',
            'name' => 'অ্যাডমিন অফিসার (Admin Officer)',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => 1,
        ]);

        // 3. Configure Official Organization Settings
        $officialSettings = [
            'site_logo' => 'images/org_logo_new.png',
            'site_favicon' => 'images/org_logo_new.png',
            'org_name_bn' => 'আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন',
            'org_name_en' => 'INTERNATIONAL LEGAL AID & HUMAN RIGHTS FOUNDATION',
            'licence_no' => 'Licence No-s-15472/2026',
            'org_wing' => 'Worldwide Organization',
            'site_phone' => '01758343597',
            'site_email' => 'manushmanusherjonna@gmail.com',
            'site_website' => 'https://internationallegalaidhumanrightsfoundration.org',
            'site_address' => 'Head Office-37/2, Fayenez Bhabon, lift-08purana Paltan,culbut Road,dhaka',
            'site_slogan' => 'ন্যায় বিচার প্রতিষ্ঠায় আপোষহীন',
            'site_facebook' => 'https://facebook.com',
            'site_youtube' => 'https://youtube.com',
            'id_card_prefix' => '',
            'id_card_validity_years' => '2',
            'authorized_signature_name' => 'MOINUR RASHID CHOWDHURY',
            'authorized_signature_title' => 'Chairman',
            'authorized_signature_img' => '',
            'authorized_seal_img' => '',
            'id_card_emergency_contact' => '01758343597',
            'id_card_office_address' => '37/2, Fayenez Bhabon',
            'id_card_office_address_2' => 'lift-08purana Paltan,culbut Road,dhaka',
            'id_card_instructions' => "১. এই পরিচয়পত্রটি আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশনের সম্মানিত সদস্যের দাপ্তরিক পরিচয় হিসেবে গণ্য হবে।\n২. কার্ডটি অহস্তান্তরযোগ্য এবং কেবল অনুমোদিত মেয়াদকাল পর্যন্ত কার্যকর থাকবে।\n৩. সংস্থার গঠনতন্ত্র ও দেশের প্রচলিত আইনবিরোধী কোনো কাজে কার্ডের অপব্যবহার সম্পূর্ণ নিষিদ্ধ ও দণ্ডনীয়।\n৪. যেকোনো ধরণের বেআইনি আচরণে সংশ্লিষ্ট সদস্যের পদ বাতিল বলে গণ্য হবে।",
        ];

        foreach ($officialSettings as $k => $v) {
            Setting::updateOrCreate(['key' => $k], ['value' => $v]);
        }

        // 4. Create 4 Official Demo Member Accounts from User's Sample Cards

        // Member 1: Chairman - MOINUR RASHID CHOWDHURY (ID: 00001)
        $user1 = User::create([
            'name' => 'MOINUR RASHID CHOWDHURY',
            'number' => '01758343597',
            'email' => 'moinur.chowdhury@gmail.com',
            'password' => Hash::make('password123'),
            'nid_number' => '4154976320',
            'date_of_birth' => '1980-05-12',
            'profile_image' => 'uploads/profile/member_1_moinur.jpg',
            'nid_front_image' => 'uploads/nid_front/nid_sample.jpg',
            'nid_back_image' => 'uploads/nid_back/nid_sample.jpg',
        ]);

        Member::create([
            'id' => 1,
            'user_id' => $user1->id,
            'member_id_card_number' => '00001',
            'id_card_photo' => 'uploads/profile/member_1_moinur.jpg',
            'id_card_issue_date' => '2026-01-01',
            'id_card_expiry_date' => '2028-12-31',
            'id_card_status' => 'generated',
            'post_name' => 'Chairman',
            'bangla_name' => 'মঈনুর রশিদ চৌধুরী',
            'english_name' => 'MOINUR RASHID CHOWDHURY',
            'father_name' => 'মো: আব্দুর রশিদ চৌধুরী',
            'mother_name' => 'রাশিদা বেগম',
            'village' => 'পুরাতন পল্টন',
            'post_office' => 'ঢাকা জিপিও',
            'thana' => 'পল্টন',
            'district' => 'ঢাকা',
            'education' => 'স্নাতকোত্তর (LLB)',
            'date_of_birth' => '1980-05-12',
            'nid' => '4154976320',
            'blood_group' => 'AB+',
            'current_job' => 'চেয়ারম্যান, আন্তর্জাতিক মানবাধিকার ফাউন্ডেশন',
            'nationality' => 'বাংলাদেশী',
            'marital_status' => 'বিবাহিত',
            'religion' => 'ইসলাম',
            'phone_number' => '01758343597',
            'email' => 'moinur.chowdhury@gmail.com',
            'status' => 'approved',
            'payment_amount' => '500',
            'payment_gateway' => 'bKash',
            'payment_number' => '01758343597',
            'transaction_id' => 'TRX987654321',
            'reject_reason' => '',
            'time' => '০১/০১/২০২৬',
        ]);

        // Member 2: Vice Chairman - Md.Hafizur Rahman Emam (ID: 00002)
        $user2 = User::create([
            'name' => 'Md.Hafizur Rahman Emam',
            'number' => '01713930225',
            'email' => 'hafizur.emam@gmail.com',
            'password' => Hash::make('password123'),
            'nid_number' => '1921824775',
            'date_of_birth' => '1982-08-15',
            'profile_image' => 'uploads/profile/member_2_hafizur.jpg',
            'nid_front_image' => 'uploads/nid_front/nid_sample.jpg',
            'nid_back_image' => 'uploads/nid_back/nid_sample.jpg',
        ]);

        Member::create([
            'id' => 2,
            'user_id' => $user2->id,
            'member_id_card_number' => '00002',
            'id_card_photo' => 'uploads/profile/member_2_hafizur.jpg',
            'id_card_issue_date' => '2026-01-01',
            'id_card_expiry_date' => '2028-12-31',
            'id_card_status' => 'generated',
            'post_name' => 'Vice Chairman',
            'bangla_name' => 'মো: হাফিজুর রহমান ইমাম',
            'english_name' => 'Md.Hafizur Rahman Emam',
            'father_name' => 'মো: খলিলুর রহমান',
            'mother_name' => 'হাফিজা বেগম',
            'village' => 'কালভার্ট রোড',
            'post_office' => 'ঢাকা জিপিও',
            'thana' => 'পল্টন',
            'district' => 'ঢাকা',
            'education' => 'স্নাতকোত্তর',
            'date_of_birth' => '1982-08-15',
            'nid' => '1921824775',
            'blood_group' => 'O+',
            'current_job' => 'ভাইস চেয়ারম্যান',
            'nationality' => 'বাংলাদেশী',
            'marital_status' => 'বিবাহিত',
            'religion' => 'ইসলাম',
            'phone_number' => '01713930225',
            'email' => 'hafizur.emam@gmail.com',
            'status' => 'approved',
            'payment_amount' => '500',
            'payment_gateway' => 'Nagad',
            'payment_number' => '01713930225',
            'transaction_id' => 'TRX876543210',
            'reject_reason' => '',
            'time' => '০১/০১/২০২৬',
        ]);

        // Member 3: Secretary General - MD.ABDUS SALAM (ID: 00003)
        $user3 = User::create([
            'name' => 'MD.ABDUS SALAM',
            'number' => '01612244142',
            'email' => 'abdus.salam@gmail.com',
            'password' => Hash::make('password123'),
            'nid_number' => '6422783602',
            'date_of_birth' => '1985-03-20',
            'profile_image' => 'uploads/profile/member_4_salam.jpg',
            'nid_front_image' => 'uploads/nid_front/nid_sample.jpg',
            'nid_back_image' => 'uploads/nid_back/nid_sample.jpg',
        ]);

        Member::create([
            'id' => 3,
            'user_id' => $user3->id,
            'member_id_card_number' => '00003',
            'id_card_photo' => 'uploads/profile/member_4_salam.jpg',
            'id_card_issue_date' => '2026-01-01',
            'id_card_expiry_date' => '2028-12-31',
            'id_card_status' => 'generated',
            'post_name' => 'Secretary General',
            'bangla_name' => 'মো: আব্দুস সালাম',
            'english_name' => 'MD.ABDUS SALAM',
            'father_name' => 'মো: আব্দুল কুদ্দুস',
            'mother_name' => 'সালেহা বেগম',
            'village' => 'ফায়েনেজ ভবন, পুরানা পল্টন',
            'post_office' => 'ঢাকা জিপিও',
            'thana' => 'পল্টন',
            'district' => 'ঢাকা',
            'education' => 'স্নাতক (LLB)',
            'date_of_birth' => '1985-03-20',
            'nid' => '6422783602',
            'blood_group' => 'AB+',
            'current_job' => 'মহাসচিব',
            'nationality' => 'বাংলাদেশী',
            'marital_status' => 'বিবাহিত',
            'religion' => 'ইসলাম',
            'phone_number' => '01612244142',
            'email' => 'abdus.salam@gmail.com',
            'status' => 'approved',
            'payment_amount' => '500',
            'payment_gateway' => 'bKash',
            'payment_number' => '01612244142',
            'transaction_id' => 'TRX765432109',
            'reject_reason' => '',
            'time' => '০১/০১/২০২৬',
        ]);

        // Member 4: Secretary - MD.JAHIDUL ISLAM (ID: 00004)
        $user4 = User::create([
            'name' => 'MD.JAHIDUL ISLAM',
            'number' => '01757532482',
            'email' => 'jahidul.islam@gmail.com',
            'password' => Hash::make('password123'),
            'nid_number' => '19916715879001945',
            'date_of_birth' => '1991-11-10',
            'profile_image' => 'uploads/profile/member_3_jahidul.jpg',
            'nid_front_image' => 'uploads/nid_front/nid_sample.jpg',
            'nid_back_image' => 'uploads/nid_back/nid_sample.jpg',
        ]);

        Member::create([
            'id' => 4,
            'user_id' => $user4->id,
            'member_id_card_number' => '00004',
            'id_card_photo' => 'uploads/profile/member_3_jahidul.jpg',
            'id_card_issue_date' => '2026-01-01',
            'id_card_expiry_date' => '2028-12-31',
            'id_card_status' => 'generated',
            'post_name' => 'Secretary',
            'bangla_name' => 'মো: জাহিদুল ইসলাম',
            'english_name' => 'MD.JAHIDUL ISLAM',
            'father_name' => 'মো: সিরাজুল ইসলাম',
            'mother_name' => 'জোহরা বেগম',
            'village' => 'পুরানা পল্টন',
            'post_office' => 'ঢাকা জিপিও',
            'thana' => 'পল্টন',
            'district' => 'ঢাকা',
            'education' => 'স্নাতক',
            'date_of_birth' => '1991-11-10',
            'nid' => '19916715879001945',
            'blood_group' => 'O+',
            'current_job' => 'যুগ্ম সচিব',
            'nationality' => 'বাংলাদেশী',
            'marital_status' => 'বিবাহিত',
            'religion' => 'ইসলাম',
            'phone_number' => '01757532482',
            'email' => 'jahidul.islam@gmail.com',
            'status' => 'approved',
            'payment_amount' => '500',
            'payment_gateway' => 'Rocket',
            'payment_number' => '01757532482',
            'transaction_id' => 'TRX654321098',
            'reject_reason' => '',
            'time' => '০১/০১/২০২৬',
        ]);

        // Default Notices
        \App\Models\Notice::truncate();

        \App\Models\Notice::create([
            'title' => 'অনলাইনে ভুয়া মানবাধিকার কর্মীদের ব্যাপারে সতর্কবার্তা ও অফিশিয়াল আইডি কার্ড যাচাইয়ের নির্দেশিকা',
            'category' => 'জরুরি বিজ্ঞপ্তি',
            'description' => "আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশনের সকল শাখা ও সাধারণ নাগরিকদের অবগতির জন্য জানানো যাচ্ছে যে, কিছু অসাধু ব্যক্তি নিজেদের সংস্থার কর্মী পরিচয় দিয়ে প্রতারণা করার অপচেষ্টা করছে।\n\nসংস্থার যেকোনো কর্মকর্তা বা সদস্যের বৈধতা নিশ্চিত করতে আমাদের ওয়েবসাইটের মেম্বার ভেরিফিকেশন প্যানেল ব্যবহার করুন অথবা তাদের আইডি কার্ডের কিউআর (QR) কোড স্ক্যান করে লাইভ ডাটা যাচাই করুন। কোনো অসঙ্গতি পরিলক্ষিত হলে তাৎক্ষণিক কেন্দ্রীয় হেল্পলাইনে (01758343597) যোগাযোগ করার জন্য অনুরোধ করা হলো।\n\nবিস্তারিত নির্দেশনাবলী ও অফিশিয়াল সার্কুলার নিচের সংযুক্ত পিডিএফ (PDF) নথিতে দেওয়া হলো।",
            'file_path' => 'uploads/notices/notice_guideline.pdf',
            'file_name' => 'member_verification_guideline.pdf',
            'file_size' => '1.2 MB',
            'published_date' => '2026-10-25',
            'is_active' => true,
            'is_ticker' => true,
            'views_count' => 142,
            'created_by' => 'সুপার অ্যাডমিন'
        ]);

        \App\Models\Notice::create([
            'title' => 'জাতিসংঘ ঘোষিত সার্বজনীন মানবাধিকার সনদ বাস্তবায়নে কেন্দ্রীয় সমন্বয় সভা ও প্রতিনিধি সম্মেলন',
            'category' => 'প্রেস বিজ্ঞপ্তি',
            'description' => "আগামী মাসের প্রথম সপ্তাহে সংস্থার কেন্দ্রীয় কার্যালয়ে (ঢাকা পুরানা পল্টন) সকল জেলা ও উপজেলা কমিটির দায়িত্বশীলদের নিয়ে ত্রৈমাসিক প্রতিনিধি সম্মেলন অনুষ্ঠিত হবে। সম্মেলনে সংস্থার বার্ষিক কর্মপরিকল্পনা, তৃণমূল পর্যায়ে প্রান্তিক জনগোষ্ঠীর বিনামূল্যে আইনি সহায়তা জোরদার এবং নতুন সদস্য অন্তর্ভুক্তিকরণ নিয়ে আলোচনা করা হবে।\n\nসকল জেলা সভাপতি ও সাধারণ সম্পাদকগণকে যথাসময়ে উপস্থিত থাকতে বিনীত অনুরোধ জানানো হচ্ছে।",
            'published_date' => '2026-10-22',
            'is_active' => true,
            'is_ticker' => true,
            'views_count' => 89,
            'created_by' => 'সুপার অ্যাডমিন'
        ]);

        \App\Models\Notice::create([
            'title' => 'নারী ও শিশু নির্যাতন প্রতিরোধে বিনামূল্যে আইনি সহায়তা সেল গঠন সংক্রান্ত জরুরি প্রজ্ঞাপন',
            'category' => 'আইনি নির্দেশনা',
            'description' => 'সুপ্রিম কোর্ট ও জেলা জজ আদালতের বিজ্ঞ প্যানেল আইনজীবীদের সমন্বয়ে ফাউন্ডেশনের পক্ষ থেকে বিশেষ আইনি সহায়তা সেল গঠন করা হয়েছে। যেকোনো অসহায় ও নির্যাতিত নাগরিক আমাদের অনলাইন পোর্টালে সরাসরি অভিযোগ দাখিল করে তাৎক্ষণিক আইনি পরামর্শ গ্রহণ করতে পারবেন।',
            'published_date' => '2026-10-18',
            'is_active' => true,
            'is_ticker' => true,
            'views_count' => 56,
            'created_by' => 'সুপার অ্যাডমিন'
        ]);
    }
}
