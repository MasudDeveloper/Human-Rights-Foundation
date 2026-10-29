<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Web & PWA Routes
|--------------------------------------------------------------------------
*/
// PWA Manifest Route
Route::get('/manifest.json', function () {
    $manifestPath = public_path('manifest.json');
    if (file_exists($manifestPath)) {
        return response()->file($manifestPath, [
            'Content-Type' => 'application/manifest+json; charset=utf-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
    return response()->json([
        'name' => 'আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন',
        'short_name' => 'মানবাধিকার',
        'start_url' => '/',
        'display' => 'standalone',
        'background_color' => '#06182c',
        'theme_color' => '#06182c',
        'icons' => [
            ['src' => '/images/icon-192.png', 'sizes' => '192x192', 'type' => 'image/png'],
            ['src' => '/images/icon-512.png', 'sizes' => '512x512', 'type' => 'image/png'],
        ],
    ], 200, ['Content-Type' => 'application/manifest+json; charset=utf-8']);
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/track', [HomeController::class, 'track'])->name('track');
Route::post('/track', [HomeController::class, 'track'])->name('track.post');
Route::get('/members-directory', [HomeController::class, 'membersDirectory'])->name('members.directory');
Route::get('/verify-member', [MemberController::class, 'verifySearch'])->name('member.verify');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/notices', [HomeController::class, 'notices'])->name('notices');
Route::get('/notices/{id}', [HomeController::class, 'noticeDetail'])->name('notices.show');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');

// Public printable & ID Card views
Route::get('/complaint/{id}/print', [ComplaintController::class, 'printView'])->name('complaint.print');
Route::get('/member/{id}/print', [MemberController::class, 'printView'])->name('member.print');
Route::get('/member/{id}/id-card', [MemberController::class, 'idCard'])->name('member.id_card');

/*
|--------------------------------------------------------------------------
| User Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| User Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

    // Complaints
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaint/new', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/complaint/store', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/complaint/{id}', [ComplaintController::class, 'show'])->name('complaints.show');

    // Membership
    Route::get('/member/apply', [MemberController::class, 'create'])->name('member.create');
    Route::post('/member/store', [MemberController::class, 'store'])->name('member.store');
    Route::get('/member/{id}', [MemberController::class, 'show'])->name('member.show');
});

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    // Admin & Staff Authorized
    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/dashboard', [AdminController::class, 'dashboard']);

        // Complaints Management
        Route::get('/complaints', [AdminController::class, 'complaints'])->name('admin.complaints');
        Route::get('/complaints/{id}', [AdminController::class, 'complaintDetail'])->name('admin.complaints.show');
        Route::post('/complaints/{id}/status', [AdminController::class, 'updateComplaintStatus'])->name('admin.complaints.status');

        // Members Management & ID Card
        Route::get('/members', [AdminController::class, 'members'])->name('admin.members');
        Route::get('/members/{id}', [AdminController::class, 'memberDetail'])->name('admin.members.show');
        Route::post('/members/{id}/status', [AdminController::class, 'updateMemberStatus'])->name('admin.members.status');
        Route::post('/members/{id}/generate-id', [AdminController::class, 'generateIdCard'])->name('admin.members.generate_id');

        // Users Viewing
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/{id}', [AdminController::class, 'userDetail'])->name('admin.users.show');

        // Notices Management (Dynamic Notices & Optional PDF)
        Route::get('/notices', [AdminController::class, 'notices'])->name('admin.notices');
        Route::get('/notices/create', [AdminController::class, 'createNotice'])->name('admin.notices.create');
        Route::post('/notices', [AdminController::class, 'storeNotice'])->name('admin.notices.store');
        Route::get('/notices/{id}/edit', [AdminController::class, 'editNotice'])->name('admin.notices.edit');
        Route::post('/notices/{id}/update', [AdminController::class, 'updateNotice'])->name('admin.notices.update');
        Route::post('/notices/{id}/delete', [AdminController::class, 'deleteNotice'])->name('admin.notices.delete');
        Route::post('/notices/{id}/toggle-status', [AdminController::class, 'toggleNoticeStatus'])->name('admin.notices.toggle_status');

        // Photo Gallery Management
        Route::get('/gallery', [AdminController::class, 'gallery'])->name('admin.gallery');
        Route::get('/gallery/create', [AdminController::class, 'createGallery'])->name('admin.gallery.create');
        Route::post('/gallery', [AdminController::class, 'storeGallery'])->name('admin.gallery.store');
        Route::get('/gallery/{id}/edit', [AdminController::class, 'editGallery'])->name('admin.gallery.edit');
        Route::post('/gallery/{id}/update', [AdminController::class, 'updateGallery'])->name('admin.gallery.update');
        Route::post('/gallery/{id}/delete', [AdminController::class, 'deleteGallery'])->name('admin.gallery.delete');
        Route::post('/gallery/{id}/toggle-status', [AdminController::class, 'toggleGalleryStatus'])->name('admin.gallery.toggle_status');

        // Leave Impersonation (Available to admin who impersonated)
        Route::post('/leave-impersonation', [AdminController::class, 'leaveImpersonation'])->name('admin.leave_impersonation');

        // Super Admin Exclusives
        Route::middleware('super_admin.auth')->group(function () {
            // Impersonate / Login as user
            Route::post('/users/{id}/impersonate', [AdminController::class, 'impersonateUser'])->name('admin.users.impersonate');

            // Super Admin Edit Member profile
            Route::get('/members/{id}/edit', [AdminController::class, 'editMember'])->name('admin.members.edit');
            Route::post('/members/{id}/update', [AdminController::class, 'updateMember'])->name('admin.members.update');

            // Edit User info
            Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
            Route::post('/users/{id}/update', [AdminController::class, 'updateUser'])->name('admin.users.update');

            // Website Branding, Logo, ID Card & System Settings
            Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
            Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.post');
            Route::get('/settings/id-card', [AdminController::class, 'idCardSettings'])->name('admin.settings.id_card');
            Route::post('/settings/id-card', [AdminController::class, 'updateIdCardSettings'])->name('admin.settings.id_card.post');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Shared Hosting Helper Routes (Run without Terminal)
|--------------------------------------------------------------------------
*/
Route::get('/run-migrate', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();
        return "<div style='font-family:Segoe UI, sans-serif;padding:30px;background:#f0fdf4;border:1px solid #86efac;border-radius:12px;max-width:650px;margin:50px auto;'>
            <h2 style='color:#166534;margin-top:0;'>✅ মাইগ্রেশন সফলভাবে সম্পন্ন হয়েছে!</h2>
            <pre style='background:#ffffff;padding:15px;border-radius:8px;border:1px solid #e5e7eb;color:#1f2937;white-space:pre-wrap;font-family:monospace;'>" . ($output ?: 'Nothing to migrate.') . "</pre>
        </div>";
    } catch (\Throwable $e) {
        return "<div style='font-family:Segoe UI, sans-serif;padding:30px;background:#fef2f2;border:1px solid #fca5a5;border-radius:12px;max-width:650px;margin:50px auto;'>
            <h2 style='color:#991b1b;margin-top:0;'>❌ মাইগ্রেশন এরর:</h2>
            <pre style='background:#ffffff;padding:15px;border-radius:8px;border:1px solid #e5e7eb;color:#dc2626;white-space:pre-wrap;font-family:monospace;'>{$e->getMessage()}</pre>
        </div>";
    }
});

Route::get('/clear-cache', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        return "<div style='font-family:Segoe UI, sans-serif;padding:30px;background:#f0fdf4;border:1px solid #86efac;border-radius:12px;max-width:650px;margin:50px auto;'>
            <h2 style='color:#166534;margin-top:0;'>✅ সকল ক্যাশ সফলভাবে মুছে দেওয়া হয়েছে!</h2>
            <p style='color:#374151;font-size:14px;'>ভিউ ক্যাশ (View), অ্যাপ ক্যাশ (Cache), কনফিগ ক্যাশ (Config) এবং রাউট ক্যাশ (Route) ক্লিয়ার হয়েছে।</p>
        </div>";
    } catch (\Throwable $e) {
        return "<div style='font-family:Segoe UI, sans-serif;padding:30px;background:#fef2f2;border:1px solid #fca5a5;border-radius:12px;max-width:650px;margin:50px auto;'>
            <h2 style='color:#991b1b;margin-top:0;'>❌ ক্যাশ ক্লিয়ার এরর:</h2>
            <pre style='background:#ffffff;padding:15px;border-radius:8px;border:1px solid #e5e7eb;color:#dc2626;white-space:pre-wrap;font-family:monospace;'>{$e->getMessage()}</pre>
        </div>";
    }
});
