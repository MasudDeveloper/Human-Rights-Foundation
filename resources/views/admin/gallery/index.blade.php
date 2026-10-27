@extends('layouts.admin')

@section('title', 'ফটো গ্যালারি ব্যবস্থাপনা - অ্যাডমিন')
@section('page_title', 'সংস্থার কার্যক্রম ও ফটো গ্যালারি ব্যবস্থাপনা')

@section('content')
<div class="space-y-6">

    <!-- Header Stats Banner -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-500 font-semibold block">মোট ছবি</span>
                <span class="text-2xl font-extrabold text-slate-900 mt-1 block">{{ $totalPhotos }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-camera-retro"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-500 font-semibold block">প্রকাশিত ও সক্রিয়</span>
                <span class="text-2xl font-extrabold text-emerald-600 mt-1 block">{{ $activePhotos }}</span>
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
        <div class="flex flex-wrap items-center gap-1.5 text-xs font-semibold">
            <a href="{{ route('admin.gallery') }}" class="px-3 py-1.5 rounded-lg {{ !request('category') ? 'bg-slate-900 text-amber-400 font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                সকল ছবি
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('admin.gallery', ['category' => $cat]) }}" class="px-3 py-1.5 rounded-lg {{ request('category') === $cat ? 'bg-amber-500 text-slate-950 font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        <!-- Search Form & Add Button -->
        <div class="flex items-center space-x-3 w-full md:w-auto">
            <form method="GET" action="{{ route('admin.gallery') }}" class="relative flex-grow md:w-64">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="শিরোনাম দিয়ে খুঁজুন..." 
                       class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
            </form>

            <a href="{{ route('admin.gallery.create') }}" class="px-4 py-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold text-xs rounded-xl shadow-md transition flex items-center space-x-1.5 flex-shrink-0">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <span>নতুন ছবি আপলোড</span>
            </a>
        </div>
    </div>

    <!-- Gallery Table / Card List -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3 px-4 text-center w-12">#</th>
                        <th class="py-3 px-4 w-28">ছবি</th>
                        <th class="py-3 px-4">শিরোনাম ও বিবরণ</th>
                        <th class="py-3 px-4">ক্যাটাগরি</th>
                        <th class="py-3 px-4">তারিখ</th>
                        <th class="py-3 px-4 text-center">ক্রম</th>
                        <th class="py-3 px-4 text-center">স্ট্যাটাস</th>
                        <th class="py-3 px-4 text-right">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($photos as $photo)
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Index -->
                            <td class="py-3 px-4 text-center font-mono text-slate-400">
                                {{ $loop->iteration + ($photos->currentPage() - 1) * $photos->perPage() }}
                            </td>

                            <!-- Image Thumbnail -->
                            <td class="py-3 px-4">
                                <a href="{{ $photo->image_url }}" target="_blank" class="block w-20 h-14 rounded-xl overflow-hidden border border-slate-200 shadow-sm hover:opacity-90 group relative">
                                    <img src="{{ $photo->image_url }}" alt="{{ $photo->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                </a>
                            </td>

                            <!-- Title & Description -->
                            <td class="py-3 px-4 max-w-xs">
                                <span class="font-bold text-slate-900 block line-clamp-1 text-sm">
                                    {{ $photo->title }}
                                </span>
                                @if($photo->description)
                                    <span class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">
                                        {{ $photo->description }}
                                    </span>
                                @endif
                                <span class="text-[10px] text-slate-400 mt-1 block">
                                    আপলোডকারী: {{ $photo->created_by ?? 'অ্যাডমিন' }}
                                </span>
                            </td>

                            <!-- Category -->
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                    {{ $photo->category }}
                                </span>
                            </td>

                            <!-- Date -->
                            <td class="py-3 px-4 text-slate-500 whitespace-nowrap">
                                <span class="font-mono text-xs">{{ $photo->formatted_date }}</span>
                            </td>

                            <!-- Sort Order -->
                            <td class="py-3 px-4 text-center font-mono font-bold text-slate-600">
                                {{ $photo->sort_order }}
                            </td>

                            <!-- Active Status Toggle -->
                            <td class="py-3 px-4 text-center">
                                <form method="POST" action="{{ route('admin.gallery.toggle_status', $photo->id) }}">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold transition {{ $photo->is_active ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200 border border-slate-300' }}"
                                            title="স্ট্যাটাস পরিবর্তন করতে ক্লিক করুন">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $photo->is_active ? 'bg-emerald-500' : 'bg-slate-400' }} mr-1"></span>
                                        {{ $photo->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                                    </button>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center space-x-1.5">
                                    <a href="{{ route('admin.gallery.edit', $photo->id) }}" 
                                       class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition shadow-sm"
                                       title="সম্পাদনা">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>

                                    <form method="POST" action="{{ route('admin.gallery.delete', $photo->id) }}" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই ছবিটি মুছে ফেলতে চান?');" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center transition shadow-sm"
                                                title="মুছে ফেলুন">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <i class="fa-regular fa-images text-3xl mb-2 text-slate-300 block"></i>
                                <p class="text-xs font-semibold">কোনো ছবি পাওয়া যায়নি</p>
                                <a href="{{ route('admin.gallery.create') }}" class="text-amber-600 hover:underline text-xs mt-1 inline-block font-bold">
                                    প্রথম ছবি আপলোড করুন
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($photos->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $photos->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
