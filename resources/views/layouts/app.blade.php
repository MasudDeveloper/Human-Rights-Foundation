<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#0d2b45">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="মানবাধিকার ফাউন্ডেশন">

    <title>@yield('title', 'আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন') - {{ $siteSettings['org_name_en'] ?? 'International Legal Aid & Human Rights Foundation' }}</title>
    
    <!-- PWA Manifest & Favicon -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="icon" type="image/png" href="{{ $siteFavicon }}">
    <link rel="apple-touch-icon" href="{{ $siteFavicon }}">

    <!-- Google Fonts: Hind Siliguri for Bengali + Plus Jakarta Sans for UI/Numbers -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS (Play CDN for rapid reactive design & consistent layout) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0f7ff',
                            100: '#e0effe',
                            200: '#b9dffe',
                            600: '#0b5a9e',
                            700: '#07457d',
                            800: '#0c355f',
                            900: '#0d2b45',
                            950: '#081a2b',
                        },
                        gold: {
                            500: '#f59e0b',
                            600: '#d97706',
                        }
                    },
                    fontFamily: {
                        bangla: ['"Hind Siliguri"', 'sans-serif'],
                        sans: ['"Plus Jakarta Sans"', '"Hind Siliguri"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js for Interactive Dropdowns & Drawers -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Hind Siliguri', 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .glass-nav {
            background: rgba(13, 43, 69, 0.95);
            backdrop-filter: blur(10px);
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 3px;
        }
        /* Native PWA Bottom bar padding on mobile */
        @media (max-width: 768px) {
            .mobile-bottom-space {
                padding-bottom: 72px;
            }
        }
    </style>
    @yield('styles')
</head>
<body class="bg-slate-50 min-h-screen flex flex-col mobile-bottom-space" x-data="{ mobileSidebar: false }" @keydown.escape.window="mobileSidebar = false">

    @if(session('impersonating_by_admin'))
        <div class="bg-amber-400 text-slate-950 px-4 py-2 text-xs font-bold flex justify-between items-center shadow-md sticky top-0 z-50 border-b border-amber-500">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-user-secret text-base text-slate-900"></i>
                <span>সুপার অ্যাডমিন ইম্পার্সোনেশন মোড: আপনি নাগরিক <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->number }})-এর অ্যাকাউন্টে লগইন অবস্থায় আছেন।</span>
            </div>
            <form method="POST" action="{{ route('admin.leave_impersonation') }}">
                @csrf
                <button type="submit" class="px-3 py-1 bg-slate-950 text-amber-300 rounded-lg hover:bg-slate-800 transition shadow">
                    <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i>অ্যাডমিন প্যানেলে ফিরে যান
                </button>
            </form>
        </div>
    @endif

    <!-- ================= TIER 1: LIVE NOTICE MARQUEE TICKER BAR ================= -->
    <div class="bg-[#051322] text-white text-xs py-2 px-4 border-b border-amber-500/20 shadow-inner">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-3">
            <!-- Live Ticker Label -->
            <div class="flex items-center space-x-2 flex-shrink-0 z-10">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-500 text-slate-950 shadow-sm">
                    <i class="fa-solid fa-bullhorn mr-1.5 animate-pulse text-slate-900"></i>জরুরি আইনি বার্তা
                </span>
            </div>

            <!-- Scrolling Marquee Text -->
            <div class="flex-grow overflow-hidden text-[12px] text-slate-300 font-medium px-2">
                <marquee behavior="scroll" direction="left" scrollamount="5" onmouseover="this.stop();" onmouseout="this.start();" class="cursor-pointer">
                    @if(isset($tickerNotices) && $tickerNotices->count() > 0)
                        @foreach($tickerNotices as $tn)
                            <a href="{{ route('notices') }}" class="hover:text-amber-300 transition mr-6">
                                <span class="text-amber-400 font-bold">★ [{{ $tn->category }}]</span>
                                <span class="text-white">{{ $tn->title }}</span>
                                @if($tn->has_file)
                                    <span class="text-[10px] bg-rose-600 text-white px-1.5 py-0.2 rounded font-bold ml-1">PDF</span>
                                @endif
                            </a>
                        @endforeach
                        <span class="text-slate-400 mr-6">★ হটলাইন: {{ $siteSettings['site_phone'] ?? '01758343597' }}</span>
                        <span class="text-slate-400 mr-6">★ {{ $siteSettings['site_slogan'] ?? 'জাতিসংঘ ঘোষিত সার্বজনীন মানবাধিকার সনদ বাস্তবায়নে অঙ্গীকারবদ্ধ' }} ★</span>
                    @else
                        ★ {{ $siteSettings['site_slogan'] ?? 'জাতিসংঘ ঘোষিত সার্বজনীন মানবাধিকার সনদ বাস্তবায়নে অঙ্গীকারবদ্ধ' }} ★ যেকোনো ধরণের অবিচার, নির্যাতন, প্রতারণা বা আইনি সহায়তার জন্য সরাসরি অনলাইনে অভিযোগ দাখিল করুন ★ কেন্দ্রীয় হটলাইন: {{ $siteSettings['site_phone'] ?? '01758343597' }} ★ সরাসরি অভিযোগ ও সদস্য কার্ড অনলাইনে যাচাইযোগ্য ★
                    @endif
                </marquee>
            </div>

            <!-- Right Quick Actions -->
            <div class="hidden md:flex items-center space-x-4 text-slate-300 flex-shrink-0 text-xs">
                <a href="tel:{{ $siteSettings['site_phone'] ?? '01644416378' }}" class="hover:text-amber-300 transition flex items-center text-emerald-400 font-bold">
                    <i class="fa-solid fa-phone mr-1.5"></i>{{ $siteSettings['site_phone'] ?? '01758343597' }}
                </a>
                <span class="text-slate-600">|</span>
                <a href="{{ route('track') }}" class="hover:text-amber-300 text-amber-400 font-bold transition flex items-center">
                    <i class="fa-solid fa-location-crosshairs mr-1.5"></i>অভিযোগ ট্র্যাকিং
                </a>
            </div>
        </div>
    </div>

    <!-- ================= TIER 2: MAIN BRAND & ORGANIZATION IDENTITY ================= -->
    <div class="bg-gradient-to-r from-[#06182c] via-[#0b2949] to-[#06182c] text-white py-4 px-4 sm:px-6 lg:px-8 border-b border-brand-800 relative z-50">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            
            <!-- Logo & Organization Title -->
            <a href="{{ route('home') }}" class="flex items-center space-x-4 group text-center md:text-left">
                <div class="w-16 h-16 sm:w-20 sm:h-20 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                    <img src="{{ $siteLogo }}" alt="Organization Logo" class="max-h-full max-w-full object-contain drop-shadow-[0_6px_14px_rgba(0,0,0,0.6)]">
                </div>
                <div>
                    <h1 class="text-base sm:text-xl font-black text-white tracking-wide uppercase leading-tight group-hover:text-amber-300 transition-colors">
                        {{ $siteSettings['org_name_en'] ?? 'International Legal Aid & Human Rights Foundation' }}
                    </h1>
                    <p class="text-xs sm:text-sm text-amber-300 font-bold tracking-tight mt-0.5">
                        {{ $siteSettings['org_name_bn'] ?? 'আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন' }}
                    </p>
                    <div class="inline-flex items-center text-[10px] sm:text-[11px] text-cyan-200 font-bold mt-1 bg-white/10 px-2.5 py-0.5 rounded-full border border-white/10">
                        <i class="fa-solid fa-scale-balanced text-amber-400 mr-1.5"></i>
                        <span>{{ $siteSettings['site_slogan'] ?? 'ন্যায় বিচার প্রতিষ্ঠায় আপোষহীন' }}</span>
                    </div>
                </div>
            </a>

            <!-- Right Side: Action Badges & Citizen Auth Profile (Desktop Only) -->
            <div class="hidden md:flex items-center space-x-3">
                <!-- 24/7 Hotline Badge -->
                <a href="tel:{{ $siteSettings['site_phone'] ?? '01644416378' }}" class="hidden lg:flex items-center space-x-3 bg-white/5 hover:bg-white/10 px-3.5 py-2 rounded-2xl border border-white/10 transition text-left">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-base border border-emerald-500/30">
                        <i class="fa-solid fa-phone-volume"></i>
                    </div>
                    <div>
                        <span class="block text-[10px] text-slate-400 uppercase font-bold">২৪/৭ জরুরি হেল্পলাইন</span>
                        <strong class="font-mono text-xs text-white">{{ $siteSettings['site_phone'] ?? '01758343597' }}</strong>
                    </div>
                </a>

                <!-- PWA Install Button -->
                <button id="pwaInstallBtn" class="hidden items-center space-x-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white shadow-sm transition">
                    <i class="fa-solid fa-download"></i>
                    <span>অ্যাপ ইনস্টল</span>
                </button>

                <!-- Citizen Auth / Profile Dropdown -->
                @auth
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button type="button" @click="open = !open" class="flex items-center space-x-2.5 bg-brand-800/80 hover:bg-brand-700 px-3.5 py-2 rounded-xl border border-brand-700 transition cursor-pointer">
                            <div class="w-8 h-8 rounded-full bg-amber-400 text-brand-950 font-black flex items-center justify-center text-xs shadow">
                                {{ mb_substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="text-left hidden sm:block">
                                <span class="block text-xs font-bold text-white leading-tight">{{ Auth::user()->name }}</span>
                                <span class="block text-[10px] text-amber-300 font-mono">নাগরিক প্রোফাইল</span>
                            </div>
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 ml-1 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" x-cloak class="absolute right-0 top-full mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-slate-200 py-2 text-slate-800 z-[100] transition duration-150">
                            <div class="px-4 py-2.5 border-b border-slate-100 text-xs bg-slate-50 rounded-t-2xl">
                                <p class="font-bold text-slate-900">{{ Auth::user()->name }}</p>
                                <p class="text-slate-500 text-[11px] font-mono mt-0.5">{{ Auth::user()->number }}</p>
                            </div>
                            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-xs hover:bg-slate-50 transition text-slate-700 font-medium">
                                <i class="fa-solid fa-gauge-high mr-2.5 text-blue-600"></i>নাগরিক ড্যাশবোর্ড
                            </a>
                            <a href="{{ route('complaints.index') }}" class="flex items-center px-4 py-2 text-xs hover:bg-slate-50 transition text-slate-700 font-medium">
                                <i class="fa-solid fa-file-shield mr-2.5 text-amber-600"></i>আমার অভিযোগসমূহ
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 transition font-medium">
                                    <i class="fa-solid fa-right-from-bracket mr-2.5"></i>লগআউট
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold bg-amber-400 hover:bg-amber-300 text-slate-950 shadow transition">
                            <i class="fa-solid fa-right-to-bracket mr-1.5"></i>লগইন
                        </a>
                        <a href="{{ route('register') }}" class="hidden sm:inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white border border-white/20 transition">
                            রেজিস্ট্রেশন
                        </a>
                    </div>
                @endauth
            </div>

        </div>
    </div>

    <!-- ================= TIER 3: DEDICATED STICKY NAVIGATION BAR ================= -->
    <header class="sticky top-0 z-40 bg-[#07192b]/95 backdrop-blur-md border-y border-amber-500/30 text-white shadow-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-12">
                
                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center space-x-1 lg:space-x-1.5 text-xs font-bold">
                    <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-lg transition flex items-center space-x-1.5 {{ request()->routeIs('home') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-slate-200 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid fa-house text-[11px]"></i>
                        <span>হোম</span>
                    </a>
                    
                    <a href="{{ route('complaints.create') }}" class="px-3 py-1.5 rounded-lg transition flex items-center space-x-1.5 {{ request()->routeIs('complaints.create') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-slate-200 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid fa-file-signature text-amber-400 text-[11px]"></i>
                        <span>অভিযোগ দাখিল</span>
                    </a>
                    
                    <a href="{{ route('track') }}" class="px-3 py-1.5 rounded-lg transition flex items-center space-x-1.5 {{ request()->routeIs('track') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-slate-200 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid fa-location-crosshairs text-emerald-400 text-[11px]"></i>
                        <span>অভিযোগ ট্র্যাকিং</span>
                    </a>

                    <a href="{{ route('member.create') }}" class="px-3 py-1.5 rounded-lg transition flex items-center space-x-1.5 {{ request()->routeIs('member.create') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-slate-200 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid fa-user-plus text-blue-400 text-[11px]"></i>
                        <span>সদস্য আবেদন</span>
                    </a>

                    <a href="{{ route('members.directory') }}" class="px-3 py-1.5 rounded-lg transition flex items-center space-x-1.5 {{ request()->routeIs('members.directory') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-slate-200 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid fa-users text-indigo-300 text-[11px]"></i>
                        <span>সদস্যবৃন্দ</span>
                    </a>

                    <a href="{{ route('member.verify') }}" class="px-3 py-1.5 rounded-lg transition flex items-center space-x-1.5 border border-amber-400/40 {{ request()->routeIs('member.verify') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-amber-300 hover:bg-amber-400/10' }}">
                        <i class="fa-solid fa-id-card text-amber-400 text-[11px]"></i>
                        <span>আইডি কার্ড যাচাই</span>
                    </a>

                    <a href="{{ route('about') }}" class="px-3 py-1.5 rounded-lg transition flex items-center space-x-1.5 {{ request()->routeIs('about') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-slate-200 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid fa-landmark text-[11px]"></i>
                        <span>পরিচিতি ও লক্ষ্য</span>
                    </a>

                    <a href="{{ route('notices') }}" class="px-3 py-1.5 rounded-lg transition flex items-center space-x-1.5 {{ request()->routeIs('notices') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-slate-200 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid fa-bullhorn text-[11px]"></i>
                        <span>নোটিশ</span>
                    </a>

                    <a href="{{ route('contact') }}" class="px-3 py-1.5 rounded-lg transition flex items-center space-x-1.5 {{ request()->routeIs('contact') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-slate-200 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid fa-headset text-[11px]"></i>
                        <span>যোগাযোগ</span>
                    </a>
                </nav>

                <!-- Quick Urgent Action Pill on Right -->
                <div class="hidden md:flex items-center space-x-2">
                    <a href="{{ route('complaints.create') }}" class="px-3 py-1 rounded-full bg-gradient-to-r from-red-600 to-rose-700 hover:from-red-500 hover:to-rose-600 text-white font-extrabold text-[11px] shadow-md transition flex items-center space-x-1 animate-pulse">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>জরুরি আইনি সহায়তা</span>
                    </a>
                </div>

                <!-- Mobile Header Line -->
                <div class="md:hidden flex items-center justify-between w-full h-12">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <img src="{{ $siteLogo }}" alt="Logo" class="h-7 w-7 object-contain">
                        <span class="font-extrabold text-xs text-white uppercase tracking-tight">ILHR FOUNDATION</span>
                    </a>
                    
                    <div class="flex items-center space-x-2">
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-2.5 py-1 rounded-lg bg-white/10 hover:bg-white/20 text-white font-bold text-xs flex items-center space-x-1 border border-white/10">
                                <i class="fa-solid fa-user text-amber-400 text-[10px]"></i>
                                <span class="max-w-[70px] truncate text-[11px]">{{ Auth::user()->name }}</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-3 py-1 rounded-lg bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold text-xs flex items-center space-x-1 shadow-sm">
                                <i class="fa-solid fa-right-to-bracket text-[10px]"></i>
                                <span>লগইন</span>
                            </a>
                        @endauth
                        
                        <button type="button" @click="mobileSidebar = true" aria-label="Open Navigation Menu" class="w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition border border-white/15">
                            <i class="fa-solid fa-bars text-base"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- Mobile Off-Canvas Slide-In Sidebar Menu -->
    <div x-show="mobileSidebar" x-cloak class="relative z-50 md:hidden">
        <!-- Backdrop Blur Overlay -->
        <div x-show="mobileSidebar"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileSidebar = false"
             class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm"></div>

        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute inset-y-0 right-0 max-w-full flex pl-10 pointer-events-auto">
                <div x-show="mobileSidebar"
                     x-transition:enter="transform transition ease-in-out duration-300"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-300"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full"
                     class="w-screen max-w-xs bg-gradient-to-b from-[#06182c] via-[#09223d] to-[#06182c] text-white p-5 shadow-2xl flex flex-col justify-between overflow-y-auto border-l border-white/10">
                    
                    <div>
                        <!-- Drawer Top Bar with Brand & Close Button -->
                        <div class="flex items-center justify-between pb-4 border-b border-white/10">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $siteLogo }}" alt="Logo" class="h-10 w-10 object-contain rounded-full bg-white/10 p-0.5 shadow">
                                <div>
                                    <h4 class="text-xs font-black text-white leading-tight uppercase">ILHR FOUNDATION</h4>
                                    <p class="text-[10px] text-amber-300 font-bold">আইন সহায়তাকারী ফাউন্ডেশন</p>
                                </div>
                            </div>
                            <button type="button" @click="mobileSidebar = false" class="w-8 h-8 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition">
                                <i class="fa-solid fa-xmark text-lg"></i>
                            </button>
                        </div>

                        <!-- User Profile / Login Card -->
                        <div class="my-4 p-3.5 rounded-2xl bg-white/5 border border-white/10">
                            @auth
                                <div class="flex items-center space-x-3 mb-3">
                                    <div class="w-10 h-10 rounded-full bg-amber-400 text-slate-950 font-black flex items-center justify-center text-sm shadow">
                                        {{ mb_substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div class="flex-grow min-w-0">
                                        <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</p>
                                        <p class="text-[10px] text-amber-300 font-mono">{{ Auth::user()->number }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-[11px]">
                                    <a href="{{ route('dashboard') }}" class="py-1.5 px-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-center font-bold text-white transition">ড্যাশবোর্ড</a>
                                    <a href="{{ route('complaints.index') }}" class="py-1.5 px-2.5 rounded-xl bg-amber-400/20 hover:bg-amber-400/30 text-amber-300 text-center font-bold transition">অভিযোগসমূহ</a>
                                </div>
                            @else
                                <p class="text-[11px] text-slate-300 mb-2.5 font-medium">নাগরিক সেবায় যুক্ত হতে লগইন করুন</p>
                                <div class="grid grid-cols-2 gap-2">
                                    <a href="{{ route('login') }}" class="py-2 px-3 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold text-xs text-center shadow transition flex items-center justify-center space-x-1">
                                        <i class="fa-solid fa-right-to-bracket"></i>
                                        <span>লগইন</span>
                                    </a>
                                    <a href="{{ route('register') }}" class="py-2 px-3 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs text-center border border-white/20 transition">
                                        রেজিস্ট্রেশন
                                    </a>
                                </div>
                            @endauth
                        </div>

                        <!-- Full Navigation Links List -->
                        <nav class="space-y-1 text-xs font-bold">
                            <a href="{{ route('home') }}" class="flex items-center px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('home') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-slate-200 hover:bg-white/10' }}">
                                <i class="fa-solid fa-house w-6 text-sm {{ request()->routeIs('home') ? 'text-slate-950' : 'text-amber-400' }}"></i>
                                <span>হোম</span>
                            </a>
                            <a href="{{ route('complaints.create') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('complaints.create') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-slate-200 hover:bg-white/10' }}">
                                <span class="flex items-center">
                                    <i class="fa-solid fa-file-pen w-6 text-sm {{ request()->routeIs('complaints.create') ? 'text-slate-950' : 'text-amber-400' }}"></i>
                                    <span>অনলাইন অভিযোগ দাখিল</span>
                                </span>
                                <span class="px-2 py-0.5 rounded-full text-[9px] bg-red-600 text-white font-black animate-pulse">জরুরি</span>
                            </a>
                            <a href="{{ route('track') }}" class="flex items-center px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('track') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-slate-200 hover:bg-white/10' }}">
                                <i class="fa-solid fa-location-crosshairs w-6 text-sm {{ request()->routeIs('track') ? 'text-slate-950' : 'text-emerald-400' }}"></i>
                                <span>অভিযোগ ট্র্যাকিং</span>
                            </a>
                            <a href="{{ route('member.create') }}" class="flex items-center px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('member.create') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-slate-200 hover:bg-white/10' }}">
                                <i class="fa-solid fa-user-plus w-6 text-sm {{ request()->routeIs('member.create') ? 'text-slate-950' : 'text-blue-400' }}"></i>
                                <span>সদস্য আবেদন</span>
                            </a>
                            <a href="{{ route('members.directory') }}" class="flex items-center px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('members.directory') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-slate-200 hover:bg-white/10' }}">
                                <i class="fa-solid fa-users w-6 text-sm {{ request()->routeIs('members.directory') ? 'text-slate-950' : 'text-indigo-300' }}"></i>
                                <span>অনুমোদিত সদস্যবৃন্দ</span>
                            </a>
                            <a href="{{ route('member.verify') }}" class="flex items-center px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('member.verify') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-amber-300 hover:bg-white/10' }}">
                                <i class="fa-solid fa-id-card w-6 text-sm {{ request()->routeIs('member.verify') ? 'text-slate-950' : 'text-amber-400' }}"></i>
                                <span>আইডি কার্ড যাচাই</span>
                            </a>
                            <a href="{{ route('about') }}" class="flex items-center px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('about') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-slate-200 hover:bg-white/10' }}">
                                <i class="fa-solid fa-landmark w-6 text-sm {{ request()->routeIs('about') ? 'text-slate-950' : 'text-slate-300' }}"></i>
                                <span>পরিচিতি ও লক্ষ্য</span>
                            </a>
                            <a href="{{ route('notices') }}" class="flex items-center px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('notices') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-slate-200 hover:bg-white/10' }}">
                                <i class="fa-solid fa-bullhorn w-6 text-sm {{ request()->routeIs('notices') ? 'text-slate-950' : 'text-rose-400' }}"></i>
                                <span>জরুরি নোটিশ</span>
                            </a>
                            <a href="{{ route('contact') }}" class="flex items-center px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('contact') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-slate-200 hover:bg-white/10' }}">
                                <i class="fa-solid fa-headset w-6 text-sm {{ request()->routeIs('contact') ? 'text-slate-950' : 'text-teal-300' }}"></i>
                                <span>যোগাযোগ ও হেল্পলাইন</span>
                            </a>
                        </nav>
                    </div>

                    <!-- Drawer Footer Section -->
                    <div class="pt-4 border-t border-white/10 mt-4 space-y-2">
                        <a href="tel:01644416378" class="w-full py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center justify-center space-x-2 shadow transition">
                            <i class="fa-solid fa-phone-volume"></i>
                            <span>২৪/৭ হটলাইন: 01758343597</span>
                        </a>
                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full py-2 px-3 rounded-xl bg-rose-500/20 hover:bg-rose-500/30 text-rose-300 font-semibold text-xs flex items-center justify-center space-x-2 transition">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <span>লগআউট করুন</span>
                                </button>
                            </form>
                        @endauth
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- Global Flash Alerts (Rendered only when active) -->
    @if(session('success') || session('error') || $errors->any())
        <div class="max-w-7xl mx-auto px-4 mt-4 w-full">
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm mb-4 flex items-center justify-between text-emerald-900">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                        <p class="text-sm font-medium">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl shadow-sm mb-4 flex items-center justify-between text-rose-900">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg"></i>
                        <p class="text-sm font-medium">{{ session('error') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-800"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl shadow-sm mb-4 text-rose-900">
                    <div class="flex items-center space-x-2 font-bold text-sm mb-1">
                        <i class="fa-solid fa-circle-xmark text-rose-600"></i>
                        <span>দয়া করে নিচের ত্রুটিগুলো সংশোধন করুন:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 text-rose-700 ml-4">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endif

    <!-- Main Dynamic Content Container -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-brand-950 text-slate-400 text-sm mt-12 border-t border-brand-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Col 1: About -->
                <div class="space-y-3 md:col-span-1">
                    <div class="flex items-center space-x-3">
                        <img src="{{ $siteLogo }}" alt="Logo" class="h-12 w-12 object-contain drop-shadow">
                        <div>
                            <h3 class="text-white font-bold text-xs sm:text-sm uppercase tracking-wide">{{ $siteSettings['org_name_en'] ?? 'International Legal Aid & Human Rights Foundation' }}</h3>
                            <p class="text-xs text-amber-300 font-semibold mt-0.5">{{ $siteSettings['org_name_bn'] ?? 'আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন' }}</p>
                        </div>
                    </div>
                    <p class="text-xs leading-relaxed text-slate-400">
                        {{ $siteSettings['site_slogan'] ?? 'আন্তর্জাতিক মানবাধিকার আইন সহায়তা প্রদানকারী সংস্থা। নিপীড়িত ও নির্যাতিত মানুষের আইনি অধিকার রক্ষায় সার্বক্ষণিক নিয়োজিত।' }}
                    </p>
                    <div class="flex space-x-3 pt-2 text-white/80">
                        @if(!empty($siteSettings['site_facebook']))
                            <a href="{{ $siteSettings['site_facebook'] }}" target="_blank" class="w-8 h-8 rounded-full bg-brand-800 hover:bg-amber-500 hover:text-brand-950 flex items-center justify-center transition"><i class="fa-brands fa-facebook-f text-xs"></i></a>
                        @endif
                        @if(!empty($siteSettings['site_youtube']))
                            <a href="{{ $siteSettings['site_youtube'] }}" target="_blank" class="w-8 h-8 rounded-full bg-brand-800 hover:bg-amber-500 hover:text-brand-950 flex items-center justify-center transition"><i class="fa-brands fa-youtube text-xs"></i></a>
                        @endif
                        <a href="mailto:{{ $siteSettings['site_email'] ?? 'manushmanusherjonna@gmail.com' }}" class="w-8 h-8 rounded-full bg-brand-800 hover:bg-amber-500 hover:text-brand-950 flex items-center justify-center transition"><i class="fa-solid fa-envelope text-xs"></i></a>
                    </div>
                </div>

                <!-- Col 2: Services -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-3 border-l-2 border-amber-400 pl-2">সেবাসমূহ</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('complaints.create') }}" class="hover:text-amber-300 transition flex items-center"><i class="fa-solid fa-angle-right mr-1.5 text-slate-600"></i>অনলাইন অভিযোগ দাখিল</a></li>
                        <li><a href="{{ route('track') }}" class="hover:text-amber-300 transition flex items-center"><i class="fa-solid fa-angle-right mr-1.5 text-slate-600"></i>অভিযোগের লাইভ ট্র্যাকিং</a></li>
                        <li><a href="{{ route('member.create') }}" class="hover:text-amber-300 transition flex items-center"><i class="fa-solid fa-angle-right mr-1.5 text-slate-600"></i>সদস্য হওয়ার আবেদন</a></li>
                        <li><a href="{{ route('members.directory') }}" class="hover:text-amber-300 transition flex items-center"><i class="fa-solid fa-angle-right mr-1.5 text-slate-600"></i>অনুমোদিত সদস্য তালিকা</a></li>
                    </ul>
                </div>

                <!-- Col 3: Quick Links -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-3 border-l-2 border-amber-400 pl-2">গুরুত্বপূর্ণ লিংক</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('about') }}" class="hover:text-amber-300 transition flex items-center"><i class="fa-solid fa-angle-right mr-1.5 text-slate-600"></i>সংস্থার লক্ষ্য ও আদর্শ</a></li>
                        <li><a href="{{ route('notices') }}" class="hover:text-amber-300 transition flex items-center"><i class="fa-solid fa-angle-right mr-1.5 text-slate-600"></i>জরুরি নোটিশ ও সংবাদ</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-amber-300 transition flex items-center"><i class="fa-solid fa-angle-right mr-1.5 text-slate-600"></i>যোগাযোগ ও কেন্দ্রীয় কার্যালয়</a></li>
                        <li><a href="{{ route('admin.login') }}" class="text-slate-500 hover:text-amber-400 transition flex items-center"><i class="fa-solid fa-lock mr-1.5 text-slate-700"></i>অ্যাডমিন লগইন</a></li>
                    </ul>
                </div>

                <!-- Col 4: Central Office & Contact -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-3 border-l-2 border-amber-400 pl-2">যোগাযোগ</h4>
                    <div class="space-y-2 text-xs text-slate-400">
                        <p class="flex items-start">
                            <i class="fa-solid fa-location-dot mt-1 mr-2 text-amber-400"></i>
                            <span>{{ $siteSettings['site_address'] ?? 'Head Office-37/2, Fayenez Bhabon, lift-08purana Paltan,culbut Road,dhaka, বাংলাদেশ।' }}</span>
                        </p>
                        <p class="flex items-center">
                            <i class="fa-solid fa-phone mr-2 text-emerald-400"></i>
                            <span>{{ $siteSettings['site_phone'] ?? '01758343597' }}</span>
                        </p>
                        <p class="flex items-center">
                            <i class="fa-solid fa-envelope mr-2 text-blue-400"></i>
                            <span>{{ $siteSettings['site_email'] ?? 'manushmanusherjonna@gmail.com' }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="border-t border-brand-800/60 mt-8 pt-6 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500">
                <p>© {{ date('Y') }} {{ $siteSettings['org_name_en'] ?? 'International Legal Aid & Human Rights Foundation' }}. সর্বস্বত্ব সংরক্ষিত।</p>

                <p class="mt-2 sm:mt-0 flex items-center space-x-1.5 text-xs text-slate-400">
                    <span>Developed by</span>
                    <span class="text-amber-400 font-semibold">Ln Md Saiful Chowdhury</span>
                    <span>(<a href="tel:+8801852186180" class="hover:text-amber-300 transition text-slate-300 font-mono">+880 1852-186180</a>)</span>
                </p>
            </div>
        </div>
    </footer>

    <!-- Native App-Like Mobile Bottom Navigation Bar -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-t border-slate-200 shadow-lg px-2 py-1.5 flex justify-around items-center">
        <a href="{{ route('home') }}" class="flex flex-col items-center py-1 px-2 text-xs {{ request()->routeIs('home') ? 'text-brand-900 font-bold' : 'text-slate-500' }}">
            <i class="fa-solid fa-house text-base mb-0.5"></i>
            <span class="text-[10px]">হোম</span>
        </a>
        <a href="{{ route('complaints.create') }}" class="flex flex-col items-center py-1 px-2 text-xs {{ request()->routeIs('complaints.create') ? 'text-brand-900 font-bold' : 'text-slate-500' }}">
            <i class="fa-solid fa-file-pen text-base mb-0.5 text-amber-500"></i>
            <span class="text-[10px]">অভিযোগ</span>
        </a>
        <a href="{{ route('track') }}" class="flex flex-col items-center py-1 px-2 text-xs {{ request()->routeIs('track') ? 'text-brand-900 font-bold' : 'text-slate-500' }}">
            <i class="fa-solid fa-location-crosshairs text-base mb-0.5 text-emerald-600"></i>
            <span class="text-[10px]">ট্র্যাকিং</span>
        </a>
        <a href="{{ route('member.create') }}" class="flex flex-col items-center py-1 px-2 text-xs {{ request()->routeIs('member.create') ? 'text-brand-900 font-bold' : 'text-slate-500' }}">
            <i class="fa-solid fa-user-plus text-base mb-0.5 text-blue-600"></i>
            <span class="text-[10px]">সদস্য</span>
        </a>
        @auth
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center py-1 px-2 text-xs {{ request()->routeIs('dashboard') ? 'text-brand-900 font-bold' : 'text-slate-500' }}">
                <i class="fa-solid fa-user text-base mb-0.5"></i>
                <span class="text-[10px]">প্রোফাইল</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="flex flex-col items-center py-1 px-2 text-xs {{ request()->routeIs('login') ? 'text-brand-900 font-bold' : 'text-slate-500' }}">
                <i class="fa-solid fa-right-to-bracket text-base mb-0.5"></i>
                <span class="text-[10px]">লগইন</span>
            </a>
        @endauth
    </div>

    <!-- PWA Install Prompt Logic & Service Worker Registration -->
    <script>
        // Register Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('PWA Service Worker registered:', reg.scope))
                    .catch(err => console.log('SW registration failed:', err));
            });
        }

        // PWA Install Event Listener
        let deferredPrompt;
        const installBtn = document.getElementById('pwaInstallBtn');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            if (installBtn) {
                installBtn.classList.remove('hidden');
                installBtn.classList.add('inline-flex');
            }
        });

        if (installBtn) {
            installBtn.addEventListener('click', async () => {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    const { outcome } = await deferredPrompt.userChoice;
                    if (outcome === 'accepted') {
                        installBtn.classList.add('hidden');
                    }
                    deferredPrompt = null;
                }
            });
        }
    </script>


    @yield('scripts')
</body>
</html>
