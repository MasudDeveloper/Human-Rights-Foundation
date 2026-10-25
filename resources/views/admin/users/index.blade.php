@extends('layouts.admin')

@section('title', 'নিবন্ধিত নাগরিকবৃন্দ - অ্যাডমিন')
@section('page_title', 'নিবন্ধিত নাগরিক ও ব্যবহারকারী তালিকা')

@section('content')
<div class="space-y-6">

    <!-- Search Form -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex justify-between items-center">
        <h3 class="text-xs font-bold text-slate-800">মোট নিবন্ধিত নাগরিক: {{ $users->total() }} জন</h3>

        <form method="GET" action="{{ route('admin.users') }}" class="w-full sm:w-72 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="নাম, ফোন বা NID..."
                class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900">
            <button type="submit" class="px-3 py-1.5 rounded-lg bg-slate-900 text-amber-400 font-bold text-xs">
                খুঁজুন
            </button>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @if($users->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 border-b border-slate-100">
                        <tr>
                            <th class="p-3.5 pl-5">আইডি</th>
                            <th class="p-3.5">ছবি</th>
                            <th class="p-3.5">নাগরিকের নাম</th>
                            <th class="p-3.5">মোবাইল</th>
                            <th class="p-3.5">NID নম্বর</th>
                            <th class="p-3.5">অভিযোগ সংখ্যা</th>
                            <th class="p-3.5">নিবন্ধন তারিখ</th>
                            <th class="p-3.5 text-right pr-5">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($users as $u)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="p-3.5 pl-5 font-mono font-bold text-slate-900">#{{ $u->id }}</td>
                                <td class="p-3.5">
                                    @if($u->profile_image)
                                        <img src="{{ asset($u->profile_image) }}" class="w-8 h-8 rounded-full object-cover border">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-600 text-[10px]">
                                            {{ mb_substr($u->name, 0, 1) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="p-3.5 font-bold text-slate-900">{{ $u->name }}</td>
                                <td class="p-3.5 font-mono">{{ $u->number }}</td>
                                <td class="p-3.5 font-mono">{{ $u->nid_number }}</td>
                                <td class="p-3.5 font-mono">
                                    <span class="bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full font-bold text-[10px]">
                                        {{ $u->complaints_count }} টি
                                    </span>
                                </td>
                                <td class="p-3.5 text-slate-400 text-[11px]">{{ $u->created_at ? $u->created_at->format('d/m/Y') : '-' }}</td>
                                <td class="p-3.5 text-right pr-5">
                                    <a href="{{ route('admin.users.show', $u->id) }}" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-900 hover:bg-slate-800 text-amber-400 font-bold text-[11px] transition">
                                        <i class="fa-solid fa-id-card mr-1"></i>প্রোফাইল ও NID
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @else
            <div class="p-12 text-center text-slate-400 text-xs">
                <i class="fa-solid fa-users text-4xl mb-2 text-slate-300"></i>
                <p>কোনো ব্যবহারকারী পাওয়া যায়নি।</p>
            </div>
        @endif
    </div>

</div>
@endsection
