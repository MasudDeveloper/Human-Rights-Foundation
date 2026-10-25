@extends('layouts.admin')

@section('title', 'নাগরিক তথ্য সম্পাদনা - #' . $user->id)
@section('page_title', 'নাগরিক অ্যাকাউন্ট সম্পাদনা (সুপার অ্যাডমিন)')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between border-b pb-4 mb-6">
            <div>
                <span class="text-xs text-amber-600 font-bold uppercase tracking-wider">সুপার অ্যাডমিন ক্ষমতা</span>
                <h2 class="text-lg font-bold text-slate-900 mt-0.5">নাগরিক প্রোফাইল এডিট</h2>
            </div>
            <a href="{{ route('admin.users.show', $user->id) }}" class="text-xs text-slate-500 hover:text-slate-900 font-semibold">
                <i class="fa-solid fa-arrow-left mr-1"></i>ফিরে যান
            </a>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-semibold text-slate-700 mb-1">পূর্ণ নাম</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-slate-900">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">মোবাইল নম্বর</label>
                    <input type="text" name="number" value="{{ old('number', $user->number) }}" required
                        class="w-full px-3 py-2 rounded-xl border border-slate-300 font-mono">
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">ইমেইল</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-3 py-2 rounded-xl border border-slate-300">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">জাতীয় পরিচয়পত্র (NID)</label>
                    <input type="text" name="nid_number" value="{{ old('nid_number', $user->nid_number) }}" required
                        class="w-full px-3 py-2 rounded-xl border border-slate-300 font-mono">
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">জন্ম তারিখ</label>
                    <input type="text" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}" required
                        class="w-full px-3 py-2 rounded-xl border border-slate-300">
                </div>
            </div>

            <!-- Password Reset by Super Admin -->
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
                <label class="block font-semibold text-slate-700">নতুন পাসওয়ার্ড সেট করুন (ঐচ্ছিক)</label>
                <input type="password" name="password" placeholder="পরিবর্তন না করতে চাইলে ফাঁকা রাখুন"
                    class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white">
                <span class="text-[10px] text-slate-400 block">সুপার অ্যাডমিন হিসেবে আপনি যেকোনো ইউজারের পাসওয়ার্ড সরাসরি রিসেট করে দিতে পারেন।</span>
            </div>

            <!-- Photo Update -->
            <div>
                <label class="block font-semibold text-slate-700 mb-1">প্রোফাইল ছবি পরিবর্তন</label>
                <input type="file" name="profile_image" accept="image/*"
                    class="w-full px-3 py-1.5 rounded-xl border border-slate-300 bg-white text-xs">
            </div>

            <div class="pt-4 border-t flex justify-end space-x-3">
                <a href="{{ route('admin.users.show', $user->id) }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition">
                    বাতিল
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-amber-400 font-bold shadow transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-check"></i>
                    <span>তথ্য সংরক্ষণ করুন</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
