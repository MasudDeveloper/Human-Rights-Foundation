@extends('layouts.app')

@section('title', 'ভিডিও গ্যালারি')

@section('content')
<div class="bg-slate-50 min-h-screen py-8 sm:py-12" x-data="{ activeVideoModal: false, activeVideoUrl: '', activeVideoTitle: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Simple Clean Header -->
        <div class="text-center max-w-xl mx-auto mb-6">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                ভিডিও গ্যালারি
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1.5">
                সংস্থার কেন্দ্রীয় ও মাঠপর্যায়ের বিভিন্ন কার্যক্রম, সংবাদ সম্মেলন ও ভিডিও প্রতিবেদন
            </p>
        </div>

        <!-- Navigation Tabs: Photo & Video -->
        <div class="flex justify-center mb-8">
            <div class="inline-flex p-1.5 bg-slate-200/80 rounded-2xl shadow-inner border border-slate-300/60">
                <a href="{{ route('gallery') }}" class="px-5 py-2 rounded-xl text-xs sm:text-sm font-bold transition flex items-center space-x-2 text-slate-600 hover:text-slate-900">
                    <i class="fa-solid fa-camera-retro text-amber-500"></i>
                    <span>ফটো গ্যালারি</span>
                </a>
                <a href="{{ route('videos') }}" class="px-5 py-2 rounded-xl text-xs sm:text-sm font-bold transition flex items-center space-x-2 bg-white text-slate-900 shadow-sm">
                    <i class="fa-solid fa-circle-play text-rose-500"></i>
                    <span>ভিডিও গ্যালারি</span>
                </a>
            </div>
        </div>

        <!-- Category Filters -->
        @if(isset($categories) && $categories->count() > 0)
            <div class="flex flex-wrap items-center justify-center gap-2 mb-8">
                <a href="{{ route('videos') }}" 
                   class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $currentCategory === 'all' ? 'bg-slate-900 text-amber-400 shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                    সকল ভিডিও
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('videos', ['category' => $cat]) }}" 
                       class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $currentCategory === $cat ? 'bg-slate-900 text-amber-400 shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Video Grid -->
        @if($videos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
                @foreach($videos as $video)
                    <div class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col group">
                        
                        <!-- Thumbnail & Play Button -->
                        <div class="relative aspect-[16/9] bg-slate-900 overflow-hidden cursor-pointer"
                             @click="activeVideoModal = true; activeVideoUrl = '{{ $video->embed_url }}?autoplay=1'; activeVideoTitle = '{{ addslashes($video->title) }}'">
                            <img src="{{ $video->thumbnail_url }}" 
                                 alt="{{ $video->title }}" 
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            
                            <!-- Dark Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-black/30 group-hover:from-slate-950/90 transition-all"></div>
                            
                            <!-- YouTube Red Play Button Badge -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-full bg-red-600/90 text-white flex items-center justify-center shadow-xl group-hover:scale-115 group-hover:bg-red-600 transition-all">
                                    <i class="fa-solid fa-play text-lg sm:text-xl ml-1"></i>
                                </div>
                            </div>

                            @if($video->category)
                                <span class="absolute top-3 left-3 bg-slate-950/80 text-amber-400 text-[10px] font-bold px-2.5 py-1 rounded-md backdrop-blur-xs">
                                    {{ $video->category }}
                                </span>
                            @endif
                        </div>

                        <!-- Video Title & Details -->
                        <div class="p-4 sm:p-5 flex-grow flex flex-col justify-between space-y-3">
                            <div>
                                <h3 class="text-sm font-bold text-slate-900 group-hover:text-rose-600 transition line-clamp-2 leading-snug cursor-pointer"
                                    @click="activeVideoModal = true; activeVideoUrl = '{{ $video->embed_url }}?autoplay=1'; activeVideoTitle = '{{ addslashes($video->title) }}'">
                                    {{ $video->title }}
                                </h3>

                                @if($video->description)
                                    <p class="text-xs text-slate-500 mt-1.5 line-clamp-2 leading-relaxed">
                                        {{ $video->description }}
                                    </p>
                                @endif
                            </div>

                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                                <button type="button" 
                                        @click="activeVideoModal = true; activeVideoUrl = '{{ $video->embed_url }}?autoplay=1'; activeVideoTitle = '{{ addslashes($video->title) }}'"
                                        class="font-bold text-rose-600 hover:text-rose-700 flex items-center space-x-1">
                                    <i class="fa-solid fa-circle-play"></i>
                                    <span>এখানে দেখুন</span>
                                </button>

                                <a href="{{ $video->watch_url }}" target="_blank" class="text-slate-400 hover:text-red-600 transition flex items-center space-x-1 text-[11px]" title="ইউটিউবে সরাসরি দেখুন">
                                    <i class="fa-brands fa-youtube text-red-500"></i>
                                    <span>YouTube</span>
                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($videos->hasPages())
                <div class="mt-10">
                    {{ $videos->links() }}
                </div>
            @endif

        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center max-w-md mx-auto shadow-sm">
                <div class="w-16 h-16 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center text-2xl mx-auto mb-3">
                    <i class="fa-solid fa-video"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">কোনো ভিডিও পাওয়া যায়নি</h3>
                <p class="text-xs text-slate-500 mt-1">শীঘ্রই নতুন ভিডিও প্রকাশ করা হবে। আমাদের সাথে থাকুন।</p>
                @if($currentCategory !== 'all')
                    <a href="{{ route('videos') }}" class="inline-block mt-4 text-xs font-bold text-brand-700 hover:underline">
                        সকল ভিডিও দেখুন &rarr;
                    </a>
                @endif
            </div>
        @endif

    </div>

    <!-- Video Player Modal -->
    <div x-cloak x-show="activeVideoModal" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/85 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @keydown.escape.window="activeVideoModal = false; activeVideoUrl = ''">
        
        <div class="relative w-full max-w-4xl bg-slate-900 rounded-2xl overflow-hidden shadow-2xl border border-slate-800"
             @click.away="activeVideoModal = false; activeVideoUrl = ''">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-5 py-3.5 bg-slate-950 border-b border-slate-800">
                <h4 class="text-xs sm:text-sm font-bold text-white truncate max-w-xl" x-text="activeVideoTitle"></h4>
                <button type="button" @click="activeVideoModal = false; activeVideoUrl = ''" class="text-slate-400 hover:text-white p-1 text-lg rounded-lg hover:bg-slate-800 transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Responsive 16:9 Video Frame -->
            <div class="relative aspect-[16/9] bg-black">
                <template x-if="activeVideoModal">
                    <iframe :src="activeVideoUrl" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </template>
            </div>
        </div>
    </div>
</div>
@endsection
