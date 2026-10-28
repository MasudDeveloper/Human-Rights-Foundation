@extends('layouts.admin')

@section('title', 'ওয়েবসাইট ও আইডি কার্ড সেটিংস - সুপার অ্যাডমিন')
@section('page_title', 'লোগো, ওয়েবসাইট ব্র্যান্ডিং ও আইডি কার্ড সেটিংস')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Page Header Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 p-6 rounded-3xl text-white shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border border-slate-700/50">
        <div class="flex items-center space-x-4">
            <div class="w-14 h-14 rounded-2xl bg-amber-400 text-slate-950 flex items-center justify-center text-2xl shadow-md flex-shrink-0">
                <i class="fa-solid fa-sliders"></i>
            </div>
            <div>
                <span class="text-xs font-bold text-amber-400 uppercase tracking-widest">সুপার অ্যাডমিন কনফিগারেশন</span>
                <h2 class="text-xl font-extrabold text-white">ওয়েবসাইট ব্র্যান্ডিং, লোগো ও আইডি কার্ড সেটিংস</h2>
                <p class="text-xs text-slate-300 mt-0.5">এখানে পরিবর্তিত লোগো, নাম, স্বাক্ষর ও সিল সম্পূর্ণ ওয়েবসাইট এবং সদস্য কার্ডে স্বয়ংক্রিয়ভাবে কার্যকর হবে</p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('home') }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-xs font-bold transition flex items-center space-x-1.5 border border-white/10">
                <i class="fa-solid fa-globe text-amber-400"></i>
                <span>ওয়েবসাইট প্রিভিউ</span>
            </a>
            <a href="{{ route('member.id_card', 3) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold transition flex items-center space-x-1.5 shadow">
                <i class="fa-solid fa-id-card"></i>
                <span>আইডি কার্ড প্রিভিউ</span>
            </a>
        </div>
    </div>

    <!-- Settings Main Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden" x-data="{ currentTab: '{{ $tab ?? 'branding' }}' }">
        
        <!-- Navigation Tabs -->
        <div class="flex border-b border-slate-200 bg-slate-50/70 px-4 pt-3 gap-2 overflow-x-auto">
            <button type="button" @click="currentTab = 'branding'" :class="currentTab === 'branding' ? 'border-b-2 border-amber-500 text-slate-900 bg-white font-bold shadow-sm' : 'text-slate-500 hover:text-slate-800'" class="px-5 py-3 rounded-t-2xl text-xs flex items-center space-x-2 transition">
                <i class="fa-solid fa-palette text-amber-500"></i>
                <span>লোগো ও ব্র্যান্ডিং</span>
            </button>
            <button type="button" @click="currentTab = 'idcard'" :class="currentTab === 'idcard' ? 'border-b-2 border-amber-500 text-slate-900 bg-white font-bold shadow-sm' : 'text-slate-500 hover:text-slate-800'" class="px-5 py-3 rounded-t-2xl text-xs flex items-center space-x-2 transition">
                <i class="fa-solid fa-id-badge text-blue-600"></i>
                <span>আইডি কার্ড ও স্বাক্ষর</span>
            </button>
            <button type="button" @click="currentTab = 'contact'" :class="currentTab === 'contact' ? 'border-b-2 border-amber-500 text-slate-900 bg-white font-bold shadow-sm' : 'text-slate-500 hover:text-slate-800'" class="px-5 py-3 rounded-t-2xl text-xs flex items-center space-x-2 transition">
                <i class="fa-solid fa-headset text-emerald-600"></i>
                <span>যোগাযোগ ও অফিস ঠিকানা</span>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.settings.post') }}" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6 text-xs">
            @csrf
            <input type="hidden" name="tab" :value="currentTab">

            <!-- ================= TAB 1: BRANDING & LOGO ================= -->
            <div x-show="currentTab === 'branding'" x-cloak class="space-y-6">
                
                <!-- Logo & Favicon Upload Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Main Site Logo -->
                    <div class="p-5 rounded-2xl border-2 border-dashed border-amber-300 bg-amber-50/40">
                        <label class="block font-bold text-slate-800 text-sm mb-1">
                            <i class="fa-solid fa-image text-amber-600 mr-1.5"></i>প্রধান ওয়েবসাইট ও কার্ড লোগো
                        </label>
                        <p class="text-[11px] text-slate-500 mb-3">পিএনজি (PNG) বা স্বচ্ছ ব্যাকগ্রাউন্ডের উচ্চ রেজোলিউশন লোগো আপলোড করুন।</p>
                        
                        <div class="flex items-center space-x-4 mb-3">
                            <div class="w-20 h-20 rounded-2xl bg-white border border-slate-300 p-2 shadow-sm flex items-center justify-center flex-shrink-0">
                                <img src="{{ $siteLogo }}" alt="Current Logo" class="max-h-full max-w-full object-contain">
                            </div>
                            <div class="flex-grow">
                                <input type="file" name="site_logo" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-400 file:text-slate-950 hover:file:bg-amber-300">
                                <span class="text-[10px] text-slate-400 mt-1 block">সমর্থিত ফরম্যাট: PNG, JPG, SVG, WebP (সর্বোচ্চ ২ মেগাবাইট)</span>
                            </div>
                        </div>

                        @if(!str_contains($siteSettings['site_logo'] ?? '', 'images/cit_logo.png'))
                            <label class="inline-flex items-center text-[11px] text-rose-600 font-semibold cursor-pointer">
                                <input type="checkbox" name="delete_site_logo" value="1" class="rounded border-slate-300 text-rose-600 mr-1.5">
                                <span>কাস্টম লোগো মুছে ডিফল্ট লোগো ব্যবহার করুন</span>
                            </label>
                        @endif
                    </div>

                    <!-- Favicon Upload -->
                    <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50/60">
                        <label class="block font-bold text-slate-800 text-sm mb-1">
                            <i class="fa-solid fa-circle-dot text-indigo-600 mr-1.5"></i>ব্রাউজার ফেভিকন (Favicon / Icon)
                        </label>
                        <p class="text-[11px] text-slate-500 mb-3">ব্রাউজারের ট্যাব এবং মোবাইল PWA অ্যাপ আইকন হিসেবে প্রদর্শিত হবে।</p>
                        
                        <div class="flex items-center space-x-4 mb-3">
                            <div class="w-16 h-16 rounded-2xl bg-white border border-slate-300 p-2 shadow-sm flex items-center justify-center flex-shrink-0">
                                <img src="{{ $siteFavicon }}" alt="Favicon" class="max-h-full max-w-full object-contain">
                            </div>
                            <div class="flex-grow">
                                <input type="file" name="site_favicon" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
                                <span class="text-[10px] text-slate-400 mt-1 block">সাইজ: 192x192 বা 512x512 PNG বা ICO ফরম্যাট</span>
                            </div>
                        </div>

                        @if(!str_contains($siteSettings['site_favicon'] ?? '', 'images/cit_logo.png'))
                            <label class="inline-flex items-center text-[11px] text-rose-600 font-semibold cursor-pointer">
                                <input type="checkbox" name="delete_site_favicon" value="1" class="rounded border-slate-300 text-rose-600 mr-1.5">
                                <span>ডিফল্ট ফেভিকন ব্যবহার করুন</span>
                            </label>
                        @endif
                    </div>
                </div>

                <!-- Org Names Inputs -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">সংস্থার অফিশিয়াল নাম (বাংলা) <span class="text-rose-500">*</span></label>
                        <input type="text" name="org_name_bn" value="{{ old('org_name_bn', $siteSettings['org_name_bn']) }}" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900 font-medium text-slate-900">
                        <span class="text-[10px] text-slate-400 mt-1 block">হেডার, আইডি কার্ড ও সকল দাপ্তরিক নথিতে প্রদর্শিত হবে</span>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">সংস্থার অফিশিয়াল নাম (English) <span class="text-rose-500">*</span></label>
                        <input type="text" name="org_name_en" value="{{ old('org_name_en', $siteSettings['org_name_en']) }}" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900 font-medium text-slate-900">
                        <span class="text-[10px] text-slate-400 mt-1 block">ইংরেজি পূর্ণ নাম (যেমন: Center for The Enforcement of Human Rights and Legal Aid)</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">উইং / শাখা / ট্যাগলাইন (Wing/Tagline)</label>
                        <input type="text" name="org_wing" value="{{ old('org_wing', $siteSettings['org_wing']) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900 font-semibold text-blue-900">
                        <span class="text-[10px] text-slate-400 mt-1 block">যেমন: International Legal Aid & Human Rights Foundation</span>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">সংক্ষিপ্ত অঙ্গীকার / স্লোগান</label>
                        <input type="text" name="site_slogan" value="{{ old('site_slogan', $siteSettings['site_slogan']) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900 text-slate-700">
                        <span class="text-[10px] text-slate-400 mt-1 block">আইডি কার্ডের পেছনের শিরোনাম ও হেডারে প্রদর্শিত হবে</span>
                    </div>
                </div>

            </div>


            <!-- ================= TAB 2: ID CARD & SIGNATURE ================= -->
            <div x-show="currentTab === 'idcard'" x-cloak class="space-y-6">

                <!-- Signature Upload Box -->
                <div class="p-6 rounded-2xl border-2 border-blue-200 bg-blue-50/50">
                    <label class="block font-bold text-slate-900 text-sm mb-1">
                        <i class="fa-solid fa-signature text-blue-700 mr-1.5"></i>চেয়ারম্যানের ডিজিটাল স্বাক্ষর (Chairman Digital Signature)
                    </label>
                    <p class="text-[11px] text-slate-500 mb-3">আইডি কার্ডের পেছনের অংশে চেয়ারম্যানের স্বাক্ষরের জন্য সাদা কাগজ বা স্বচ্ছ ব্যাকগ্রাউন্ডের (PNG/JPG) স্বাক্ষর আপলোড করুন। ফাঁকা রাখলে ডিফল্ট স্বাক্ষর প্রদর্শিত হবে।</p>
                    
                    <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-5 mb-3">
                        <div class="w-36 h-18 rounded-xl bg-white border border-blue-200 p-2 shadow-sm flex items-center justify-center flex-shrink-0">
                            @if($authorizedSignatureUrl)
                                <img src="{{ $authorizedSignatureUrl }}" alt="Signature" class="max-h-full max-w-full object-contain">
                            @else
                                <img src="{{ asset('images/chairman_signature.png') }}" alt="Default Signature" class="max-h-full max-w-full object-contain">
                            @endif
                        </div>
                        <div class="flex-grow w-full">
                            <input type="file" name="authorized_signature_img" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-500">
                            <span class="text-[10px] text-slate-400 mt-1 block">সমর্থিত ফরম্যাট: PNG, JPG (স্বচ্ছ ব্যাকগ্রাউন্ড সবচেয়ে ভালো দেখায়)</span>
                        </div>
                    </div>

                    @if($authorizedSignatureUrl)
                        <label class="inline-flex items-center text-[11px] text-rose-600 font-semibold cursor-pointer">
                            <input type="checkbox" name="delete_signature" value="1" class="rounded border-slate-300 text-rose-600 mr-1.5">
                            <span>আপলোডকৃত কাস্টম স্বাক্ষর মুছে ডিফল্ট স্বাক্ষর ব্যবহার করুন</span>
                        </label>
                    @endif
                </div>

                <!-- ID Card Rules & Controls -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">স্বাক্ষরকারী পদবী <span class="text-rose-500">*</span></label>
                        <input type="text" name="authorized_signature_title" value="{{ old('authorized_signature_title', $siteSettings['authorized_signature_title'] ?? 'Chairman') }}" required
                            placeholder="যেমন: Chairman"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900 font-bold text-slate-900">
                        <span class="text-[10px] text-slate-400 mt-1 block">কার্ডের পেছনের স্বাক্ষরের নিচে প্রদর্শিত পদবী</span>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">কার্ডের মেয়াদকাল (বছর) <span class="text-rose-500">*</span></label>
                        <input type="number" name="id_card_validity_years" value="{{ old('id_card_validity_years', $siteSettings['id_card_validity_years'] ?? '2') }}" required min="1" max="10"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900 font-bold">
                        <span class="text-[10px] text-slate-400 mt-1 block">নতুন কার্ড তৈরির তারিখ থেকে মেয়াদ হিসাব হবে</span>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">কার্ড নম্বর প্রিফিক্স (ঐচ্ছিক)</label>
                        <input type="text" name="id_card_prefix" value="{{ old('id_card_prefix', $siteSettings['id_card_prefix'] ?? '') }}"
                            placeholder="ফাঁকা রাখুন (ডিফল্ট: 00001)"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-slate-900 font-bold">
                        <span class="text-[10px] text-slate-400 mt-1 block">ফাঁকা রাখলে সরাসরি ৫ ডিজিটের ক্রমিক নম্বর তৈরি হবে (যেমন: 00001, 00002)</span>
                    </div>
                </div>

                <!-- Info note explaining card back contact details -->
                <div class="p-4 rounded-2xl bg-amber-50/60 border border-amber-200 text-xs text-slate-700 flex items-start space-x-3">
                    <i class="fa-solid fa-circle-info text-amber-600 text-base mt-0.5 flex-shrink-0"></i>
                    <div>
                        <strong class="text-slate-900 block">কার্ডের পেছনের যোগাযোগের তথ্য:</strong>
                        <p class="text-[11px] text-slate-600 mt-0.5">
                            আইডি কার্ডের পেছনের কিউআর কোড স্বয়ংক্রিয়ভাবে জেনারেট হয়। হটলাইন নম্বর, অফিশিয়াল ইমেইল, ওয়েবসাইট লিংক ও অফিসের ঠিকানা পরিবর্তন করতে পাশের <strong>"যোগাযোগ ও অফিস ঠিকানা"</strong> ট্যাব ব্যবহার করুন।
                        </p>
                    </div>
                </div>

            </div>


            <!-- ================= TAB 3: CONTACT & ADDRESS ================= -->
            <div x-show="currentTab === 'contact'" x-cloak class="space-y-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">ওয়েবসাইট জরুরি হটলাইন / ফোন</label>
                        <input type="text" name="site_phone" value="{{ old('site_phone', $siteSettings['site_phone']) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-slate-900">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">আইডি কার্ডের জরুরি সহায়তা নম্বর</label>
                        <input type="text" name="id_card_emergency_contact" value="{{ old('id_card_emergency_contact', $siteSettings['id_card_emergency_contact']) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-slate-900">
                        <span class="text-[10px] text-slate-400 mt-1 block">আইডি কার্ডের পেছনে হাইলাইট হয়ে থাকবে</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">অফিশিয়াল ইমেইল ঠিকানা</label>
                        <input type="email" name="site_email" value="{{ old('site_email', $siteSettings['site_email']) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">ওয়েবসাইট লিংক (Website URL)</label>
                        <input type="text" name="site_website" value="{{ old('site_website', $siteSettings['site_website'] ?? 'https://internationallegalaidhumanrightsfoundration.org') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">কার্ড লাইসেন্স নম্বর (Licence No)</label>
                        <input type="text" name="licence_no" value="{{ old('licence_no', $siteSettings['licence_no'] ?? 'Licence No-s-15472/2026') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900 font-semibold">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">কার্ডে কার্যালয় ঠিকানা (লাইন ১)</label>
                        <input type="text" name="id_card_office_address" value="{{ old('id_card_office_address', $siteSettings['id_card_office_address']) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">কার্ডে কার্যালয় ঠিকানা (লাইন ২)</label>
                    <input type="text" name="id_card_office_address_2" value="{{ old('id_card_office_address_2', $siteSettings['id_card_office_address_2'] ?? 'lift-08purana Paltan,culbut Road,dhaka') }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">কেন্দ্রীয় কার্যালয়ের বিস্তারিত ঠিকানা</label>
                    <textarea name="site_address" rows="2"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900">{{ old('site_address', $siteSettings['site_address']) }}</textarea>
                    <span class="text-[10px] text-slate-400 mt-1 block">ওয়েবসাইটের ফুটার ও যোগাযোগ পেজে প্রদর্শিত হবে</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">ফেসবুক পেজ / গ্রুপ লিংক</label>
                        <input type="url" name="site_facebook" value="{{ old('site_facebook', $siteSettings['site_facebook']) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">ইউটিউব চ্যানেল লিংক</label>
                        <input type="url" name="site_youtube" value="{{ old('site_youtube', $siteSettings['site_youtube']) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                </div>

                <div class="p-4 bg-amber-50/60 rounded-2xl border border-amber-200/80">
                    <label class="block font-bold text-slate-900 mb-1 flex items-center text-xs">
                        <i class="fa-solid fa-newspaper text-amber-600 mr-2 text-sm"></i>
                        <span>সারা দেশের খবর লিংক (News Portal Link)</span>
                    </label>
                    <input type="url" name="news_link" value="{{ old('news_link', $siteSettings['news_link'] ?? 'https://bnews24.com/?p=40163') }}" placeholder="https://bnews24.com/?p=40163"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900 bg-white">
                    <span class="text-[10px] text-slate-500 mt-1 block">
                        ★ ওয়েবসাইটের হেডার মেনু ও মোবাইল মেনুতে <strong>"সারা দেশের খবর"</strong> লিংকে ক্লিক করলে এই ঠিকানায় নিয়ে যাবে (যেমন: https://bnews24.com/?p=40163)।
                    </span>
                </div>

            </div>


            <!-- Submit Action Footer -->
            <div class="pt-6 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <span class="text-[11px] text-slate-400">
                    <i class="fa-solid fa-circle-info text-amber-500 mr-1"></i>সেটিংস পরিবর্তনের সাথে সাথে কার্ড ও সাইটে তাৎক্ষণিক কার্যকর হবে।
                </span>

                <button type="submit" class="w-full sm:w-auto px-8 py-3 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-extrabold text-xs shadow-lg transition flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>সকল সেটিংস সংরক্ষণ করুন</span>
                </button>
            </div>

        </form>

    </div>

</div>
@endsection
