@extends('layouts.app')

@section('title', 'লগইন - আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl border border-slate-200/80 p-6 sm:p-8">
        
        <div class="text-center mb-6">
            <img src="{{ asset('images/org_logo_new.png') }}" alt="Logo" class="w-14 h-14 mx-auto mb-3 bg-white p-0.5 rounded-full shadow-sm">
            <h2 class="text-xl font-bold text-slate-900">ইউজার লগইন</h2>
            <p class="text-xs text-slate-500 mt-1">আপনার অভিযোগ ও আবেদনের তথ্য দেখতে লগইন করুন</p>
        </div>

        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">মোবাইল নম্বর অথবা ইমেইল</label>
                <div class="relative">
                    <i class="fa-solid fa-phone absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                    <input type="text" name="login" value="{{ old('login') }}" required placeholder="যেমন: 01644416378"
                        class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-xs sm:text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">পাসওয়ার্ড</label>
                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                    <input type="password" name="password" required placeholder="আপনার পাসওয়ার্ড"
                        class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-xs sm:text-sm">
                </div>
            </div>

            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center space-x-2 cursor-pointer text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                    <span>লগইন মনে রাখুন</span>
                </label>
                <a href="{{ route('track') }}" class="text-brand-700 hover:underline">পাসওয়ার্ড মনে নেই?</a>
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-brand-900 to-brand-800 hover:from-brand-800 hover:to-brand-700 text-amber-400 font-bold text-sm shadow-md transition transform active:scale-95 flex items-center justify-center space-x-2">
                <i class="fa-solid fa-right-to-bracket"></i>
                <span>লগইন করুন</span>
            </button>
        </form>

        <div class="mt-6 pt-4 border-t border-slate-100 text-center text-xs text-slate-500">
            <span>অ্যাকাউন্ট নেই? </span>
            <a href="{{ route('register') }}" class="font-bold text-brand-700 hover:text-amber-600">নতুন অ্যাকাউন্ট তৈরি করুন</a>
        </div>
    </div>
</div>
@endsection
