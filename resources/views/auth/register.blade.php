@extends('layouts.app')

@section('title', 'নতুন অ্যাকাউন্ট তৈরি করুন - মানবাধিকার ফাউন্ডেশন')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200/80 p-6 sm:p-8">
        
        <div class="text-center mb-8">
            <img src="{{ asset('images/cit_logo.png') }}" alt="Logo" class="w-14 h-14 mx-auto mb-2 bg-white p-0.5 rounded-full shadow-sm">
            <h2 class="text-xl sm:text-2xl font-bold text-slate-900">নাগরিক নিবন্ধন ফরম</h2>
            <p class="text-xs text-slate-500 mt-1">আইনি সহায়তা ও নাগরিক অধিকার রক্ষায় আপনার তথ্য দিয়ে নিবন্ধন করুন</p>
        </div>

        <form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Section 1: Basic Information -->
            <div class="border-b border-slate-100 pb-5">
                <h3 class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-4 flex items-center">
                    <i class="fa-solid fa-user-circle mr-1.5 text-sm"></i>
                    <span>ব্যক্তিগত বিবরণী</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1">পূর্ণ নাম (জাতীয় পরিচয়পত্র অনুযায়ী) <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="আপনার পূর্ণ নাম"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 text-xs sm:text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">সচল মোবাইল নম্বর <span class="text-rose-500">*</span></label>
                        <input type="text" name="number" value="{{ old('number') }}" required placeholder="01XXXXXXXXX"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 text-xs sm:text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">ইমেইল ঠিকানা <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="example@mail.com"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 text-xs sm:text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">জাতীয় পরিচয়পত্র (NID) নম্বর <span class="text-rose-500">*</span></label>
                        <input type="text" name="nid_number" value="{{ old('nid_number') }}" required placeholder="১০ বা ১৭ ডিজিটের NID"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 text-xs sm:text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">জন্ম তারিখ <span class="text-rose-500">*</span></label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 text-xs sm:text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">পাসওয়ার্ড <span class="text-rose-500">*</span></label>
                        <input type="password" name="password" required placeholder="ন্যূনতম ৬ অক্ষর"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 text-xs sm:text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">পাসওয়ার্ড নিশ্চিতকরণ <span class="text-rose-500">*</span></label>
                        <input type="password" name="password_confirmation" required placeholder="পুনরায় পাসওয়ার্ড দিন"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 text-xs sm:text-sm">
                    </div>
                </div>
            </div>

            <!-- Section 2: Photo and NID Document Uploads -->
            <div>
                <h3 class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-4 flex items-center">
                    <i class="fa-solid fa-camera mr-1.5 text-sm"></i>
                    <span>ছবি ও জাতীয় পরিচয়পত্র আপলোড</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Profile Photo -->
                    <div class="border-2 border-dashed border-slate-200 hover:border-brand-500 p-4 rounded-2xl text-center transition">
                        <label class="cursor-pointer block">
                            <i class="fa-solid fa-user text-2xl text-slate-400 mb-2"></i>
                            <span class="block text-xs font-bold text-slate-700">প্রোফাইল ছবি <span class="text-rose-500">*</span></span>
                            <span class="block text-[10px] text-slate-400 mt-1">ক্লিয়ার পাসপোর্ট সাইজ ছবি</span>
                            <input type="file" name="profile_image" accept="image/*" required class="hidden" onchange="previewImg(this, 'profilePreview')">
                        </label>
                        <div id="profilePreview" class="hidden mt-2"><img src="" class="h-16 w-16 mx-auto object-cover rounded-full border"></div>
                    </div>

                    <!-- NID Front -->
                    <div class="border-2 border-dashed border-slate-200 hover:border-brand-500 p-4 rounded-2xl text-center transition">
                        <label class="cursor-pointer block">
                            <i class="fa-solid fa-id-card text-2xl text-slate-400 mb-2"></i>
                            <span class="block text-xs font-bold text-slate-700">NID সামনের পাতা <span class="text-rose-500">*</span></span>
                            <span class="block text-[10px] text-slate-400 mt-1">পরিষ্কার ছবি</span>
                            <input type="file" name="nid_front_image" accept="image/*" required class="hidden" onchange="previewImg(this, 'nidFrontPreview')">
                        </label>
                        <div id="nidFrontPreview" class="hidden mt-2"><img src="" class="h-16 w-full mx-auto object-cover rounded-lg border"></div>
                    </div>

                    <!-- NID Back -->
                    <div class="border-2 border-dashed border-slate-200 hover:border-brand-500 p-4 rounded-2xl text-center transition">
                        <label class="cursor-pointer block">
                            <i class="fa-solid fa-id-card text-2xl text-slate-400 mb-2"></i>
                            <span class="block text-xs font-bold text-slate-700">NID পিছনের পাতা <span class="text-rose-500">*</span></span>
                            <span class="block text-[10px] text-slate-400 mt-1">পরিষ্কার ছবি</span>
                            <input type="file" name="nid_back_image" accept="image/*" required class="hidden" onchange="previewImg(this, 'nidBackPreview')">
                        </label>
                        <div id="nidBackPreview" class="hidden mt-2"><img src="" class="h-16 w-full mx-auto object-cover rounded-lg border"></div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
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

<script>
    function previewImg(input, targetId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const target = document.getElementById(targetId);
                target.classList.remove('hidden');
                target.querySelector('img').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
