@extends('layouts.app')

@section('title', 'নতুন অ্যাকাউন্ট তৈরি করুন - মানবাধিকার ফাউন্ডেশন')

@section('content')
<div class="max-w-xl mx-auto px-4 py-12">
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200/80 p-6 sm:p-8">
        
        <div class="text-center mb-8">
            <img src="{{ $siteLogo }}" alt="Logo" class="w-14 h-14 mx-auto mb-2 bg-white p-0.5 rounded-full shadow-sm">
            <h2 class="text-xl sm:text-2xl font-bold text-slate-900">নাগরিক নিবন্ধন ফরম</h2>
            <p class="text-xs text-slate-500 mt-1">আইনি সহায়তা ও নাগরিক অধিকার রক্ষায় প্রয়োজনীয় তথ্য দিয়ে নিবন্ধন করুন</p>
        </div>

        <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">
                    পূর্ণ নাম <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <i class="fa-solid fa-user text-xs"></i>
                    </span>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="আপনার পূর্ণ নাম"
                        class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-xs sm:text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">
                    সচল মোবাইল নম্বর <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <i class="fa-solid fa-phone text-xs"></i>
                    </span>
                    <input type="tel" name="number" value="{{ old('number') }}" required placeholder="01XXXXXXXXX"
                        class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-xs sm:text-sm font-mono">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">
                    ইমেইল ঠিকানা <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <i class="fa-solid fa-envelope text-xs"></i>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="example@mail.com"
                        class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-xs sm:text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                        পাসওয়ার্ড <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </span>
                        <input type="password" name="password" required placeholder="ন্যূনতম ৬ অক্ষর"
                            class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-xs sm:text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                        পাসওয়ার্ড নিশ্চিতকরণ <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-solid fa-shield-check text-xs"></i>
                        </span>
                        <input type="password" name="password_confirmation" required placeholder="পুনরায় পাসওয়ার্ড দিন"
                            class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-xs sm:text-sm">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-3">
                <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-brand-900 to-brand-800 hover:from-brand-800 hover:to-brand-700 text-amber-400 font-bold text-sm shadow-lg transition transform active:scale-95 flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-user-check"></i>
                    <span>নিবন্ধন সম্পন্ন করুন</span>
                </button>
            </div>
        </form>

        <div class="mt-6 pt-4 border-t border-slate-100 text-center text-xs text-slate-500">
            <span>ইতিমধ্যে অ্যাকাউন্ট আছে? </span>
            <a href="{{ route('login') }}" class="font-bold text-brand-700 hover:text-amber-600">এখানে লগইন করুন</a>
        </div>
    </div>
</div>
@endsection
