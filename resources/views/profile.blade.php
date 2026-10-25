@extends('layouts.app')

@section('title', 'আমার প্রোফাইল - মানবাধিকার ফাউন্ডেশন')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 p-6 sm:p-10 space-y-8">
        
        <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6 border-b pb-6">
            @if($user->profile_image)
                <img src="{{ asset($user->profile_image) }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-2xl object-cover border-2 border-amber-400 shadow">
            @else
                <div class="w-24 h-24 rounded-2xl bg-amber-400 text-brand-950 font-bold flex items-center justify-center text-4xl shadow">
                    {{ mb_substr($user->name, 0, 1) }}
                </div>
            @endif
            <div class="text-center sm:text-left">
                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 mb-1 border border-emerald-200">
                    <i class="fa-solid fa-shield-check mr-1"></i>ভেরিফাইড নাগরিক
                </span>
                <h1 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">নিবন্ধন আইডি: #{{ $user->id }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
            <div class="space-y-3 p-4 bg-slate-50 rounded-2xl border border-slate-200">
                <h3 class="font-bold text-slate-900 border-b pb-1">ব্যক্তিগত ও যোগাযোগের তথ্য</h3>
                <p><span class="text-slate-400">মোবাইল নম্বর:</span> <strong class="text-slate-800 font-mono">{{ $user->number }}</strong></p>
                <p><span class="text-slate-400">ইমেইল ঠিকানা:</span> <span class="text-slate-800">{{ $user->email }}</span></p>
                <p><span class="text-slate-400">জন্ম তারিখ:</span> <span class="text-slate-800">{{ $user->date_of_birth }}</span></p>
                <p><span class="text-slate-400">জাতীয় পরিচয়পত্র (NID):</span> <strong class="text-slate-900 font-mono">{{ $user->nid_number }}</strong></p>
            </div>

            <div class="space-y-3 p-4 bg-slate-50 rounded-2xl border border-slate-200">
                <h3 class="font-bold text-slate-900 border-b pb-1">অ্যাকাউন্ট ও নিরাপত্তা</h3>
                <p><span class="text-slate-400">নিবন্ধন তারিখ:</span> <span class="text-slate-800">{{ $user->created_at ? $user->created_at->format('d M, Y h:i A') : '-' }}</span></p>
                <p><span class="text-slate-400">মোট অভিযোগ দায়ের:</span> <strong class="text-brand-900 font-mono">{{ $user->complaints->count() }} টি</strong></p>
                <p><span class="text-slate-400">সদস্য আবেদন:</span> <strong class="text-blue-900 font-mono">{{ $user->members->count() }} টি</strong></p>
            </div>
        </div>

        <!-- NID Documents -->
        <div>
            <h3 class="font-bold text-slate-900 text-xs border-b pb-2 mb-4">জাতীয় পরিচয়পত্র (NID) কপি</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-center text-xs">
                    <span class="block text-slate-500 mb-2">NID সামনের পাতা</span>
                    @if($user->nid_front_image)
                        <img src="{{ asset($user->nid_front_image) }}" class="h-40 mx-auto object-contain border rounded-lg shadow-sm">
                    @else
                        <p class="text-slate-400 py-10">ছবি নেই</p>
                    @endif
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-center text-xs">
                    <span class="block text-slate-500 mb-2">NID পিছনের পাতা</span>
                    @if($user->nid_back_image)
                        <img src="{{ asset($user->nid_back_image) }}" class="h-40 mx-auto object-contain border rounded-lg shadow-sm">
                    @else
                        <p class="text-slate-400 py-10">ছবি নেই</p>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
