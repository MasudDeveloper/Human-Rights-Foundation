@extends('layouts.admin')

@section('title', 'নোটিশ ও বিজ্ঞপ্তি ব্যবস্থাপনা - অ্যাডমিন')
@section('page_title', 'সংস্থার নোটিশ ও বিজ্ঞপ্তি ব্যবস্থাপনা')

@section('content')
<div class="space-y-6">

    <!-- Header Stats Banner -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-500 font-semibold block">মোট নোটিশ</span>
                <span class="text-2xl font-extrabold text-slate-900 mt-1 block">{{ $totalNotices }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-bullhorn"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-500 font-semibold block">প্রকাশিত ও সক্রিয়</span>
                <span class="text-2xl font-extrabold text-emerald-600 mt-1 block">{{ $activeNotices }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-500 font-semibold block">পিডিএফ সংযুক্ত নোটিশ</span>
                <span class="text-2xl font-extrabold text-rose-600 mt-1 block">{{ $pdfNotices }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-file-pdf"></i>
            </div>
        </div>
    </div>

    <!-- Actions & Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-3 justify-between items-center">
        <!-- Status & Category Filter -->
        <div class="flex flex-wrap items-center gap-1.5 text-xs font-semibold">
            <a href="{{ route('admin.notices') }}" class="px-3 py-1.5 rounded-lg {{ !request('category') && !request('status') ? 'bg-slate-900 text-amber-400' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                সকল নোটিশ
            </a>
            <a href="{{ route('admin.notices', ['category' => 'জরুরি বিজ্ঞপ্তি']) }}" class="px-3 py-1.5 rounded-lg {{ request('category') == 'জরুরি বিজ্ঞপ্তি' ? 'bg-rose-600 text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                জরুরি বিজ্ঞপ্তি
            </a>
            <a href="{{ route('admin.notices', ['category' => 'সাধারণ নোটিশ']) }}" class="px-3 py-1.5 rounded-lg {{ request('category') == 'সাধারণ নোটিশ' ? 'bg-blue-600 text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                সাধারণ নোটিশ
            </a>
            <a href="{{ route('admin.notices', ['category' => 'প্রেস বিজ্ঞপ্তি']) }}" class="px-3 py-1.5 rounded-lg {{ request('category') == 'প্রেস বিজ্ঞপ্তি' ? 'bg-emerald-600 text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                প্রেস বিজ্ঞপ্তি
            </a>
            <a href="{{ route('admin.notices', ['category' => 'আইনি নির্দেশনা']) }}" class="px-3 py-1.5 rounded-lg {{ request('category') == 'আইনি নির্দেশনা' ? 'bg-purple-600 text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                আইনি নির্দেশনা
            </a>
        </div>

        <div class="flex items-center gap-2 w-full md:w-auto">
            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.notices') }}" class="flex gap-2 flex-grow md:w-64">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <input type="text" name="search" value="{{ request('search') }}" placeholder="শিরোনাম বা বিষয়বস্তু খুঁজুন..."
                    class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900">
                <button type="submit" class="px-3 py-2 rounded-xl bg-slate-900 text-amber-400 font-bold text-xs flex-shrink-0">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

            <!-- Create Button -->
            <a href="{{ route('admin.notices.create') }}" class="px-4 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold text-xs shadow transition flex items-center space-x-1.5 flex-shrink-0">
                <i class="fa-solid fa-plus"></i>
                <span>নতুন নোটিশ প্রকাশ</span>
            </a>
        </div>
    </div>

    <!-- Notices Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @if($notices->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 border-b border-slate-100 font-bold">
                        <tr>
                            <th class="p-3.5 pl-5">আইডি</th>
                            <th class="p-3.5">শিরোনাম ও ক্যাটাগরি</th>
                            <th class="p-3.5">প্রকাশের তারিখ</th>
                            <th class="p-3.5">সংযুক্ত ফাইল (PDF)</th>
                            <th class="p-3.5">টিকারে প্রদর্শন</th>
                            <th class="p-3.5">স্ট্যাটাস</th>
                            <th class="p-3.5 text-right pr-5">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($notices as $n)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="p-3.5 pl-5 font-mono font-bold text-slate-500">#{{ $n->id }}</td>
                                <td class="p-3.5 max-w-md">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold border {{ $n->category_badge['bg'] }}">
                                            <i class="{{ $n->category_badge['icon'] }} mr-1"></i>
                                            {{ $n->category }}
                                        </span>
                                    </div>
                                    <strong class="text-slate-900 block text-xs line-clamp-2">{{ $n->title }}</strong>
                                    <span class="text-[11px] text-slate-400 block line-clamp-1 mt-0.5">{{ Str::limit(strip_tags($n->description), 80) }}</span>
                                </td>
                                <td class="p-3.5 font-medium whitespace-nowrap">
                                    <span class="text-slate-900 block font-bold">{{ $n->formatted_date }}</span>
                                    <span class="text-[10px] text-slate-400 font-mono">{{ $n->published_date->format('Y-m-d') }}</span>
                                </td>
                                <td class="p-3.5 whitespace-nowrap">
                                    @if($n->has_file)
                                        <a href="{{ $n->file_url }}" target="_blank" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-[11px] transition border border-rose-200">
                                            <i class="fa-solid fa-file-pdf mr-1.5 text-rose-600"></i>
                                            <span>পিডিএফ ফাইল</span>
                                            @if($n->file_size)
                                                <span class="text-[10px] text-rose-500 font-mono ml-1">({{ $n->file_size }})</span>
                                            @endif
                                        </a>
                                    @else
                                        <span class="text-slate-400 text-[11px] italic">সংযুক্তি নেই</span>
                                    @endif
                                </td>
                                <td class="p-3.5">
                                    @if($n->is_ticker)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-200">
                                            <i class="fa-solid fa-bullhorn mr-1 text-amber-600"></i>চালু
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-500">
                                            বন্ধ
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3.5">
                                    <form method="POST" action="{{ route('admin.notices.toggle_status', $n->id) }}">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold transition {{ $n->is_active ? 'bg-emerald-100 hover:bg-emerald-200 text-emerald-800 border border-emerald-300' : 'bg-slate-200 hover:bg-slate-300 text-slate-700' }}" title="স্ট্যাটাস পরিবর্তন করতে ক্লিক করুন">
                                            <i class="fa-solid {{ $n->is_active ? 'fa-circle-check text-emerald-600' : 'fa-circle-pause text-slate-500' }} mr-1"></i>
                                            {{ $n->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="p-3.5 text-right pr-5 space-x-1 whitespace-nowrap">
                                    <a href="{{ route('admin.notices.edit', $n->id) }}" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-900 hover:bg-slate-800 text-amber-400 font-bold text-[11px] transition" title="সম্পাদনা">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i>এডিট
                                    </a>
                                    <a href="{{ route('notices.show', $n->id) }}" target="_blank" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-[11px] transition" title="লাইভ প্রিভিউ">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.notices.delete', $n->id) }}" class="inline" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই নোটিশটি মুছে ফেলতে চান?');">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-2 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 transition" title="মুছে ফেলুন">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100">
                {{ $notices->links() }}
            </div>
        @else
            <div class="p-12 text-center text-slate-400 text-xs">
                <i class="fa-solid fa-bullhorn text-4xl mb-3 text-slate-300"></i>
                <p class="font-bold text-slate-600">কোনো নোটিশ পাওয়া যায়নি।</p>
                <p class="text-[11px] text-slate-400 mt-1">নতুন কোনো নোটিশ বা জরুরি প্রেস বিজ্ঞপ্তি প্রকাশ করতে উপরের বোতামটি ব্যবহার করুন।</p>
                <a href="{{ route('admin.notices.create') }}" class="inline-flex items-center px-4 py-2 mt-4 rounded-xl bg-slate-900 text-amber-400 font-bold text-xs">
                    <i class="fa-solid fa-plus mr-1.5"></i>প্রথম নোটিশ প্রকাশ করুন
                </a>
            </div>
        @endif
    </div>

</div>
@endsection
