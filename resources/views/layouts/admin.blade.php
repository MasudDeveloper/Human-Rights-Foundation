<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'অ্যাডমিন ড্যাশবোর্ড') - আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন</title>
    
    <link rel="icon" type="image/png" href="{{ $siteFavicon }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script>

        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        admin: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    },
                    fontFamily: {
                        sans: ['"Hind Siliguri"', '"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex-shrink-0 hidden md:flex flex-col border-r border-slate-800">
        <!-- Brand -->
        <div class="h-16 flex items-center px-6 bg-slate-950 border-b border-slate-800 space-x-3">
            <img src="{{ $siteLogo }}" alt="Logo" class="h-9 w-9 bg-white p-0.5 rounded-full object-contain">
            <div>
                <h2 class="text-xs font-bold text-white leading-tight truncate max-w-[150px]">{{ $siteSettings['org_wing'] ?? 'অ্যাডমিন প্যানেল' }}</h2>
                <p class="text-[10px] text-amber-400">Admin Control Panel</p>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-grow p-4 space-y-1.5 text-xs font-medium">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-slate-950 font-bold' : 'hover:bg-slate-800 text-slate-300' }}">
                <i class="fa-solid fa-gauge-high text-sm w-5"></i>
                <span>ড্যাশবোর্ড</span>
            </a>
            
            <a href="{{ route('admin.complaints') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.complaints*') ? 'bg-amber-500 text-slate-950 font-bold' : 'hover:bg-slate-800 text-slate-300' }}">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-file-shield text-sm w-5"></i>
                    <span>অভিযোগসমূহ</span>
                </div>
                @php
                    $pendingComplaintsCount = \App\Models\Complaint::where('status', 'pending')->count();
                @endphp
                @if($pendingComplaintsCount > 0)
                    <span class="bg-rose-500 text-white font-bold text-[10px] px-2 py-0.5 rounded-full">{{ $pendingComplaintsCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.members') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.members*') ? 'bg-amber-500 text-slate-950 font-bold' : 'hover:bg-slate-800 text-slate-300' }}">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-id-card text-sm w-5"></i>
                    <span>সদস্য আবেদন</span>
                </div>
                @php
                    $pendingMembersCount = \App\Models\Member::where('status', 'pending')->count();
                @endphp
                @if($pendingMembersCount > 0)
                    <span class="bg-blue-500 text-white font-bold text-[10px] px-2 py-0.5 rounded-full">{{ $pendingMembersCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.users') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.users*') ? 'bg-amber-500 text-slate-950 font-bold' : 'hover:bg-slate-800 text-slate-300' }}">
                <i class="fa-solid fa-users text-sm w-5"></i>
                <span>নিবন্ধিত ব্যবহারকারী</span>
            </a>

            <a href="{{ route('admin.notices') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.notices*') ? 'bg-amber-500 text-slate-950 font-bold' : 'hover:bg-slate-800 text-slate-300' }}">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-bullhorn text-sm w-5"></i>
                    <span>নোটিশ ও বিজ্ঞপ্তি</span>
                </div>
                @php
                    $activeNoticesCount = \App\Models\Notice::active()->count();
                @endphp
                @if($activeNoticesCount > 0)
                    <span class="bg-amber-400 text-slate-950 font-bold text-[10px] px-2 py-0.5 rounded-full">{{ $activeNoticesCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.gallery') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.gallery*') ? 'bg-amber-500 text-slate-950 font-bold' : 'hover:bg-slate-800 text-slate-300' }}">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-camera-retro text-sm w-5"></i>
                    <span>ফটো গ্যালারি</span>
                </div>
                @php
                    $activeGalleryCount = \App\Models\Gallery::active()->count();
                @endphp
                @if($activeGalleryCount > 0)
                    <span class="bg-amber-400 text-slate-950 font-bold text-[10px] px-2 py-0.5 rounded-full">{{ $activeGalleryCount }}</span>
                @endif
            </a>

            @if(session('admin_role') === 'super_admin')
                <div class="pt-2">
                    <span class="text-[10px] font-bold text-amber-400/80 uppercase tracking-wider px-3">সুপার অ্যাডমিন মেনু</span>
                </div>
                <a href="{{ route('admin.settings') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.settings*') ? 'bg-amber-500 text-slate-950 font-bold' : 'hover:bg-slate-800 text-slate-300' }}">
                    <i class="fa-solid fa-sliders text-sm w-5 text-amber-400"></i>
                    <span>লোগো, ওয়েবসাইট ও কার্ড সেটিংস</span>
                </a>
            @endif


            <div class="pt-4 mt-4 border-t border-slate-800">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center space-x-3 px-3 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 transition">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs w-5"></i>
                    <span>মূল ওয়েবসাইট দেখুন</span>
                </a>
            </div>
        </nav>

        <!-- Admin Profile footer -->
        <div class="p-4 bg-slate-950 border-t border-slate-800 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 rounded-full bg-amber-500 text-slate-950 font-bold flex items-center justify-center text-xs">
                    {{ strtoupper(substr(session('admin_username', 'A'), 0, 1)) }}
                </div>
                <div>
                    <p class="text-xs font-bold text-white">{{ session('admin_username') }}</p>
                    <span class="text-[10px] {{ session('admin_role') === 'super_admin' ? 'text-amber-400 font-bold' : 'text-emerald-400' }} flex items-center">
                        <span class="w-1.5 h-1.5 rounded-full {{ session('admin_role') === 'super_admin' ? 'bg-amber-400' : 'bg-emerald-400' }} mr-1"></span>
                        {{ session('admin_role') === 'super_admin' ? 'সুপার অ্যাডমিন' : 'সাধারণ অ্যাডমিন' }}
                    </span>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" title="লগআউট" class="text-slate-400 hover:text-rose-400 p-1.5 transition">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-w-0">
        <!-- Top header -->
        <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between sticky top-0 z-30 shadow-sm">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.dashboard') }}" class="md:hidden">
                    <img src="{{ asset('images/cit_logo.png') }}" class="h-8 w-8">
                </a>
                <h1 class="text-base font-bold text-slate-800">@yield('page_title', 'ড্যাশবোর্ড')</h1>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" target="_blank" class="text-xs text-brand-700 font-semibold hover:underline flex items-center">
                    <i class="fa-solid fa-globe mr-1"></i>ওয়েবসাইট
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-rose-600 hover:text-rose-800 font-medium">
                        <i class="fa-solid fa-power-off mr-1"></i>লগআউট
                    </button>
                </form>
            </div>
        </header>

        <!-- Alerts -->
        <div class="p-6 pb-0">
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-3 rounded-r-xl text-emerald-900 text-xs mb-4 flex items-center justify-between">
                    <span><i class="fa-solid fa-circle-check mr-2 text-emerald-600"></i>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-700">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-rose-50 border-l-4 border-rose-500 p-3 rounded-r-xl text-rose-900 text-xs mb-4 flex items-center justify-between">
                    <span><i class="fa-solid fa-triangle-exclamation mr-2 text-rose-600"></i>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-rose-700">&times;</button>
                </div>
            @endif
        </div>

        <!-- Body -->
        <main class="p-6 flex-grow">
            @yield('content')
        </main>
    </div>

</body>
</html>
