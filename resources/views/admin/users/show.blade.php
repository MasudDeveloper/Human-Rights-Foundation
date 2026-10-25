@extends('layouts.admin')

@section('title', 'নাগরিক প্রোফাইল ও NID যাচাই - #' . $user->id)
@section('page_title', 'নাগরিক প্রোফাইল ও জাতীয় পরিচয়পত্র ভেরিফিকেশন')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- User Header Card -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center space-x-4">
            @if($user->profile_image)
                <img src="{{ asset($user->profile_image) }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-slate-300 shadow">
            @else
                <div class="w-16 h-16 rounded-2xl bg-amber-400 text-slate-900 font-bold flex items-center justify-center text-2xl">
                    {{ mb_substr($user->name, 0, 1) }}
                </div>
            @endif
            <div>
                <span class="text-xs text-slate-400 font-mono">নাগরিক আইডি: #{{ $user->id }}</span>
                <h2 class="text-xl font-bold text-slate-900">{{ $user->name }}</h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    <span class="font-mono text-brand-900 font-semibold"><i class="fa-solid fa-phone mr-1"></i>{{ $user->number }}</span>
                    <span class="mx-2">•</span>
                    <span><i class="fa-solid fa-envelope mr-1"></i>{{ $user->email }}</span>
                </p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @if(session('admin_role') === 'super_admin')
                <form method="POST" action="{{ route('admin.users.impersonate', $user->id) }}">
                    @csrf
                    <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold text-xs shadow transition flex items-center space-x-1.5" title="সরাসরি ইউজারের অ্যাকাউন্টে লগইন করুন">
                        <i class="fa-solid fa-user-secret"></i>
                        <span>ইউজার অ্যাকাউন্টে প্রবেশ (Login as User)</span>
                    </button>
                </form>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="px-3.5 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-amber-400 font-bold text-xs shadow transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-user-pen"></i>
                    <span>এডিট তথ্য</span>
                </a>
            @endif
            <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1.5 rounded-xl border border-emerald-200">
                <i class="fa-solid fa-circle-check mr-1"></i>নিবন্ধিত নাগরিক
            </span>
        </div>
    </div>

    <!-- NID Images Verification Box -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-4 border-b pb-2 flex items-center">
            <i class="fa-solid fa-id-card mr-2 text-brand-700 text-sm"></i>
            <span>জাতীয় পরিচয়পত্র (NID) যাচাই</span>
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- NID Front -->
            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 text-center">
                <span class="block text-xs font-bold text-slate-700 mb-2">NID সামনের পাতা</span>
                @if($user->nid_front_image)
                    <a href="{{ asset($user->nid_front_image) }}" target="_blank" class="block group">
                        <img src="{{ asset($user->nid_front_image) }}" alt="NID Front" class="max-h-64 mx-auto rounded-lg object-contain border shadow-sm group-hover:opacity-90 transition">
                        <span class="text-[11px] text-blue-600 font-semibold mt-2 inline-block"><i class="fa-solid fa-magnifying-glass-plus mr-1"></i>পূর্ণ আকারে দেখতে ক্লিক করুন</span>
                    </a>
                @else
                    <p class="text-xs text-slate-400 py-10">কোনো ছবি পাওয়া যায়নি।</p>
                @endif
            </div>

            <!-- NID Back -->
            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 text-center">
                <span class="block text-xs font-bold text-slate-700 mb-2">NID পিছনের পাতা</span>
                @if($user->nid_back_image)
                    <a href="{{ asset($user->nid_back_image) }}" target="_blank" class="block group">
                        <img src="{{ asset($user->nid_back_image) }}" alt="NID Back" class="max-h-64 mx-auto rounded-lg object-contain border shadow-sm group-hover:opacity-90 transition">
                        <span class="text-[11px] text-blue-600 font-semibold mt-2 inline-block"><i class="fa-solid fa-magnifying-glass-plus mr-1"></i>পূর্ণ আকারে দেখতে ক্লিক করুন</span>
                    </a>
                @else
                    <p class="text-xs text-slate-400 py-10">কোনো ছবি পাওয়া যায়নি।</p>
                @endif
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-slate-100 grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs">
            <div><span class="text-slate-400 block">এনআইডি নম্বর:</span> <strong class="font-mono text-slate-900 text-sm">{{ $user->nid_number }}</strong></div>
            <div><span class="text-slate-400 block">জন্ম তারিখ:</span> <strong class="text-slate-800">{{ $user->date_of_birth }}</strong></div>
            <div><span class="text-slate-400 block">নিবন্ধন সম্পন্ন:</span> <span class="text-slate-600">{{ $user->created_at ? $user->created_at->format('d M, Y h:i A') : '-' }}</span></div>
        </div>
    </div>

    <!-- User's Complaints History -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 font-bold text-slate-800 text-sm">
            এই নাগরিক কর্তৃক দায়েরকৃত অভিযোগসমূহ ({{ $user->complaints->count() }} টি)
        </div>
        @if($user->complaints->count() > 0)
            <div class="overflow-x-auto text-xs">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-500 border-b">
                        <tr>
                            <th class="p-3 pl-4">আইডি</th>
                            <th class="p-3">অভিযোগের ধরণ</th>
                            <th class="p-3">তারিখ</th>
                            <th class="p-3">স্ট্যাটাস</th>
                            <th class="p-3 text-right pr-4">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($user->complaints as $c)
                            <tr>
                                <td class="p-3 pl-4 font-mono font-bold">#{{ $c->id }}</td>
                                <td class="p-3 font-semibold">{{ $c->complaint_type }}</td>
                                <td class="p-3 text-slate-400">{{ $c->created_at ? $c->created_at->format('d/m/Y') : $c->time }}</td>
                                <td class="p-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold border {{ $c->status_badge['bg'] }}">
                                        {{ $c->status_badge['label'] }}
                                    </span>
                                </td>
                                <td class="p-3 text-right pr-4">
                                    <a href="{{ route('admin.complaints.show', $c->id) }}" class="text-brand-700 font-bold hover:underline">ব্যবস্থাপনা &rarr;</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="p-6 text-center text-slate-400 text-xs">কোনো অভিযোগ রেকর্ড নেই।</p>
        @endif
    </div>

</div>
@endsection
