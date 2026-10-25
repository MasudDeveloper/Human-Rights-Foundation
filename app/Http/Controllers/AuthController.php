<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ], [
            'login.required' => 'ফোন নম্বর অথবা ইমেইল প্রদান করুন।',
            'password.required' => 'পাসওয়ার্ড প্রদান করুন।',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        // Allow login by number or email
        $user = User::where('number', $login)
            ->orWhere('email', $login)
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('success', 'স্বাগতম, ' . $user->name . '!');
        }

        return back()->withErrors([
            'login' => 'প্রদত্ত তথ্য সঠিক নয়। ফোন নম্বর/ইমেইল এবং পাসওয়ার্ড পুনরায় পরীক্ষা করুন।',
        ])->withInput($request->only('login'));
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:20|unique:users,number',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'nid_number' => 'required|string|max:30|unique:users,nid_number',
            'date_of_birth' => 'required',
            'profile_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'nid_front_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'nid_back_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ], [
            'name.required' => 'আপনার পূর্ণ নাম লিখুন।',
            'number.required' => 'মোবাইল নম্বর দিন।',
            'number.unique' => 'এই মোবাইল নম্বরটি ইতিমধ্যে নিবন্ধিত রয়েছে।',
            'email.required' => 'ইমেইল এড্রেস দিন।',
            'email.unique' => 'এই ইমেইলটি ইতিমধ্যে নিবন্ধিত রয়েছে।',
            'password.required' => 'পাসওয়ার্ড দিন।',
            'password.min' => 'পাসওয়ার্ড ন্যূনতম ৬ অক্ষরের হতে হবে।',
            'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না।',
            'nid_number.required' => 'এনআইডি নম্বর দিন।',
            'nid_number.unique' => 'এই এনআইডি নম্বরটি ইতিমধ্যে ব্যবহৃত হয়েছে।',
            'profile_image.required' => 'প্রোফাইল ছবি আপলোড করুন।',
            'nid_front_image.required' => 'এনআইডি ফ্রন্ট ছবি আপলোড করুন।',
            'nid_back_image.required' => 'এনআইডি ব্যাক ছবি আপলোড করুন।',
        ]);

        // Upload images
        $uploadBase = public_path('uploads');
        if (!file_exists($uploadBase)) {
            mkdir($uploadBase, 0777, true);
        }

        // Profile image
        $profileDir = public_path('uploads/profile');
        if (!file_exists($profileDir)) mkdir($profileDir, 0777, true);
        $profileName = uniqid() . '_' . $request->file('profile_image')->getClientOriginalName();
        $request->file('profile_image')->move($profileDir, $profileName);
        $profilePath = 'uploads/profile/' . $profileName;

        // NID Front
        $nidFrontDir = public_path('uploads/nid_front');
        if (!file_exists($nidFrontDir)) mkdir($nidFrontDir, 0777, true);
        $nidFrontName = uniqid() . '_' . $request->file('nid_front_image')->getClientOriginalName();
        $request->file('nid_front_image')->move($nidFrontDir, $nidFrontName);
        $nidFrontPath = 'uploads/nid_front/' . $nidFrontName;

        // NID Back
        $nidBackDir = public_path('uploads/nid_back');
        if (!file_exists($nidBackDir)) mkdir($nidBackDir, 0777, true);
        $nidBackName = uniqid() . '_' . $request->file('nid_back_image')->getClientOriginalName();
        $request->file('nid_back_image')->move($nidBackDir, $nidBackName);
        $nidBackPath = 'uploads/nid_back/' . $nidBackName;

        $user = User::create([
            'name' => $request->name,
            'number' => $request->number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nid_number' => $request->nid_number,
            'date_of_birth' => $request->date_of_birth,
            'profile_image' => $profilePath,
            'nid_front_image' => $nidFrontPath,
            'nid_back_image' => $nidBackPath,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'অভিনন্দন! আপনার অ্যাকাউন্ট সফলভাবে তৈরি হয়েছে।');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'সফলভাবে লগআউট হয়েছেন।');
    }
}
