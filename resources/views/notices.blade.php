@extends('layouts.app')

@section('title', 'জরুরি নোটিশ ও সংবাদ বুলেটিন - আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন')

@section('content')
<div class="bg-gradient-to-b from-slate-100/80 to-white min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">

        <!-- Page Header -->
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-amber-500/10 text-amber-700 border border-amber-300 mb-3">
                <i class="fa-solid fa-bullhorn mr-1.5 animate-pulse"></i>জনস্বার্থে অফিশিয়াল বিজ্ঞপ্তি
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">জরুরি নোটিশ ও সংবাদ বুলেটিন</h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-2">সংস্থার সাম্প্রতিক কার্যক্রম, প্রেস বিজ্ঞপ্তি, আইনি সহায়তা ও অফিশিয়াল নির্দেশনাবলী</p>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-sm mb-8 flex flex-col md:flex-row gap-4 justify-between items-center">
            
            <!-- Category Pills -->
            <div class="flex flex-wrap gap-2 text-xs font-semibold">
                <a href="{{ route('notices') }}" class="px-3.5 py-1.5 rounded-xl transition {{ !request('category') ? 'bg-slate-900 text-amber-400 font-bold shadow' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    সকল
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('notices', ['category' => $cat]) }}" class="px-3.5 py-1.5 rounded-xl transition {{ request('category') == $cat ? 'bg-blue-700 text-white font-bold shadow' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

            <!-- Search Form -->
            <form method="GET" action="{{ route('notices') }}" class="w-full md:w-72 flex gap-2">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <input type="text" name="search" value="{{ request('search') }}" placeholder="নোটিশের শিরোনাম খুঁজুন..."
                    class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900">
                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 text-amber-400 font-bold text-xs hover:bg-slate-800 transition">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        <!-- Notices Cards List -->
        @if($notices->count() > 0)
            <div class="space-y-4">
                @foreach($notices as $n)
                    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md transition group flex flex-col md:flex-row md:items-center justify-between gap-5">
                        
                        <div class="space-y-2 flex-grow">
                            <!-- Category & Date Header -->
                            <div class="flex items-center space-x-3 text-xs">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $n->category_badge['bg'] }}">
                                    <i class="{{ $n->category_badge['icon'] }} mr-1"></i>
                                    {{ $n->category }}
                                </span>
                                <span class="text-slate-300">•</span>
                                <span class="text-slate-500 font-medium flex items-center text-[11px]">
                                    <i class="fa-regular fa-calendar mr-1.5 text-slate-400"></i>{{ $n->formatted_date }}
                                </span>
                                @if($n->is_ticker)
                                    <span class="text-slate-300">•</span>
                                    <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">
                                        <i class="fa-solid fa-bullhorn mr-1"></i>জরুরি বার্তা
                                    </span>
                                @endif
                            </div>

                            <!-- Title -->
                            <h2 class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-blue-800 transition">
                                <a href="{{ route('notices.show', $n->id) }}">
                                    {{ $n->title }}
                                </a>
                            </h2>

                            <!-- Excerpt -->
                            @if($n->description)
                                <p class="text-xs text-slate-600 leading-relaxed line-clamp-2">
                                    {{ Str::limit(strip_tags($n->description), 180) }}
                                </p>
                            @endif
                        </div>

                        <!-- Actions / PDF Button -->
                        <div class="flex flex-wrap items-center gap-2 flex-shrink-0 pt-2 md:pt-0 border-t md:border-t-0 border-slate-100">
                            @if($n->has_file)
                                <a href="{{ $n->file_url }}" target="_blank" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-sm hover:shadow transition flex items-center space-x-1.5" title="সংযুক্ত পিডিএফ ফাইল ডাউনলোড বা দেখুন">
                                    <i class="fa-solid fa-file-pdf"></i>
                                    <span>PDF ডাউনলোড</span>
                                    @if($n->file_size)
                                        <span class="text-[10px] opacity-80 font-mono">({{ $n->file_size }})</span>
                                    @endif
                                </a>
                            @endif

                            <a href="{{ route('notices.show', $n->id) }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs transition flex items-center space-x-1">
                                <span>বিস্তারিত</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $notices->links() }}
            </div>
        @else
            <div class="bg-white p-12 rounded-2xl border border-slate-200 text-center">
                <i class="fa-solid fa-bullhorn text-4xl mb-3 text-slate-300"></i>
                <h3 class="text-base font-bold text-slate-800">কোনো নোটিশ পাওয়া যায়নি</h3>
                <p class="text-xs text-slate-500 mt-1">এই ক্যাটাগরিতে বর্তমানে কোনো প্রকাশিত নোটিশ নেই।</p>
                <a href="{{ route('notices') }}" class="inline-flex items-center px-4 py-2 mt-4 rounded-xl bg-slate-900 text-amber-400 font-bold text-xs">
                    সব নোটিশ দেখুন
                </a>
            </div>
        @endif

    </div>
</div>
@endsection
