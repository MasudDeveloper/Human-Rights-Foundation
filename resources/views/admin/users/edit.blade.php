@extends('layouts.admin')

@section('title', 'নাগরিক তথ্য ও ডকুমেন্টস সম্পাদনা - #' . $user->id)
@section('page_title', 'নাগরিক অ্যাকাউন্ট, ছবি ও NID সম্পাদনা')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between border-b pb-4 mb-6">
            <div>
                <span class="text-xs text-amber-600 font-bold uppercase tracking-wider flex items-center">
                    <i class="fa-solid fa-user-pen mr-1.5"></i>অ্যাডমিন নিয়ন্ত্রণ
                </span>
                <h2 class="text-lg font-bold text-slate-900 mt-0.5">নাগরিক প্রোফাইল, ছবি ও NID এডিট</h2>
                <p class="text-xs text-slate-500 mt-0.5">নাগরিকের ব্যক্তিগত তথ্য, পাসওয়ার্ড, ছবি ও জাতীয় পরিচয়পত্র পরিবর্তন করুন</p>
            </div>
            <a href="{{ route('admin.users.show', $user->id) }}" class="text-xs text-slate-500 hover:text-slate-900 font-semibold px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 transition">
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

            <!-- Photos & NID Documents Update Cards -->
            <div class="space-y-2 pt-2">
                <label class="block font-bold text-slate-800 text-xs uppercase tracking-wider flex items-center">
                    <i class="fa-solid fa-camera text-purple-600 mr-1.5"></i>
                    প্রোফাইল ছবি ও জাতীয় পরিচয়পত্র (NID) ডকুমেন্টস
                </label>
                <p class="text-[11px] text-slate-500">কোনো ছবি পরিবর্তন করতে না চাইলে সংশ্লিষ্ট ঘরটি খালি রাখুন। নতুন ছবি দিলে তা স্বয়ংক্রিয়ভাবে সদস্য প্রোফাইলেও সিঙ্ক হয়ে যাবে।</p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                    <!-- Profile Photo Card -->
                    <div class="p-3.5 bg-slate-50/70 rounded-2xl border border-slate-200 text-center flex flex-col items-center">
                        <div class="w-16 h-16 rounded-full bg-slate-200 border-2 border-slate-300 overflow-hidden mb-2 flex items-center justify-center relative shadow-xs">
                            <img id="previewUserPhoto" src="{{ $user->profile_image ? asset($user->profile_image) : '' }}" class="{{ $user->profile_image ? '' : 'hidden' }} w-full h-full object-cover">
                            <i id="iconUserPhoto" class="fa-solid fa-user text-slate-400 text-xl {{ $user->profile_image ? 'hidden' : '' }}"></i>
                            @if($user->profile_image)
                                <a href="{{ asset($user->profile_image) }}" target="_blank" title="বড় আকারে দেখুন" class="absolute bottom-0 right-0 bg-slate-900/80 text-white text-[8px] p-1 rounded-full hover:bg-slate-900">
                                    <i class="fa-solid fa-up-right-from-square"></i>
                                </a>
                            @endif
                        </div>
                        <span class="block font-bold text-slate-800 text-xs">প্রোফাইল ছবি</span>
                        <span class="block text-[10px] text-slate-400 mb-1.5">User Photo</span>
                        <input type="file" name="profile_image" id="inputUserPhoto" accept="image/*" class="w-full text-[11px] text-slate-500 file:mr-1.5 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-slate-900 file:text-amber-400 file:cursor-pointer cursor-pointer" onchange="previewUserImg(this, 'previewUserPhoto', 'iconUserPhoto')">
                    </div>

                    <!-- NID Front Card -->
                    <div class="p-3.5 bg-slate-50/70 rounded-2xl border border-slate-200 text-center flex flex-col items-center">
                        <div class="w-24 h-16 rounded-xl bg-indigo-50 border-2 border-indigo-200 overflow-hidden mb-2 flex items-center justify-center relative shadow-xs">
                            <img id="previewUserNidFront" src="{{ $user->nid_front_image ? asset($user->nid_front_image) : '' }}" class="{{ $user->nid_front_image ? '' : 'hidden' }} w-full h-full object-cover">
                            <i id="iconUserNidFront" class="fa-solid fa-id-card text-indigo-300 text-xl {{ $user->nid_front_image ? 'hidden' : '' }}"></i>
                            @if($user->nid_front_image)
                                <a href="{{ asset($user->nid_front_image) }}" target="_blank" title="বড় আকারে দেখুন" class="absolute bottom-1 right-1 bg-slate-900/80 text-white text-[8px] px-1 py-0.5 rounded font-mono hover:bg-slate-900">
                                    <i class="fa-solid fa-up-right-from-square"></i>
                                </a>
                            @endif
                        </div>
                        <span class="block font-bold text-slate-800 text-xs">NID সামনের পাতা</span>
                        <span class="block text-[10px] text-slate-400 mb-1.5">National ID Front</span>
                        <input type="file" name="nid_front_image" id="inputUserNidFront" accept="image/*" class="w-full text-[11px] text-slate-500 file:mr-1.5 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-indigo-600 file:text-white file:cursor-pointer cursor-pointer" onchange="previewUserImg(this, 'previewUserNidFront', 'iconUserNidFront')">
                    </div>

                    <!-- NID Back Card -->
                    <div class="p-3.5 bg-slate-50/70 rounded-2xl border border-slate-200 text-center flex flex-col items-center">
                        <div class="w-24 h-16 rounded-xl bg-purple-50 border-2 border-purple-200 overflow-hidden mb-2 flex items-center justify-center relative shadow-xs">
                            <img id="previewUserNidBack" src="{{ $user->nid_back_image ? asset($user->nid_back_image) : '' }}" class="{{ $user->nid_back_image ? '' : 'hidden' }} w-full h-full object-cover">
                            <i id="iconUserNidBack" class="fa-solid fa-id-card text-purple-300 text-xl {{ $user->nid_back_image ? 'hidden' : '' }}"></i>
                            @if($user->nid_back_image)
                                <a href="{{ asset($user->nid_back_image) }}" target="_blank" title="বড় আকারে দেখুন" class="absolute bottom-1 right-1 bg-slate-900/80 text-white text-[8px] px-1 py-0.5 rounded font-mono hover:bg-slate-900">
                                    <i class="fa-solid fa-up-right-from-square"></i>
                                </a>
                            @endif
                        </div>
                        <span class="block font-bold text-slate-800 text-xs">NID পিছনের পাতা</span>
                        <span class="block text-[10px] text-slate-400 mb-1.5">National ID Back</span>
                        <input type="file" name="nid_back_image" id="inputUserNidBack" accept="image/*" class="w-full text-[11px] text-slate-500 file:mr-1.5 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-purple-600 file:text-white file:cursor-pointer cursor-pointer" onchange="previewUserImg(this, 'previewUserNidBack', 'iconUserNidBack')">
                    </div>
                </div>
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

<script>
    function previewUserImg(input, imgId, iconId) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(imgId);
                const icon = document.getElementById(iconId);
                if (img) {
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                }
                if (icon) {
                    icon.classList.add('hidden');
                }
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
