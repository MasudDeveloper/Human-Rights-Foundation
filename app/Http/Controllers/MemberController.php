<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $posts = [
            'সদস্য',
            'সহযোগী সদস্য',
            'উপজেলা প্রতিনিধি',
            'জেলা প্রতিনিধি',
            'বিভাগীয় প্রতিনিধি',
            'আইন বিষয়ক সম্পাদক',
            'তদন্ত কর্মকর্তা (CIT)',
            'প্রচার ও প্রকাশনা সম্পাদক',
            'সাধারণ সম্পাদক',
            'সভাপতি',
            'উপদেষ্টা'
        ];

        return view('members.create', compact('user', 'posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_name' => 'required|string',
            'bangla_name' => 'required|string|max:255',
            'english_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'nid' => 'required|string|max:50',
            'date_of_birth' => 'required',
            'district' => 'required|string',
            'thana' => 'required|string',
            'education' => 'required|string',
            'current_job' => 'required|string',
            'payment_gateway' => 'required|string',
            'payment_number' => 'required|string',
            'transaction_id' => 'required|string',
        ], [
            'post_name.required' => 'আবেদনকৃত পদবী নির্বাচন করুন।',
            'bangla_name.required' => 'বাংলায় পূর্ণ নাম লিখুন।',
            'english_name.required' => 'ইংরেজিতে পূর্ণ নাম লিখুন।',
            'phone_number.required' => 'মোবাইল নম্বর দিন।',
            'nid.required' => 'জাতীয় পরিচয়পত্র নম্বর দিন।',
            'district.required' => 'স্থায়ী জেলা দিন।',
            'thana.required' => 'স্থায়ী থানা দিন।',
            'education.required' => 'শিক্ষাগত যোগ্যতা লিখুন।',
            'current_job.required' => 'বর্তমান পেশা লিখুন।',
            'payment_gateway.required' => 'পেমেন্ট মেথড নির্বাচন করুন।',
            'payment_number.required' => 'প্রেরক নম্বর দিন।',
            'transaction_id.required' => 'ট্রানজেকশন আইডি দিন।',
        ]);

        $user = Auth::user();

        $prefix = Setting::get('id_card_prefix', '');

        $member = Member::create([
            'user_id' => $user->id,
            'member_id_card_number' => null, // Generated upon approval
            'id_card_status' => 'not_generated',
            'post_name' => $request->post_name,
            'bangla_name' => $request->bangla_name,
            'english_name' => $request->english_name,
            'father_name' => $request->father_name ?? '',
            'mother_name' => $request->mother_name ?? '',
            'village' => $request->village ?? '',
            'post_office' => $request->post_office ?? '',
            'thana' => $request->thana,
            'district' => $request->district,
            'village2' => $request->village2 ?? '',
            'post_office2' => $request->post_office2 ?? '',
            'thana2' => $request->thana2 ?? '',
            'district2' => $request->district2 ?? '',
            'education' => $request->education,
            'date_of_birth' => $request->date_of_birth,
            'nid' => $request->nid,
            'blood_group' => $request->blood_group ?? '',
            'jonmodag' => $request->jonmodag ?? '',
            'current_job' => $request->current_job,
            'nationality' => $request->nationality ?? 'বাংলাদেশী',
            'passport_number' => $request->passport_number ?? '',
            'marital_status' => $request->marital_status ?? 'অবিবাহিত',
            'spouse_name' => $request->spouse_name ?? '',
            'spouse_number' => $request->spouse_number ?? '',
            'religion' => $request->religion ?? 'ইসলাম',
            'phone_number' => $request->phone_number,
            'office_number' => $request->office_number ?? '',
            'facebook_id' => $request->facebook_id ?? '',
            'email' => $request->email ?? $user->email,
            'reference_name' => $request->reference_name ?? '',
            'youtube_id' => $request->youtube_id ?? '',
            'reference_post' => $request->reference_post ?? '',
            'signature' => $request->signature ?? $request->bangla_name,
            'status' => 'pending',
            'payment_amount' => $request->payment_amount ?? '250',
            'payment_gateway' => $request->payment_gateway,
            'payment_number' => $request->payment_number,
            'transaction_id' => $request->transaction_id,
            'reject_reason' => '',
            'time' => now()->format('d-m-Y h:i A'),
        ]);

        return redirect()->route('member.show', $member->id)
            ->with('success', 'সদস্য হওয়ার আবেদনটি সফলভাবে জমা হয়েছে! আবেদন আইডি: #' . $member->id);
    }

    public function show($id)
    {
        $member = Member::with('user')->findOrFail($id);

        if (Auth::check() && Auth::id() !== $member->user_id && !session('admin_logged_in')) {
            abort(403, 'অননুমোদিত অ্যাক্সেস।');
        }

        return view('members.show', compact('member'));
    }

    public function printView($id)
    {
        $member = Member::with('user')->findOrFail($id);
        return view('members.print', compact('member'));
    }

    /*
    |--------------------------------------------------------------------------
    | Member Digital ID Card View
    |--------------------------------------------------------------------------
    */
    public function idCard($id)
    {
        $member = Member::with('user')->findOrFail($id);

        // Auto generate number if not exists and approved
        if (empty($member->member_id_card_number)) {
            $prefix = Setting::get('id_card_prefix', '');
            $num = str_pad($member->id, 5, '0', STR_PAD_LEFT);
            $member->member_id_card_number = $prefix ? ($prefix . $num) : $num;
            $member->id_card_status = 'generated';
            $member->id_card_issue_date = now()->format('Y-m-d');
            $validityYears = (int) Setting::get('id_card_validity_years', 2);
            $member->id_card_expiry_date = now()->addYears($validityYears)->format('Y-m-d');
            $member->save();
        }

        $settings = [
            'org_name_bn' => Setting::get('org_name_bn', 'আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন'),
            'org_name_en' => Setting::get('org_name_en', 'INTERNATIONAL LEGAL AID & HUMAN RIGHTS FOUNDATION'),
            'licence_no' => Setting::get('licence_no', 'Licence No-s-15472/2026'),
            'org_wing' => Setting::get('org_wing', 'Worldwide Organization'),
            'authorized_signature_name' => Setting::get('authorized_signature_name', 'MOINUR RASHID CHOWDHURY'),
            'authorized_signature_title' => Setting::get('authorized_signature_title', 'Chairman'),
            'authorized_signature_img' => Setting::get('authorized_signature_img', ''),
            'site_phone' => Setting::get('site_phone', '01758343597'),
            'site_email' => Setting::get('site_email', 'manushmanusherjonna@gmail.com'),
            'site_website' => Setting::get('site_website', 'https://internationallegalaidhumanrightsfoundration.org'),
            'id_card_emergency_contact' => Setting::get('id_card_emergency_contact', '01758343597'),
            'id_card_office_address' => Setting::get('id_card_office_address', '37/2, Fayenez Bhabon'),
            'id_card_office_address_2' => Setting::get('id_card_office_address_2', 'lift-08purana Paltan,culbut Road,dhaka'),
        ];

        return view('members.id_card', compact('member', 'settings'));
    }

    /*
    |--------------------------------------------------------------------------
    | Public Member Verification & Search System
    |--------------------------------------------------------------------------
    */
    public function verifySearch(Request $request)
    {
        $query = $request->input('search');
        $member = null;

        if ($query) {
            $member = Member::with('user')
                ->where('status', 'approved')
                ->where(function($q) use ($query) {
                    $q->where('member_id_card_number', $query)
                      ->orWhere('nid', $query)
                      ->orWhere('phone_number', $query)
                      ->orWhere('bangla_name', 'like', "%$query%")
                      ->orWhere('english_name', 'like', "%$query%");
                })
                ->first();
        }

        $settings = [
            'authorized_signature_name' => Setting::get('authorized_signature_name', 'ব্যারিস্টার এ. কে. এম. শহীদুল ইসলাম'),
            'authorized_signature_title' => Setting::get('authorized_signature_title', 'কেন্দ্রীয় মহাসচিব, CIT মানবাধিকার সংস্থা'),
        ];

        return view('members.verify', compact('member', 'query', 'settings'));
    }
}
