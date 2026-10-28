@extends('layouts.app')

@section('title', 'হোম - আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন')

@section('content')
<!-- Hero Section with Organization Banner -->
<section class="relative bg-gradient-to-b from-[#081a2b] via-[#0d2b45] to-[#07192b] text-white overflow-hidden pt-8 sm:pt-12 pb-0">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            
            <!-- Left Info -->
            <div class="lg:col-span-7 space-y-5 text-center lg:text-left">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-400/30 text-amber-300 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                    <span>সারাবিশ্বে আইনি সহায়তা ও মানবাধিকার সুরক্ষা</span>
                </div>
                
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                    নিপীড়িত মানুষের ভরসা, <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-amber-400 to-yellow-200">
                        আইনি অধিকার ও ন্যায়ের প্রতীক
                    </span>
                </h1>
                
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    {{ $siteSettings['org_name_bn'] ?? 'আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন' }}—ন্যায় বিচার প্রতিষ্ঠায় আপোষহীন ও সার্বজনীন মানবাধিকার সুরক্ষায় অঙ্গীকারবদ্ধ। যেকোনো ধরণের অন্যায়, অবিচার বা মানবাধিকার লঙ্ঘনের বিরুদ্ধে আমরা আইনি সহায়তা পৌঁছে দিই।
                </p>

                <!-- Action CTAs -->
                <div class="flex flex-wrap justify-center lg:justify-start gap-3 pt-2">
                    <a href="{{ route('complaints.create') }}" class="px-5 py-3 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-brand-950 font-bold text-sm shadow-lg shadow-amber-500/20 flex items-center space-x-2 transition transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-file-pen text-base"></i>
                        <span>অনলাইন অভিযোগ দাখিল</span>
                    </a>
                    
                    <a href="{{ route('track') }}" class="px-5 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-sm border border-white/20 backdrop-blur-sm flex items-center space-x-2 transition">
                        <i class="fa-solid fa-magnifying-glass text-amber-400"></i>
                        <span>অভিযোগ ট্র্যাকিং</span>
                    </a>

                    <a href="{{ route('member.create') }}" class="px-5 py-3 rounded-xl bg-brand-800 hover:bg-brand-700 text-slate-200 font-semibold text-sm border border-brand-700 flex items-center space-x-2 transition">
                        <i class="fa-solid fa-user-plus text-blue-400"></i>
                        <span>সদস্য আবেদন</span>
                    </a>
                </div>

                <!-- Verified Stats Ribbon -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-6 border-t border-brand-700/60 max-w-2xl">
                    <div class="bg-brand-900/60 p-3 rounded-xl border border-brand-700/40 text-center">
                        <p class="text-2xl font-black text-amber-400 font-mono">{{ $stats['total_complaints'] }}+</p>
                        <p class="text-[11px] text-slate-300">মোট অভিযোগ</p>
                    </div>
                    <div class="bg-brand-900/60 p-3 rounded-xl border border-brand-700/40 text-center">
                        <p class="text-2xl font-black text-emerald-400 font-mono">{{ $stats['completed'] }}+</p>
                        <p class="text-[11px] text-slate-300">নিষ্পত্তিকৃত</p>
                    </div>
                    <div class="bg-brand-900/60 p-3 rounded-xl border border-brand-700/40 text-center">
                        <p class="text-2xl font-black text-blue-400 font-mono">{{ $stats['investigated'] }}+</p>
                        <p class="text-[11px] text-slate-300">তদন্তাধীন</p>
                    </div>
                    <div class="bg-brand-900/60 p-3 rounded-xl border border-brand-700/40 text-center">
                        <p class="text-2xl font-black text-amber-300 font-mono">{{ $stats['total_members'] }}+</p>
                        <p class="text-[11px] text-slate-300">সক্রিয় সদস্য</p>
                    </div>
                </div>
            </div>

            <!-- Right Visual Banner / Card -->
            <div class="lg:col-span-5 flex justify-center">
                <div class="relative w-full max-w-md bg-gradient-to-tr from-brand-900 to-slate-800 p-2 rounded-2xl shadow-2xl border border-brand-700/50">
                    <div class="overflow-hidden rounded-xl">
                        <img src="{{ asset('images/crime_banner.jpg') }}" alt="Crime Investigation Team Banner" class="w-full h-64 sm:h-72 object-cover hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-4 bg-brand-950/90 rounded-xl mt-2 border border-brand-800 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $siteLogo }}" class="w-11 h-11 rounded-full bg-white p-0.5 shadow object-contain">
                            <div>
                                <h4 class="text-xs font-bold text-white">{{ $siteSettings['org_wing'] ?? 'জরুরি সহায়তা সেল' }}</h4>
                                <p class="text-[11px] text-emerald-400 font-medium">২৪ ঘণ্টা মনিটরিং</p>
                            </div>
                        </div>
                        <a href="tel:{{ $siteSettings['site_phone'] ?? '01644416378' }}" class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold shadow flex items-center space-x-1.5 transition">
                            <i class="fa-solid fa-phone"></i>
                            <span>কল করুন</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bottom Seamless Wave Divider Transition to Body -->
    <div class="relative w-full overflow-hidden leading-none z-10 -mb-1 mt-8">
        <svg class="relative block w-full h-8 sm:h-12 text-slate-50 fill-current" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0 C300,70 600,-30 900,50 C1050,90 1150,30 1200,40 L1200,120 L0,120 Z"></path>
        </svg>
    </div>
