@extends('layouts.app')

@section('title', 'সদস্য হওয়ার আবেদনপত্র - মানবাধিকার ফাউন্ডেশন')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200/80 p-6 sm:p-10">
        
        <!-- Header -->
        <div class="border-b border-slate-100 pb-6 mb-8 text-center sm:text-left flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">ফাউন্ডেশনের সদস্য নিবন্ধন</span>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 mt-0.5">সদস্য পদের আবেদন ফরম</h1>
                <p class="text-xs text-slate-500 mt-1">আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশনের দায়িত্বশীল সদস্য হিসেবে যোগ দিন</p>
            </div>
            <div class="flex items-center space-x-2 bg-blue-50 border border-blue-200 px-3.5 py-2 rounded-xl text-blue-900 text-xs">
                <i class="fa-solid fa-id-card text-blue-600 text-sm"></i>
                <span>নিবন্ধন ফি: <strong>৳২৫০ টাকা</strong></span>
            </div>
        </div>

        <form method="POST" action="{{ route('member.store') }}" class="space-y-8">
            @csrf

            <!-- Section 1: Designation & Personal Info -->
            <div class="bg-slate-50/70 p-5 sm:p-6 rounded-2xl border border-slate-200/80">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-4 flex items-center border-b pb-2">
                    <i class="fa-solid fa-id-badge mr-2 text-blue-600 text-sm"></i>
                    <span>১. আবেদনকৃত পদ ও ব্যক্তিগত তথ্য</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-xs">
                    <div class="sm:col-span-3">
                        <label class="block font-semibold text-slate-700 mb-1">আবেদনকৃত পদবী <span class="text-rose-500">*</span></label>
                        <select name="post_name" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white">
                            <option value="">-- পদবী নির্বাচন করুন --</option>
                            @foreach($posts as $p)
                                <option value="{{ $p }}" {{ old('post_name') == $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">নাম (বাংলায়) <span class="text-rose-500">*</span></label>
                        <input type="text" name="bangla_name" value="{{ old('bangla_name', $user->name) }}" required placeholder="বাংলায় পূর্ণ নাম"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">নাম (ইংরেজিতে) <span class="text-rose-500">*</span></label>
                        <input type="text" name="english_name" value="{{ old('english_name') }}" required placeholder="FULL NAME IN ENGLISH"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white uppercase">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">পিতার নাম</label>
                        <input type="text" name="father_name" value="{{ old('father_name') }}" placeholder="পিতার নাম"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">মাতার নাম</label>
                        <input type="text" name="mother_name" value="{{ old('mother_name') }}" placeholder="মাতার নাম"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">জন্ম তারিখ <span class="text-rose-500">*</span></label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}" required
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">জাতীয় পরিচয়পত্র (NID) <span class="text-rose-500">*</span></label>
                        <input type="text" name="nid" value="{{ old('nid', $user->nid_number) }}" required placeholder="NID নম্বর"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">রক্তের গ্রুপ</label>
                        <select name="blood_group" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white">
                            <option value="">নির্বাচন করুন</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">শিক্ষাগত যোগ্যতা <span class="text-rose-500">*</span></label>
                        <input type="text" name="education" value="{{ old('education') }}" required placeholder="যেমন: SSC, HSC, Honours, LLB"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">বর্তমান পেশা <span class="text-rose-500">*</span></label>
                        <input type="text" name="current_job" value="{{ old('current_job') }}" required placeholder="যেমন: অ্যাডভোকেট, শিক্ষক, ব্যবসায়ী"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white">
                    </div>
                </div>
            </div>

            <!-- Section 2: Permanent & Present Address -->
            <div class="bg-slate-50/70 p-5 sm:p-6 rounded-2xl border border-slate-200/80">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-4 flex items-center border-b pb-2">
                    <i class="fa-solid fa-map-location-dot mr-2 text-emerald-600 text-sm"></i>
                    <span>২. ঠিকানার বিবরণ</span>
                </h3>

                <!-- Permanent Address -->
                <p class="font-bold text-slate-700 text-xs mb-2">স্থায়ী ঠিকানা:</p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs mb-4">
                    <div>
                        <label class="block text-slate-600 mb-1">গ্রাম/মহল্লা</label>
                        <input type="text" name="village" value="{{ old('village') }}" placeholder="গ্রাম" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 bg-white">
                    </div>
                    <div>
                        <label class="block text-slate-600 mb-1">ডাকঘর</label>
                        <input type="text" name="post_office" value="{{ old('post_office') }}" placeholder="ডাকঘর" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 bg-white">
                    </div>
                    <div>
                        <label class="block text-slate-600 mb-1">থানা <span class="text-rose-500">*</span></label>
                        <input type="text" name="thana" value="{{ old('thana') }}" required placeholder="থানা" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 bg-white">
                    </div>
                    <div>
                        <label class="block text-slate-600 mb-1">জেলা <span class="text-rose-500">*</span></label>
                        <input type="text" name="district" value="{{ old('district') }}" required placeholder="জেলা" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 bg-white">
                    </div>
                </div>

                <!-- Present Address -->
                <p class="font-bold text-slate-700 text-xs mb-2">বর্তমান ঠিকানা (যদি আলাদা হয়):</p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                    <div>
                        <label class="block text-slate-600 mb-1">গ্রাম/মহল্লা</label>
                        <input type="text" name="village2" value="{{ old('village2') }}" placeholder="গ্রাম" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 bg-white">
                    </div>
                    <div>
                        <label class="block text-slate-600 mb-1">ডাকঘর</label>
                        <input type="text" name="post_office2" value="{{ old('post_office2') }}" placeholder="ডাকঘর" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 bg-white">
                    </div>
                    <div>
                        <label class="block text-slate-600 mb-1">থানা</label>
                        <input type="text" name="thana2" value="{{ old('thana2') }}" placeholder="থানা" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 bg-white">
                    </div>
                    <div>
                        <label class="block text-slate-600 mb-1">জেলা</label>
                        <input type="text" name="district2" value="{{ old('district2') }}" placeholder="জেলা" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 bg-white">
                    </div>
                </div>
            </div>

            <!-- Section 3: Contact & Other details -->
            <div class="bg-slate-50/70 p-5 sm:p-6 rounded-2xl border border-slate-200/80">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-4 flex items-center border-b pb-2">
                    <i class="fa-solid fa-address-book mr-2 text-indigo-600 text-sm"></i>
                    <span>৩. যোগাযোগ ও অন্যান্য তথ্য</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">মোবাইল নম্বর <span class="text-rose-500">*</span></label>
                        <input type="text" name="phone_number" value="{{ old('phone_number', $user->number) }}" required placeholder="01XXXXXXXXX"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">ইমেইল</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="mail@example.com"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">ফেসবুক প্রোফাইল লিংক/আইডি</label>
                        <input type="text" name="facebook_id" value="{{ old('facebook_id') }}" placeholder="facebook.com/username"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">বৈবাহিক অবস্থা</label>
                        <select name="marital_status" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white">
                            <option value="অবিবাহিত">অবিবাহিত</option>
                            <option value="বিবাহিত">বিবাহিত</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">ধর্ম</label>
                        <input type="text" name="religion" value="{{ old('religion', 'ইসলাম') }}" placeholder="ধর্ম"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">রেফারেন্স বা সুপারিশকারীর নাম</label>
                        <input type="text" name="reference_name" value="{{ old('reference_name') }}" placeholder="যদি থাকে"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white">
                    </div>
                </div>
            </div>

            <!-- Section 4: Membership Fee Payment -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50/40 p-5 sm:p-6 rounded-2xl border border-blue-200">
                <h3 class="text-xs font-bold text-blue-900 uppercase tracking-wider mb-4 flex items-center border-b border-blue-200 pb-2">
                    <i class="fa-solid fa-receipt mr-2 text-blue-700 text-sm"></i>
                    <span>৪. সদস্য নিবন্ধন ফি পরিশোধ</span>
                </h3>

                <div class="bg-white/80 p-4 rounded-xl border border-blue-200/60 mb-5 text-xs text-slate-700">
                    <p class="font-bold text-blue-900">পেমেন্ট নির্দেশনা:</p>
                    <p class="mt-0.5">নিবন্ধন ফি <strong>৳২৫০ টাকা</strong> নিচের নম্বরে সেন্ড মানি করুন:</p>
                    <div class="flex flex-wrap gap-2 pt-2 font-mono">
                        <span class="bg-pink-100 text-pink-800 px-3 py-1 rounded-lg font-bold border border-pink-200">বিকাশ: 01644416378</span>
                        <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-lg font-bold border border-orange-200">নগদ: 01644416378</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                    <div>
                        <label class="block font-semibold text-slate-800 mb-1">পেমেন্ট মেথড <span class="text-rose-500">*</span></label>
                        <select name="payment_gateway" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white">
                            <option value="বিকাশ">বিকাশ (bKash)</option>
                            <option value="নগদ">নগদ (Nagad)</option>
                            <option value="রকেট">রকেট (Rocket)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-800 mb-1">প্রেরক নম্বর <span class="text-rose-500">*</span></label>
                        <input type="text" name="payment_number" value="{{ old('payment_number') }}" required placeholder="যে নম্বর থেকে টাকা পাঠিয়েছেন"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white font-mono">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-800 mb-1">ট্রানজেকশন আইডি (TrxID) <span class="text-rose-500">*</span></label>
                        <input type="text" name="transaction_id" value="{{ old('transaction_id') }}" required placeholder="TrxID"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white font-mono uppercase">
                    </div>
                </div>
            </div>

            <!-- Confirmation -->
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 text-xs">
                <label class="flex items-start space-x-2.5 cursor-pointer">
                    <input type="checkbox" required class="mt-0.5 rounded border-slate-300 text-brand-600">
                    <span class="text-slate-600 leading-relaxed">
                        আমি এই মর্মে অঙ্গীকার করছি যে, ফাউন্ডেশনের গঠনতন্ত্র, নিয়মনীতি ও মানবাধিকারের আদর্শ নিষ্ঠার সাথে মেনে চলব এবং কোনো ধরণের দেশবিরোধী বা অপরাধমূলক কর্মকাণ্ডে জড়িত থাকব না।
                    </span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="w-full sm:w-auto px-10 py-3.5 rounded-xl bg-gradient-to-r from-blue-700 to-indigo-800 hover:from-blue-600 hover:to-indigo-700 text-white font-bold text-sm shadow-xl transition transform active:scale-95 inline-flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>সদস্য আবেদন জমা দিন</span>
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
