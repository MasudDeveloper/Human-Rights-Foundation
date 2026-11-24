@extends('layouts.admin')

@section('title', 'ভিডিও গ্যালারি ব্যবস্থাপনা - অ্যাডমিন')
@section('page_title', 'ভিডিও গ্যালারি ও ইউটিউব কন্টেন্ট নিয়ন্ত্রণ')

@section('content')
<div class="space-y-6">

    <!-- Header Stats Banner -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-500 font-semibold block">মোট ভিডিও</span>
                <span class="text-2xl font-extrabold text-slate-900 mt-1 block">{{ $totalVideos }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-circle-play"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-500 font-semibold block">প্রকাশিত ও সক্রিয়</span>
                <span class="text-2xl font-extrabold text-emerald-600 mt-1 block">{{ $activeVideos }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-500 font-semibold block">মোট ক্যাটাগরি</span>
                <span class="text-2xl font-extrabold text-amber-600 mt-1 block">{{ $categories->count() }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-layer-group"></i>
            </div>
        </div>
    </div>

    <!-- Actions & Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-3 justify-between items-center">
        <!-- Category Filter Pills -->
        <div class="flex flex-wrap items-center gap-1.5 text-xs font-semibold overflow-x-auto w-full md:w-auto">
            <a href="{{ route('admin.videos') }}" class="px-3 py-1.5 rounded-lg transition {{ !request('category') ? 'bg-slate-900 text-amber-400 font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                সকল ভিডিও
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('admin.videos', ['category' => $cat]) }}" class="px-3 py-1.5 rounded-lg transition {{ request('category') === $cat ? 'bg-amber-500 text-slate-950 font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        <!-- Search Form & Add Button -->
        <div class="flex items-center space-x-3 w-full md:w-auto">
            <form method="GET" action="{{ route('admin.videos') }}" class="relative flex-grow md:w-64">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="ভিডিও খুঁজুন..." 
                       class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
            </form>

            <a href="{{ route('admin.videos.create') }}" class="px-4 py-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold text-xs rounded-xl shadow-md transition flex items-center space-x-1.5 flex-shrink-0">
                <i class="fa-solid fa-plus"></i>
                <span>নতুন ভিডিও যোগ</span>
            </a>
        </div>
    </div>

    <!-- Video List / Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3 px-4 text-center w-12">#</th>
                        <th class="py-3 px-4 w-36">ভিডিও প্রিভিউ</th>
                        <th class="py-3 px-4">শিরোনাম ও বিবরণ</th>
                        <th class="py-3 px-4">ক্যাটাগরি</th>
                        <th class="py-3 px-4 text-center">ক্রম</th>
                        <th class="py-3 px-4 text-center">স্ট্যাটাস</th>
                        <th class="py-3 px-4 text-right">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($videos as $index => $v)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3 px-4 text-center font-mono text-slate-400">
                                {{ $videos->firstItem() + $index }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="relative w-32 aspect-[16/9] rounded-lg overflow-hidden bg-slate-900 border border-slate-200 group shadow-xs">
                                    <img src="{{ $v->thumbnail_url }}" alt="{{ $v->title }}" class="w-full h-full object-cover">
                                    <a href="{{ $v->watch_url }}" target="_blank" class="absolute inset-0 bg-slate-950/40 hover:bg-slate-950/60 transition flex items-center justify-center text-white">
                                        <i class="fa-brands fa-youtube text-2xl text-red-600 group-hover:scale-110 transition-transform"></i>
                                    </a>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="space-y-1">
                                    <a href="{{ $v->watch_url }}" target="_blank" class="font-bold text-slate-900 hover:text-rose-600 transition block text-xs line-clamp-2">
                                        {{ $v->title }}
                                    </a>
                                    @if($v->description)
                                        <p class="text-[11px] text-slate-400 line-clamp-1">{{ $v->description }}</p>
                                    @endif
                                    <span class="inline-flex items-center text-[10px] text-slate-400 font-mono">
                                        <i class="fa-brands fa-youtube text-red-500 mr-1"></i>ID: {{ $v->youtube_id ?: 'N/A' }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-block px-2.5 py-1 bg-slate-100 text-slate-700 rounded-md text-[11px] font-semibold">
                                    {{ $v->category ?: 'সাধারণ' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center font-mono text-xs font-semibold text-slate-600">
                                {{ $v->sort_order }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <form method="POST" action="{{ route('admin.videos.toggle_status', $v->id) }}" class="inline-block">
                                    @csrf
                                    <button type="submit" title="স্ট্যাটাস পরিবর্তন করতে ক্লিক করুন" class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-full text-[10px] font-bold transition {{ $v->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $v->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                        <span>{{ $v->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</span>
                                    </button>
                                </form>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="inline-flex items-center space-x-2">
                                    <a href="{{ $v->watch_url }}" target="_blank" class="p-1.5 text-slate-500 hover:text-red-600 transition" title="ইউটিউবে দেখুন">
                                        <i class="fa-solid fa-up-right-from-square"></i>
                                    </a>
                                    <a href="{{ route('admin.videos.edit', $v->id) }}" class="p-1.5 text-slate-500 hover:text-amber-600 transition" title="সম্পাদনা">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.videos.delete', $v->id) }}" class="inline-block" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই ভিডিওটি মুছে ফেলতে চান?')">
                                        @csrf
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 transition" title="মুছে ফেলুন">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-video text-3xl mb-2 block text-slate-300"></i>
                                <p class="text-xs">কোনো ভিডিও পাওয়া যায়নি।</p>
                                <a href="{{ route('admin.videos.create') }}" class="inline-block mt-3 px-4 py-1.5 bg-amber-500 text-slate-950 font-bold text-xs rounded-xl shadow hover:bg-amber-400 transition">
                                    প্রথম ভিডিও যোগ করুন
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($videos->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $videos->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