</section>

<!-- Quick Action Services Grid -->
<section class="py-12 sm:py-16 bg-slate-50 relative z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-10">
            <div class="inline-flex items-center space-x-2 px-3.5 py-1 rounded-full bg-brand-900/5 border border-brand-900/15 text-brand-900 text-xs font-bold mb-2">
                <i class="fa-solid fa-shield-halved text-amber-500"></i>
                <span>নাগরিক সেবাসমূহ</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">প্রধান সেবাসমূহ</h2>
            <p class="text-xs sm:text-sm text-slate-600 mt-1.5 leading-relaxed">সহজেই অনলাইন সেবা গ্রহণ করুন অথবা আপনার দায়েরকৃত আবেদনের সার্বক্ষণিক অগ্রগতি জানুন</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Service 1: File Complaint -->
            <a href="{{ route('complaints.create') }}" class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-slate-200/90 hover:border-amber-400 transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 to-amber-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 text-brand-950 flex items-center justify-center text-2xl mb-5 shadow-lg shadow-amber-500/20 group-hover:scale-110 group-hover:rotate-3 transition duration-300 flex-shrink-0">
                        <i class="fa-solid fa-file-signature"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-amber-600 transition">অভিযোগ দাখিল</h3>
                    <p class="text-xs text-slate-500 mt-2.5 leading-relaxed">
                        জমিজমা বিরোধ, পারিবারিক সমস্যা, নির্যাতন, অর্থ আত্মসাৎ বা প্রতারণার বিষয়ে সরাসরি লিখিত অভিযোগ জানান।
                    </p>
                </div>
                <div class="pt-4 mt-5 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-amber-600 group-hover:text-amber-700">ফর্ম পূরণ করুন</span>
                    <span class="w-7 h-7 rounded-full bg-amber-50 text-amber-600 group-hover:bg-amber-500 group-hover:text-brand-950 flex items-center justify-center text-xs transition duration-200">
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-0.5 transition"></i>
                    </span>
                </div>
            </a>

            <!-- Service 2: Track Status -->
            <a href="{{ route('track') }}" class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-slate-200/90 hover:border-emerald-500 transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-400 to-teal-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center text-2xl mb-5 shadow-lg shadow-emerald-500/20 group-hover:scale-110 group-hover:rotate-3 transition duration-300 flex-shrink-0">
                        <i class="fa-solid fa-magnifying-glass-chart"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition">অভিযোগ ট্র্যাকিং</h3>
                    <p class="text-xs text-slate-500 mt-2.5 leading-relaxed">
                        আপনার দায়েরকৃত অভিযোগের বর্তমান অবস্থা, তদন্ত অগ্রগতি এবং অফিসিয়াল সিদ্ধান্ত সরাসরি ট্র্যাক করুন।
                    </p>
                </div>
                <div class="pt-4 mt-5 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-emerald-600 group-hover:text-emerald-700">স্ট্যাটাস যাচাই</span>
                    <span class="w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white flex items-center justify-center text-xs transition duration-200">
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-0.5 transition"></i>
                    </span>
                </div>
            </a>

            <!-- Service 3: Member Application -->
            <a href="{{ route('member.create') }}" class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-slate-200/90 hover:border-blue-500 transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center text-2xl mb-5 shadow-lg shadow-blue-500/20 group-hover:scale-110 group-hover:rotate-3 transition duration-300 flex-shrink-0">
                        <i class="fa-solid fa-id-card-clip"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition">সদস্য আবেদন</h3>
                    <p class="text-xs text-slate-500 mt-2.5 leading-relaxed">
                        মানবাধিকার রক্ষা ও সামাজিক সেবামূলক কাজে নিজেকে যুক্ত করতে সংস্থার জেলা বা উপজেলা সদস্য হিসেবে আবেদন করুন।
                    </p>
                </div>
                <div class="pt-4 mt-5 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-blue-600 group-hover:text-blue-700">আবেদন করুন</span>
                    <span class="w-7 h-7 rounded-full bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white flex items-center justify-center text-xs transition duration-200">
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-0.5 transition"></i>
                    </span>
                </div>
            </a>

            <!-- Service 4: Members Directory -->
            <a href="{{ route('members.directory') }}" class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-slate-200/90 hover:border-purple-500 transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-500 to-pink-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-600 text-white flex items-center justify-center text-2xl mb-5 shadow-lg shadow-purple-500/20 group-hover:scale-110 group-hover:rotate-3 transition duration-300 flex-shrink-0">
                        <i class="fa-solid fa-users-viewfinder"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-purple-600 transition">অনুমোদিত সদস্য তালিকা</h3>
                    <p class="text-xs text-slate-500 mt-2.5 leading-relaxed">
                        ফাউন্ডেশনের কেন্দ্রীয়, জেলা ও উপজেলা পর্যায়ের অনুমোদিত সদস্যদের বিস্তারিত পরিচিতি ও পদবী দেখুন।
                    </p>
                </div>
                <div class="pt-4 mt-5 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-purple-600 group-hover:text-purple-700">তালিকা দেখুন</span>
                    <span class="w-7 h-7 rounded-full bg-purple-50 text-purple-600 group-hover:bg-purple-600 group-hover:text-white flex items-center justify-center text-xs transition duration-200">
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-0.5 transition"></i>
                    </span>
                </div>
            </a>

            <!-- Service 5: ID Card Verify -->
            <a href="{{ route('member.verify') }}" class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-slate-200/90 hover:border-cyan-500 transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-cyan-400 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 text-white flex items-center justify-center text-2xl mb-5 shadow-lg shadow-cyan-500/20 group-hover:scale-110 group-hover:rotate-3 transition duration-300 flex-shrink-0">
                        <i class="fa-solid fa-id-card"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-cyan-600 transition">আইডি কার্ড যাচাই</h3>
                    <p class="text-xs text-slate-500 mt-2.5 leading-relaxed">
                        সদস্যের সঠিক কার্ড নম্বর বা মোবাইল নম্বর দিয়ে ডিজিটাল পরিচয়পত্র ও অফিসিয়াল অনুমোদন যাচাই করুন।
                    </p>
                </div>
                <div class="pt-4 mt-5 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-cyan-600 group-hover:text-cyan-700">যাচাই করুন</span>
                    <span class="w-7 h-7 rounded-full bg-cyan-50 text-cyan-600 group-hover:bg-cyan-600 group-hover:text-white flex items-center justify-center text-xs transition duration-200">
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-0.5 transition"></i>
                    </span>
                </div>
            </a>

            <!-- Service 6: About & Objectives -->
            <a href="{{ route('about') }}" class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-slate-200/90 hover:border-indigo-600 transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 to-slate-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-600 to-slate-800 text-white flex items-center justify-center text-2xl mb-5 shadow-lg shadow-indigo-500/20 group-hover:scale-110 group-hover:rotate-3 transition duration-300 flex-shrink-0">
                        <i class="fa-solid fa-landmark"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition">পরিচিতি ও লক্ষ্য</h3>
                    <p class="text-xs text-slate-500 mt-2.5 leading-relaxed">
                        মানবাধিকার ফাউন্ডেশনের মূল গঠনতন্ত্র, কর্মপরিকল্পনা, আইন সহায়তা কার্যক্রম এবং লক্ষ্য-উদ্দেশ্য।
                    </p>
                </div>
                <div class="pt-4 mt-5 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-indigo-600 group-hover:text-indigo-700">পরিচিতি দেখুন</span>
                    <span class="w-7 h-7 rounded-full bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white flex items-center justify-center text-xs transition duration-200">
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-0.5 transition"></i>
                    </span>
                </div>
            </a>

            <!-- Service 7: Notices & News -->
            <a href="{{ route('notices') }}" class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-slate-200/90 hover:border-rose-500 transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-rose-500 to-red-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-rose-500 to-red-600 text-white flex items-center justify-center text-2xl mb-5 shadow-lg shadow-rose-500/20 group-hover:scale-110 group-hover:rotate-3 transition duration-300 flex-shrink-0">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-rose-600 transition">জরুরি নোটিশ</h3>
                    <p class="text-xs text-slate-500 mt-2.5 leading-relaxed">
                        ফাউন্ডেশনের গুরুত্বপূর্ণ দাপ্তরিক নোটিশ, জরুরি সংবাদ, সমন্বয় সভা ও আইনি সতর্কবার্তা সমূহ।
                    </p>
                </div>
                <div class="pt-4 mt-5 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-rose-600 group-hover:text-rose-700">নোটিশ পড়ুন</span>
                    <span class="w-7 h-7 rounded-full bg-rose-50 text-rose-600 group-hover:bg-rose-600 group-hover:text-white flex items-center justify-center text-xs transition duration-200">
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-0.5 transition"></i>
                    </span>
                </div>
            </a>

            <!-- Service 8: Contact & Helpline -->
            <a href="{{ route('contact') }}" class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-slate-200/90 hover:border-teal-500 transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-teal-400 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-teal-500 to-emerald-600 text-white flex items-center justify-center text-2xl mb-5 shadow-lg shadow-teal-500/20 group-hover:scale-110 group-hover:rotate-3 transition duration-300 flex-shrink-0">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-teal-600 transition">যোগাযোগ ও হেল্পলাইন</h3>
                    <p class="text-xs text-slate-500 mt-2.5 leading-relaxed">
                        কেন্দ্রীয় কার্যালয়ের অবস্থান, জরুরি পরামর্শ সহায়তা এবং অফিশিয়াল হেল্পলাইনে যোগাযোগ।
                    </p>
                </div>
                <div class="pt-4 mt-5 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-teal-600 group-hover:text-teal-700">যোগাযোগ করুন</span>
                    <span class="w-7 h-7 rounded-full bg-teal-50 text-teal-600 group-hover:bg-teal-600 group-hover:text-white flex items-center justify-center text-xs transition duration-200">
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-0.5 transition"></i>
                    </span>
                </div>
            </a>

        </div>
    </div>
