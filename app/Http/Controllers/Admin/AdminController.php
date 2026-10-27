<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\Complaint;
use App\Models\Gallery;
use App\Models\Member;
use App\Models\Notice;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = AdminUser::where('username', $request->username)->first();

        if ($admin && (Hash::check($request->password, $admin->password) || $request->password === $admin->password)) {
            session([
                'admin_logged_in' => true,
                'admin_id' => $admin->id,
                'admin_username' => $admin->username,
                'admin_name' => $admin->name ?: $admin->username,
                'admin_role' => $admin->role ?: 'admin',
            ]);
            return redirect()->route('admin.dashboard')->with('success', 'স্বাগতম, ' . ($admin->name ?: $admin->username) . '! (' . ($admin->role === 'super_admin' ? 'সুপার অ্যাডমিন' : 'সাধারণ অ্যাডমিন') . ')');
        }

        return back()->withErrors(['username' => 'ইউজারনেম বা পাসওয়ার্ড সঠিক নয়।'])->withInput();
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_id', 'admin_username', 'admin_name', 'admin_role']);
        return redirect()->route('admin.login')->with('success', 'অ্যাডমিন থেকে লগআউট সম্পন্ন হয়েছে।');
    }

    public function dashboard()
    {
        $stats = [
            'total_complaints' => Complaint::count(),
            'pending_complaints' => Complaint::where('status', 'pending')->count(),
            'approved_complaints' => Complaint::where('status', 'approved')->count(),
            'investigated_complaints' => Complaint::where('status', 'investigated')->count(),
            'rejected_complaints' => Complaint::where('status', 'rejected')->count(),
            'complete_complaints' => Complaint::where('status', 'complete')->count(),
            'total_members' => Member::count(),
            'pending_members' => Member::where('status', 'pending')->count(),
            'approved_members' => Member::where('status', 'approved')->count(),
            'total_users' => User::count(),
        ];

        $recentComplaints = Complaint::with('user')->latest()->take(6)->get();
        $recentMembers = Member::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentComplaints', 'recentMembers'));
    }

    /*
    |--------------------------------------------------------------------------
    | Complaint Management
    |--------------------------------------------------------------------------
    */
    public function complaints(Request $request)
    {
        $query = Complaint::with(['user', 'accuseds']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('name', 'like', "%$s%")
                  ->orWhere('phone_number', 'like', "%$s%")
                  ->orWhere('transaction_id', 'like', "%$s%")
                  ->orWhere('id', $s);
            });
        }

        $complaints = $query->latest()->paginate(15);

        return view('admin.complaints.index', compact('complaints'));
    }

    public function complaintDetail($id)
    {
        $complaint = Complaint::with(['user', 'accuseds', 'witnesses'])->findOrFail($id);
        return view('admin.complaints.show', compact('complaint'));
    }

    public function updateComplaintStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,investigated,complete',
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->status = $request->status;

        if ($request->status === 'rejected') {
            $complaint->reject_reason = $request->reject_reason ?? 'প্রয়োজনীয় তথ্যের ঘাটতি বা ভুল পেমেন্ট বিবরণী।';
        }

        $complaint->save();

        return back()->with('success', 'অভিযোগের স্ট্যাটাস সফলভাবে আপডেট করা হয়েছে।');
    }

    /*
    |--------------------------------------------------------------------------
    | Member Management & ID Card Generation
    |--------------------------------------------------------------------------
    */
    public function members(Request $request)
    {
        $query = Member::with('user');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('bangla_name', 'like', "%$s%")
                  ->orWhere('english_name', 'like', "%$s%")
                  ->orWhere('phone_number', 'like', "%$s%")
                  ->orWhere('nid', 'like', "%$s%")
                  ->orWhere('member_id_card_number', 'like', "%$s%")
                  ->orWhere('post_name', 'like', "%$s%");
            });
        }

        $members = $query->latest()->paginate(15);

        return view('admin.members.index', compact('members'));
    }

    public function memberDetail($id)
    {
        $member = Member::with('user')->findOrFail($id);
        return view('admin.members.show', compact('member'));
    }

    public function updateMemberStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $member = Member::findOrFail($id);
        $member->status = $request->status;

        if ($request->filled('post_name')) {
            $member->post_name = $request->post_name;
        }

        if ($request->hasFile('id_card_photo')) {
            File::ensureDirectoryExists(public_path('uploads/member_photos'));
            $photoFile = $request->file('id_card_photo');
            $photoName = 'member_' . $member->id . '_' . time() . '.' . $photoFile->getClientOriginalExtension();
            $photoFile->move(public_path('uploads/member_photos'), $photoName);
            $member->id_card_photo = 'uploads/member_photos/' . $photoName;
        }

        if ($request->status === 'approved') {
            // Auto generate ID Card if not generated
            if (empty($member->member_id_card_number)) {
                $prefix = Setting::get('id_card_prefix', '');
                $num = str_pad($member->id, 5, '0', STR_PAD_LEFT);
                $member->member_id_card_number = $prefix ? ($prefix . $num) : $num;
            }
            $member->id_card_status = 'generated';
            $member->id_card_issue_date = $member->id_card_issue_date ?: now()->format('Y-m-d');
            $validityYears = (int) Setting::get('id_card_validity_years', 2);
            $member->id_card_expiry_date = $member->id_card_expiry_date ?: now()->addYears($validityYears)->format('Y-m-d');
        } elseif ($request->status === 'rejected') {
            $member->reject_reason = $request->reject_reason ?? 'আবেদনপত্রে অসম্পূর্ণ তথ্য দেওয়া হয়েছে।';
            $member->id_card_status = 'not_generated';
        }

        $member->save();

        return back()->with('success', 'সদস্য আবেদনের তথ্য ও স্ট্যাটাস সফলভাবে আপডেট করা হয়েছে।');

    }

    public function generateIdCard($id)
    {
        $member = Member::findOrFail($id);
        $prefix = Setting::get('id_card_prefix', '');
        
        if (empty($member->member_id_card_number)) {
            $num = str_pad($member->id, 5, '0', STR_PAD_LEFT);
            $member->member_id_card_number = $prefix ? ($prefix . $num) : $num;
        }
        $member->id_card_status = 'generated';
        $member->id_card_issue_date = now()->format('Y-m-d');
        $validityYears = (int) Setting::get('id_card_validity_years', 2);
        $member->id_card_expiry_date = now()->addYears($validityYears)->format('Y-m-d');
        $member->save();

        return back()->with('success', 'সদস্য আইডি কার্ড সফলভাবে তৈরি হয়েছে! আইডি নম্বর: ' . $member->member_id_card_number);
    }

    /*
    |--------------------------------------------------------------------------
    | Super Admin: Member Profile Edit & Update
    |--------------------------------------------------------------------------
    */
    public function editMember($id)
    {
        $member = Member::with('user')->findOrFail($id);
        return view('admin.members.edit', compact('member'));
    }

    public function updateMember(Request $request, $id)
    {
        $member = Member::with('user')->findOrFail($id);

        $fields = [
            'english_name', 'bangla_name', 'post_name', 'member_id_card_number',
            'id_card_status', 'id_card_issue_date', 'id_card_expiry_date', 'status',
            'phone_number', 'email', 'nid', 'blood_group', 'father_name', 'mother_name',
            'date_of_birth', 'education', 'current_job', 'religion', 'marital_status',
            'village', 'post_office', 'thana', 'district',
            'village2', 'post_office2', 'thana2', 'district2',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $member->{$field} = $request->input($field);
            }
        }

        // Handle Photo upload
        if ($request->hasFile('id_card_photo')) {
            File::ensureDirectoryExists(public_path('uploads/profile'));
            $photoFile = $request->file('id_card_photo');
            $photoName = 'member_' . $member->id . '_' . time() . '.' . $photoFile->getClientOriginalExtension();
            $photoFile->move(public_path('uploads/profile'), $photoName);
            $member->id_card_photo = 'uploads/profile/' . $photoName;

            if ($member->user) {
                $member->user->profile_image = 'uploads/profile/' . $photoName;
                $member->user->save();
            }
        }

        // Sync with linked user account
        if ($member->user) {
            if ($request->filled('english_name') || $request->filled('bangla_name')) {
                $member->user->name = $request->input('english_name') ?: $request->input('bangla_name');
            }
            if ($request->filled('phone_number')) {
                $member->user->number = $request->input('phone_number');
            }
            if ($request->filled('email')) {
                $member->user->email = $request->input('email');
            }
            if ($request->filled('nid')) {
                $member->user->nid_number = $request->input('nid');
            }
            if ($request->filled('date_of_birth')) {
                $member->user->date_of_birth = $request->input('date_of_birth');
            }
            $member->user->save();
        }

        $member->save();

        return redirect()->route('admin.members.show', $member->id)->with('success', 'সদস্যের সম্পূর্ণ প্রোফাইল ও আইডি কার্ডের তথ্য সফলভাবে আপডেট করা হয়েছে।');
    }

    /*
    |--------------------------------------------------------------------------
    | User Management (Admin & Super Admin)
    |--------------------------------------------------------------------------
    */
    public function users(Request $request)
    {
        $query = User::withCount(['complaints', 'members']);

        if ($request->has('search') && $request->search != '') {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('name', 'like', "%$s%")
                  ->orWhere('number', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('nid_number', 'like', "%$s%");
            });
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function userDetail($id)
    {
        $user = User::with(['complaints', 'members'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /*
    |--------------------------------------------------------------------------
    | Super Admin Exclusives: Impersonation & User Edit
    |--------------------------------------------------------------------------
    */
    public function impersonateUser($id)
    {
        $user = User::findOrFail($id);
        Auth::login($user);
        
        $prev = url()->previous();
        session([
            'impersonating_by_admin' => true,
            'original_admin_id' => session('admin_id'),
            'original_admin_username' => session('admin_username'),
            'admin_return_url' => (!empty($prev) && !str_contains($prev, 'login')) ? $prev : route('admin.users.show', $id),
        ]);

        return redirect()->route('dashboard')->with('success', 'সুপার অ্যাডমিন হিসেবে নাগরিক ' . $user->name . '-এর অ্যাকাউন্টে প্রবেশ করেছেন।');
    }

    public function leaveImpersonation()
    {
        Auth::logout();
        $returnUrl = session('admin_return_url', route('admin.users'));
        session()->forget(['impersonating_by_admin', 'original_admin_id', 'original_admin_username', 'admin_return_url']);

        return redirect($returnUrl)->with('success', 'অ্যাডমিন প্যানেলে ফিরে আসা হয়েছে।');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:20|unique:users,number,' . $id,
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'nid_number' => 'required|string|max:50|unique:users,nid_number,' . $id,
            'date_of_birth' => 'required',
        ]);

        $user->name = $request->name;
        $user->number = $request->number;
        $user->email = $request->email;
        $user->nid_number = $request->nid_number;
        $user->date_of_birth = $request->date_of_birth;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Handle photo update if uploaded
        if ($request->hasFile('profile_image')) {
            $pName = uniqid() . '_' . $request->file('profile_image')->getClientOriginalName();
            $request->file('profile_image')->move(public_path('uploads/profile'), $pName);
            $user->profile_image = 'uploads/profile/' . $pName;
        }

        $user->save();

        return redirect()->route('admin.users.show', $id)->with('success', 'নাগরিক তথ্য সফলভাবে আপডেট করা হয়েছে।');
    }

    /*
    |--------------------------------------------------------------------------
    | Super Admin Exclusives: Website Branding, Logo & ID Card Settings
    |--------------------------------------------------------------------------
    */
    public function idCardSettings(Request $request)
    {
        return $this->settings($request);
    }

    public function settings(Request $request)
    {
        $settings = Setting::allKeyed();
        $tab = $request->query('tab', 'branding');
        return view('admin.settings.index', compact('settings', 'tab'));
    }

    public function updateSettings(Request $request)
    {
        File::ensureDirectoryExists(public_path('uploads/settings'));

        // 1. Text & general configuration
        $fields = [
            'org_name_bn',
            'org_name_en',
            'org_wing',
            'site_phone',
            'site_email',
            'site_address',
            'site_slogan',
            'site_facebook',
            'site_youtube',
            'licence_no',
            'site_website',
            'id_card_prefix',
            'id_card_validity_years',
            'authorized_signature_name',
            'authorized_signature_title',
            'id_card_emergency_contact',
            'id_card_office_address',
            'id_card_office_address_2',
            'id_card_instructions',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                Setting::set($field, $request->input($field) ?? '');
            }
        }

        // 2. Main Site Logo Upload
        if ($request->hasFile('site_logo')) {
            $logoFile = $request->file('site_logo');
            $logoName = 'logo_' . time() . '.' . $logoFile->getClientOriginalExtension();
            $logoFile->move(public_path('uploads/settings'), $logoName);
            Setting::set('site_logo', 'uploads/settings/' . $logoName);
        } elseif ($request->boolean('delete_site_logo')) {
            Setting::set('site_logo', 'images/cit_logo.png');
        }

        // 3. Site Favicon Upload
        if ($request->hasFile('site_favicon')) {
            $favFile = $request->file('site_favicon');
            $favName = 'favicon_' . time() . '.' . $favFile->getClientOriginalExtension();
            $favFile->move(public_path('uploads/settings'), $favName);
            Setting::set('site_favicon', 'uploads/settings/' . $favName);
        } elseif ($request->boolean('delete_site_favicon')) {
            Setting::set('site_favicon', 'images/cit_logo.png');
        }

        // 4. Authorized Officer Digital Signature Upload
        if ($request->hasFile('authorized_signature_img')) {
            $sigFile = $request->file('authorized_signature_img');
            $sigName = 'signature_' . time() . '.' . $sigFile->getClientOriginalExtension();
            $sigFile->move(public_path('uploads/settings'), $sigName);
            Setting::set('authorized_signature_img', 'uploads/settings/' . $sigName);
        } elseif ($request->boolean('delete_signature')) {
            Setting::set('authorized_signature_img', '');
        }

        // 5. Official Stamp / Seal Upload
        if ($request->hasFile('authorized_seal_img')) {
            $sealFile = $request->file('authorized_seal_img');
            $sealName = 'seal_' . time() . '.' . $sealFile->getClientOriginalExtension();
            $sealFile->move(public_path('uploads/settings'), $sealName);
            Setting::set('authorized_seal_img', 'uploads/settings/' . $sealName);
        } elseif ($request->boolean('delete_seal')) {
            Setting::set('authorized_seal_img', '');
        }

        $activeTab = $request->input('tab', 'branding');
        return redirect()->route('admin.settings', ['tab' => $activeTab])
            ->with('success', 'ওয়েবসাইট ব্র্যান্ডিং, লোগো ও আইডি কার্ড সেটিংস সফলভাবে সংরক্ষিত হয়েছে।');
    }

    public function updateIdCardSettings(Request $request)
    {
        return $this->updateSettings($request);
    }

    /*
    |--------------------------------------------------------------------------
    | Notice Management (Dynamic Notices & PDF Attachments)
    |--------------------------------------------------------------------------
    */
    public function notices(Request $request)
    {
        $query = Notice::orderBy('published_date', 'desc')->orderBy('id', 'desc');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%");
            });
        }

        $notices = $query->paginate(12)->withQueryString();
        $totalNotices = Notice::count();
        $activeNotices = Notice::where('is_active', true)->count();
        $pdfNotices = Notice::whereNotNull('file_path')->count();

        return view('admin.notices.index', compact('notices', 'totalNotices', 'activeNotices', 'pdfNotices'));
    }

    public function createNotice()
    {
        return view('admin.notices.create');
    }

    public function storeNotice(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'published_date' => 'required|date',
            'pdf_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:25600',
        ]);

        $notice = new Notice();
        $notice->title = $request->title;
        $notice->category = $request->category;
        $notice->description = $request->description;
        $notice->published_date = $request->published_date;
        $notice->is_active = $request->has('is_active') ? $request->boolean('is_active') : true;
        $notice->is_ticker = $request->has('is_ticker') ? $request->boolean('is_ticker') : true;
        $notice->created_by = session('admin_name') ?: session('admin_username');

        // Handle Optional PDF / File Attachment
        if ($request->hasFile('pdf_file')) {
            File::ensureDirectoryExists(public_path('uploads/notices'));
            $file = $request->file('pdf_file');
            $originalName = $file->getClientOriginalName();
            $fileSize = $this->formatBytes($file->getSize());
            $filename = 'notice_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/notices'), $filename);

            $notice->file_path = 'uploads/notices/' . $filename;
            $notice->file_name = $originalName;
            $notice->file_size = $fileSize;
        }

        $notice->save();

        return redirect()->route('admin.notices')->with('success', 'নতুন নোটিশ সফলভাবে প্রকাশ করা হয়েছে!');
    }

    public function editNotice($id)
    {
        $notice = Notice::findOrFail($id);
        return view('admin.notices.edit', compact('notice'));
    }

    public function updateNotice(Request $request, $id)
    {
        $notice = Notice::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'published_date' => 'required|date',
            'pdf_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:25600',
        ]);

        $notice->title = $request->title;
        $notice->category = $request->category;
        $notice->description = $request->description;
        $notice->published_date = $request->published_date;
        $notice->is_active = $request->boolean('is_active');
        $notice->is_ticker = $request->boolean('is_ticker');

        // Handle File Delete
        if ($request->boolean('delete_file') && $notice->file_path) {
            $oldPath = public_path($notice->file_path);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $notice->file_path = null;
            $notice->file_name = null;
            $notice->file_size = null;
        }

        // Handle New File Upload
        if ($request->hasFile('pdf_file')) {
            if ($notice->file_path && File::exists(public_path($notice->file_path))) {
                File::delete(public_path($notice->file_path));
            }
            File::ensureDirectoryExists(public_path('uploads/notices'));
            $file = $request->file('pdf_file');
            $originalName = $file->getClientOriginalName();
            $fileSize = $this->formatBytes($file->getSize());
            $filename = 'notice_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/notices'), $filename);

            $notice->file_path = 'uploads/notices/' . $filename;
            $notice->file_name = $originalName;
            $notice->file_size = $fileSize;
        }

        $notice->save();

        return redirect()->route('admin.notices')->with('success', 'নোটিশ সফলভাবে আপডেট করা হয়েছে!');
    }

    public function deleteNotice($id)
    {
        $notice = Notice::findOrFail($id);
        if ($notice->file_path && File::exists(public_path($notice->file_path))) {
            File::delete(public_path($notice->file_path));
        }
        $notice->delete();

        return back()->with('success', 'নোটিশ সফলভাবে মুছে ফেলা হয়েছে।');
    }

    public function toggleNoticeStatus($id)
    {
        $notice = Notice::findOrFail($id);
        $notice->is_active = !$notice->is_active;
        $notice->save();

        $statusText = $notice->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়';
        return back()->with('success', "নোটিশটি সফলভাবে {$statusText} করা হয়েছে।");
    }

    // ==========================================
    // Photo Gallery Management
    // ==========================================
    public function gallery(Request $request)
    {
        $query = Gallery::orderBy('sort_order', 'asc')->orderBy('event_date', 'desc')->orderBy('id', 'desc');

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%");
            });
        }

        $photos = $query->paginate(12)->withQueryString();
        $totalPhotos = Gallery::count();
        $activePhotos = Gallery::where('is_active', true)->count();
        $categories = Gallery::distinct()->whereNotNull('category')->pluck('category');

        return view('admin.gallery.index', compact('photos', 'totalPhotos', 'activePhotos', 'categories'));
    }

    public function createGallery()
    {
        return view('admin.gallery.create');
    }

    public function storeGallery(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:15360',
            'event_date' => 'nullable|date',
            'sort_order' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $photo = new Gallery();
        $photo->title = $request->title;
        $photo->category = $request->filled('category') ? $request->category : 'কার্যক্রম';
        $photo->description = $request->description;
        $photo->event_date = $request->event_date;
        $photo->sort_order = $request->filled('sort_order') ? (int) $request->sort_order : 0;
        $photo->is_active = $request->has('is_active') ? $request->boolean('is_active') : true;
        $photo->created_by = session('admin_name') ?: session('admin_username');

        if ($request->hasFile('image')) {
            File::ensureDirectoryExists(public_path('uploads/gallery'));
            $file = $request->file('image');
            $filename = 'gallery_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/gallery'), $filename);
            $photo->image_path = 'uploads/gallery/' . $filename;
        }

        $photo->save();

        return redirect()->route('admin.gallery')->with('success', 'নতুন ছবি সফলভাবে গ্যালারিতে যুক্ত করা হয়েছে!');
    }

    public function editGallery($id)
    {
        $photo = Gallery::findOrFail($id);
        return view('admin.gallery.edit', compact('photo'));
    }

    public function updateGallery(Request $request, $id)
    {
        $photo = Gallery::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:15360',
            'event_date' => 'nullable|date',
            'sort_order' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $photo->title = $request->title;
        $photo->category = $request->filled('category') ? $request->category : 'কার্যক্রম';
        $photo->description = $request->description;
        $photo->event_date = $request->event_date;
        $photo->sort_order = $request->filled('sort_order') ? (int) $request->sort_order : 0;
        $photo->is_active = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($photo->image_path && File::exists(public_path($photo->image_path))) {
                File::delete(public_path($photo->image_path));
            }
            File::ensureDirectoryExists(public_path('uploads/gallery'));
            $file = $request->file('image');
            $filename = 'gallery_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/gallery'), $filename);
            $photo->image_path = 'uploads/gallery/' . $filename;
        }

        $photo->save();

        return redirect()->route('admin.gallery')->with('success', 'গ্যালারির ছবি সফলভাবে আপডেট করা হয়েছে!');
    }

    public function deleteGallery($id)
    {
        $photo = Gallery::findOrFail($id);
        if ($photo->image_path && File::exists(public_path($photo->image_path))) {
            File::delete(public_path($photo->image_path));
        }
        $photo->delete();

        return back()->with('success', 'ছবিটি সফলভাবে গ্যালারি থেকে মুছে ফেলা হয়েছে।');
    }

    public function toggleGalleryStatus($id)
    {
        $photo = Gallery::findOrFail($id);
        $photo->is_active = !$photo->is_active;
        $photo->save();

        $statusText = $photo->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়';
        return back()->with('success', "ছবিটি সফলভাবে {$statusText} করা হয়েছে।");
    }

    private function formatBytes($bytes, $precision = 1)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

