@extends('layouts.app')

@section('title', $notice->title . ' - আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন')

@section('content')
<div class="bg-gradient-to-b from-slate-100/70 to-white min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">

        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-6 font-medium">
            <a href="{{ route('home') }}" class="hover:text-blue-700">হোম</a>
            <span><i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i></span>
            <a href="{{ route('notices') }}" class="hover:text-blue-700">নোটিশ ও বিজ্ঞপ্তি</a>
            <span><i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i></span>
            <span class="text-slate-800 font-bold truncate max-w-xs">{{ $notice->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Main Notice Content (8 cols) -->
            <div class="lg:col-span-8 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/90 shadow-sm space-y-6">
                
                <!-- Notice Meta -->
                <div class="flex flex-wrap items-center gap-3 text-xs border-b pb-4 border-slate-100">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $notice->category_badge['bg'] }}">
                        <i class="{{ $notice->category_badge['icon'] }} mr-1.5"></i>
                        {{ $notice->category }}
                    </span>
                    <span class="text-slate-500 font-medium flex items-center">
                        <i class="fa-regular fa-calendar mr-1.5 text-slate-400"></i>{{ $notice->formatted_date }}
                    </span>
                    <span class="text-slate-300">•</span>
                    <span class="text-slate-500 flex items-center">
                        <i class="fa-regular fa-eye mr-1.5 text-slate-400"></i>{{ $notice->views_count }} বার পঠিত
                    </span>
                    @if($notice->created_by)
                        <span class="text-slate-300">•</span>
                        <span class="text-slate-500">
                            প্রকাশনায়: <strong class="text-slate-700">{{ $notice->created_by }}</strong>
                        </span>
                    @endif
                </div>

                <!-- Title -->
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 leading-snug">
                    {{ $notice->title }}
                </h1>

                <!-- Attached PDF Box (Top Highlight) -->
                @if($notice->has_file)
                    <div class="p-5 rounded-2xl bg-gradient-to-r from-rose-50 to-amber-50/50 border border-rose-200/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-sm">
                        <div class="flex items-center space-x-3.5">
                            <div class="w-12 h-12 rounded-2xl bg-rose-600 text-white flex items-center justify-center text-2xl shadow-md flex-shrink-0">
                                <i class="fa-solid fa-file-pdf"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">অফিশিয়াল স্বাক্ষরিত নোটিশ (সংযুক্ত ফাইল)</h4>
                                <p class="text-xs text-slate-500 mt-0.5 font-mono">
                                    {{ $notice->file_name ?: basename($notice->file_path) }}
                                    @if($notice->file_size)
                                        <span class="ml-1 text-rose-600 font-bold">• {{ $notice->file_size }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2 w-full sm:w-auto">
                            <a href="{{ $notice->file_url }}" target="_blank" download class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-xs shadow transition flex items-center justify-center space-x-2">
                                <i class="fa-solid fa-download"></i>
                                <span>PDF ডাউনলোড</span>
                            </a>
                            <a href="{{ $notice->file_url }}" target="_blank" class="px-3.5 py-2.5 rounded-xl bg-white hover:bg-slate-50 text-slate-800 font-bold text-xs border border-slate-300 transition flex items-center justify-center" title="নতুন ট্যাবে ফাইল খুলুন">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Description / Body -->
                @if($notice->description)
                    <div class="text-xs sm:text-sm text-slate-700 leading-relaxed space-y-4 pt-2 whitespace-pre-line border-t border-slate-100">
                        {!! nl2br(e($notice->description)) !!}
                    </div>
                @endif

                <!-- Embedded PDF Viewer (If PDF) -->
                @if($notice->is_pdf)
                    <div class="pt-6 border-t border-slate-100 space-y-2">
                        <span class="text-xs font-bold text-slate-700 block flex items-center">
                            <i class="fa-solid fa-book-open-reader mr-1.5 text-rose-600"></i>ডকুমেন্ট প্রিভিউয়ার:
                        </span>
                        <div class="w-full h-[520px] rounded-2xl overflow-hidden border border-slate-300 bg-slate-100 shadow-inner">
                            <iframe src="{{ $notice->file_url }}#toolbar=1" class="w-full h-full" frameborder="0"></iframe>
                        </div>
                    </div>
                @endif

                <!-- Share & Actions Footer -->
                <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 text-xs">
                    <div class="flex items-center space-x-2">
                        <span class="text-slate-500 font-semibold">শেয়ার করুন:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition">
                            <i class="fa-brands fa-facebook-f text-xs"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($notice->title . ' ' . url()->current()) }}" target="_blank" class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center hover:bg-emerald-700 transition">
                            <i class="fa-brands fa-whatsapp text-xs"></i>
                        </a>
                        <button type="button" onclick="navigator.clipboard.writeText(window.location.href); alert('লিংক কপি করা হয়েছে!');" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold transition flex items-center space-x-1">
                            <i class="fa-solid fa-link text-xs"></i>
                            <span>লিংক কপি</span>
                        </button>
                    </div>

                    <button type="button" onclick="window.print()" class="px-4 py-1.5 rounded-lg bg-slate-900 text-amber-400 font-bold hover:bg-slate-800 transition flex items-center space-x-1.5">
                        <i class="fa-solid fa-print"></i>
                        <span>প্রিন্ট করুন</span>
                    </button>
                </div>

            </div>

            <!-- Sidebar (4 cols) -->
            <div class="lg:col-span-4 space-y-6">

                <!-- Recent Notices Widget -->
                <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm space-y-4">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center border-b pb-3 border-slate-100">
                        <i class="fa-solid fa-newspaper text-amber-500 mr-2 text-sm"></i>
                        অন্যান্য সাম্প্রতিক নোটিশ
                    </h3>

                    @if($recentNotices->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentNotices as $rn)
                                <a href="{{ route('notices.show', $rn->id) }}" class="block p-3 rounded-xl hover:bg-slate-50 transition border border-transparent hover:border-slate-200 group">
                                    <span class="text-[10px] font-bold text-slate-400 block mb-1">{{ $rn->formatted_date }}</span>
                                    <h4 class="text-xs font-bold text-slate-800 group-hover:text-blue-700 transition line-clamp-2">{{ $rn->title }}</h4>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-slate-400">আর কোনো সাম্প্রতিক নোটিশ নেই।</p>
                    @endif

                    <div class="pt-2 border-t border-slate-100 text-center">
                        <a href="{{ route('notices') }}" class="text-xs font-bold text-blue-700 hover:underline">
                            সকল নোটিশ দেখুন →
                        </a>
                    </div>
                </div>

                <!-- Emergency Helpline Widget -->
                <div class="bg-gradient-to-br from-[#06182c] to-[#0b2949] p-5 rounded-3xl text-white shadow-sm space-y-3">
                    <span class="text-[10px] font-bold text-amber-400 uppercase tracking-wider block">আইনি সহায়তা হেল্পলাইন</span>
                    <h4 class="text-sm font-bold leading-snug">যেকোনো মানবাধিকার লঙ্ঘন বা জরুরি আইনি পরামর্শের জন্য</h4>
                    <a href="tel:{{ $siteSettings['site_phone'] ?? '01758343597' }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-amber-500 text-slate-950 font-extrabold text-xs hover:bg-amber-400 transition shadow">
                        <i class="fa-solid fa-phone mr-1.5"></i>{{ $siteSettings['site_phone'] ?? '01758343597' }}
                    </a>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