</section>

<!-- How to Submit Complaint (Step by Step Flowchart) -->
<section class="py-14 sm:py-18 bg-white border-y border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-12">
            <div class="inline-flex items-center space-x-2 px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-300 text-amber-700 text-xs font-bold mb-2">
                <i class="fa-solid fa-list-check text-amber-500"></i>
                <span>সহজ ৩টি ধাপ</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">অভিযোগ দায়ের করার নিয়মাবলী</h2>
            <p class="text-xs sm:text-sm text-slate-600 mt-1.5">অনলাইনে ঘরে বসেই আপনার অভিযোগ জমা দিন এবং দ্রুততম সময়ে আইনি সহায়তা গ্রহণ করুন</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 relative">
            
            <!-- Step 1 -->
            <div class="bg-gradient-to-b from-slate-50 to-white p-7 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between relative group">
                <div>
                    <div class="flex items-center justify-between mb-5">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center text-xl shadow-sm group-hover:scale-105 transition">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-500 text-brand-950 font-mono shadow-sm">ধাপ ০১</span>
                    </div>
                    <h3 class="font-extrabold text-slate-900 text-base">তথ্য ও বিবরণ পূরণ</h3>
                    <p class="text-xs text-slate-600 mt-2.5 leading-relaxed">
                        অভিযোগকারীর পূর্ণ তথ্য, অভিযুক্ত ব্যক্তি বা আসামির পরিচয় এবং ঘটনার সুস্পষ্ট তারিখ, সময় ও বিবরণ নির্ভুলভাবে লিখুন।
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center text-xs font-semibold text-amber-600">
                    <i class="fa-solid fa-circle-check mr-2 text-amber-500"></i>
                    <span>সহজ অনলাইন ফরম</span>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="bg-gradient-to-b from-slate-50 to-white p-7 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between relative group">
                <div>
                    <div class="flex items-center justify-between mb-5">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 flex items-center justify-center text-xl shadow-sm group-hover:scale-105 transition">
                            <i class="fa-solid fa-mobile-screen-button"></i>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-600 text-white font-mono shadow-sm">ধাপ ০২</span>
                    </div>
                    <h3 class="font-extrabold text-slate-900 text-base">প্রসেসিং ফি পেমেন্ট</h3>
                    <p class="text-xs text-slate-600 mt-2.5 leading-relaxed">
                        বিকাশ, নগদ বা রকেট-এর মাধ্যমে নির্ধারিত সরকারি/প্রাতিষ্ঠানিক ফি জমা দিয়ে প্রাপ্ত ট্রানজেকশন আইডি (TrxID) এন্ট্রি করুন।
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center text-xs font-semibold text-emerald-600">
                    <i class="fa-solid fa-circle-check mr-2 text-emerald-500"></i>
                    <span>তাৎক্ষণিক ভেরিফিকেশন</span>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="bg-gradient-to-b from-slate-50 to-white p-7 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between relative group">
                <div>
                    <div class="flex items-center justify-between mb-5">
                        <div class="w-12 h-12 rounded-2xl bg-blue-500/10 border border-blue-500/20 text-blue-600 flex items-center justify-center text-xl shadow-sm group-hover:scale-105 transition">
                            <i class="fa-solid fa-shield-virus"></i>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-black bg-blue-600 text-white font-mono shadow-sm">ধাপ ০৩</span>
                    </div>
                    <h3 class="font-extrabold text-slate-900 text-base">ট্র্যাকিং ও আইনি পদক্ষেপ</h3>
                    <p class="text-xs text-slate-600 mt-2.5 leading-relaxed">
                        অভিযোগ সাবমিট হওয়ার সাথে সাথেই আপনি ট্র্যাকিং নম্বর পাবেন এবং মানবাধিকার তদন্ত টিম অভিযোগের সত্যতা যাচাইয়ে পদক্ষেপ গ্রহণ করবে।
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center text-xs font-semibold text-blue-600">
                    <i class="fa-solid fa-circle-check mr-2 text-blue-500"></i>
                    <span>সার্বক্ষণিক লাইভ ট্র্যাকিং</span>
                </div>
            </div>

        </div>

        <!-- Action CTAs -->
        <div class="text-center mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ route('complaints.create') }}" class="inline-flex items-center space-x-2 px-6 py-3.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-brand-950 font-black text-xs shadow-lg shadow-amber-500/20 transition transform hover:-translate-y-0.5">
                <i class="fa-solid fa-file-pen text-sm"></i>
                <span>এখনই অভিযোগ জমা দিন</span>
            </a>
            <a href="{{ route('track') }}" class="inline-flex items-center space-x-2 px-6 py-3.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-md transition transform hover:-translate-y-0.5">
                <i class="fa-solid fa-magnifying-glass text-amber-400"></i>
                <span>অভিযোগ ট্র্যাকিং করুন</span>
            </a>
        </div>
    </div>
</section>

{{-- 
<!-- Recent Public Complaints / Activity (Hidden per client request - kept private inside dashboard) -->
<section class="py-12 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-6">
            <div>
                <span class="text-xs font-bold text-emerald-600 uppercase">স্বচ্ছতা ও জবাবদিহিতা</span>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900 mt-1">সাম্প্রতিক অভিযোগ ও অগ্রগতি</h2>
            </div>
            <a href="{{ route('track') }}" class="text-xs font-bold text-brand-700 hover:text-amber-600 mt-2 sm:mt-0 flex items-center">
                <span>সকল অভিযোগ ট্র্যাক করুন</span>
                <i class="fa-solid fa-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($recentComplaints as $c)
                <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-[11px] font-mono font-bold text-slate-500">আইডি: #{{ $c->id }}</span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold border {{ $c->status_badge['bg'] }}">
                                {{ $c->status_badge['label'] }}
                            </span>
                        </div>
                        <h4 class="text-sm font-bold text-slate-800">{{ $c->name }}</h4>
                        <p class="text-xs text-amber-600 font-medium mt-0.5"><i class="fa-solid fa-tag mr-1 text-[10px]"></i>{{ $c->complaint_type }}</p>
                        <p class="text-xs text-slate-500 mt-2 line-clamp-2">{{ $c->details ?: 'কোনো বিবরণ প্রদান করা হয়নি।' }}</p>
                    </div>
                    <div class="pt-3 mt-3 border-t border-slate-100 flex justify-between items-center text-[11px] text-slate-400">
                        <span><i class="fa-solid fa-location-dot mr-1 text-slate-400"></i>{{ $c->district }}</span>
                        <span>{{ $c->created_at ? $c->created_at->format('d M, Y') : $c->time }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-8 text-slate-400 text-xs">
                    কোনো সাম্প্রতিক অভিযোগ পাওয়া যায়নি।
                </div>
            @endforelse
        </div>
    </div>
</section>
--}}

<!-- Recent Dynamic Notices Section -->
@if(isset($recentNotices) && $recentNotices->count() > 0)
<section class="py-14 bg-slate-50/70 border-t border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 gap-4">
            <div>
                <span class="text-xs font-bold text-amber-600 uppercase tracking-wider flex items-center">
                    <i class="fa-solid fa-bullhorn mr-1.5 animate-pulse text-amber-500"></i>জনস্বার্থে অফিশিয়াল বিজ্ঞপ্তি
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">সাম্প্রতিক নোটিশ ও আইনি বার্তা</h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">সংস্থার সাম্প্রতিক দাপ্তরিক প্রজ্ঞাপন ও জরুরি দিকনির্দেশনাসমূহ</p>
            </div>
            <a href="{{ route('notices') }}" class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-amber-400 text-xs font-bold transition shadow-sm">
                <span>সকল নোটিশ দেখুন</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($recentNotices as $rn)
                <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-xs">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold border {{ $rn->category_badge['bg'] }}">
                                {{ $rn->category }}
                            </span>
                            <span class="text-slate-400 text-[11px] font-medium">
                                <i class="fa-regular fa-calendar mr-1"></i>{{ $rn->formatted_date }}
                            </span>
                        </div>

                        <h3 class="text-sm sm:text-base font-bold text-slate-900 group-hover:text-blue-700 transition line-clamp-2">
                            <a href="{{ route('notices.show', $rn->id) }}">
                                {{ $rn->title }}
                            </a>
                        </h3>

                        @if($rn->description)
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                {{ Str::limit(strip_tags($rn->description), 110) }}
                            </p>
                        @endif
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                        @if($rn->has_file)
                            <a href="{{ $rn->file_url }}" target="_blank" class="inline-flex items-center text-xs font-bold text-rose-600 hover:text-rose-700">
                                <i class="fa-solid fa-file-pdf mr-1"></i>
                                <span>PDF সংযুক্তি</span>
                            </a>
                        @else
                            <span class="text-[11px] text-slate-400 italic">বিজ্ঞপ্তি</span>
                        @endif

                        <a href="{{ route('notices.show', $rn->id) }}" class="inline-flex items-center text-xs font-bold text-slate-700 group-hover:text-blue-700 space-x-1">
                            <span>পড়ুন</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Recent Photo Gallery Section -->
@if(isset($recentPhotos) && $recentPhotos->count() > 0)
<section class="py-12 bg-white border-t border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-6 gap-3">
            <div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">সাম্প্রতিক ফটো গ্যালারি</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">সংস্থার বিভিন্ন কার্যক্রম ও কর্মসূচির চিত্র</p>
            </div>
            <a href="{{ route('gallery') }}" class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-amber-400 text-xs font-bold transition shadow-sm">
                <span>সব ছবি দেখুন</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
            @foreach($recentPhotos as $rp)
                <a href="{{ route('gallery') }}" class="group bg-white rounded-xl sm:rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col">
                    <div class="relative aspect-[4/3] bg-slate-100 overflow-hidden">
                        <img src="{{ $rp->image_url }}" alt="{{ $rp->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @if($rp->category)
                            <span class="absolute top-2 left-2 bg-slate-950/75 text-amber-300 text-[10px] font-bold px-2 py-0.5 rounded backdrop-blur-xs">
                                {{ $rp->category }}
                            </span>
                        @endif
                    </div>
                    <div class="p-3 flex-grow flex flex-col justify-between">
                        <h3 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-amber-600 transition line-clamp-1">
                            {{ $rp->title }}
                        </h3>
                        @if($rp->formatted_date)
                            <p class="text-[11px] text-slate-400 mt-1 flex items-center">
                                <i class="fa-regular fa-calendar mr-1.5 text-amber-500"></i>
                                {{ $rp->formatted_date }}
                            </p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
