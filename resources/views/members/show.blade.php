@extends('layouts.app')

@section('title', 'সদস্য আবেদনপত্র - #' . $member->id)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="bg-white rounded-3xl shadow-lg border border-slate-200/80 overflow-hidden">
        
        <div class="p-6 bg-gradient-to-r from-blue-900 to-indigo-950 text-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <span class="text-xs text-blue-300 font-mono">আবেদন আইডি: #{{ $member->id }}</span>
                <h1 class="text-xl sm:text-2xl font-bold mt-1">{{ $member->bangla_name }} ({{ $member->english_name }})</h1>
                <p class="text-xs text-amber-300 font-semibold mt-0.5"><i class="fa-solid fa-award mr-1.5"></i>পদবী: {{ $member->post_name }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold border {{ $member->status_badge['bg'] }}">
                    {{ $member->status_badge['label'] }}
                </span>
                <a href="{{ route('member.print', $member->id) }}" target="_blank" class="px-3.5 py-1.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 text-xs font-bold shadow transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-print"></i>
                    <span>প্রিন্ট কপি</span>
                </a>
            </div>
        </div>

        <div class="p-6 sm:p-8 space-y-6 text-xs text-slate-700">
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                <div>
                    <span class="text-slate-400 block">পিতা/মাতা:</span>
                    <strong class="text-slate-800">{{ $member->father_name ?: '-' }} / {{ $member->mother_name ?: '-' }}</strong>
                </div>
                <div>
                    <span class="text-slate-400 block">জন্ম তারিখ:</span>
                    <span class="text-slate-800">{{ $member->date_of_birth }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">জাতীয় পরিচয়পত্র:</span>
                    <span class="text-slate-800 font-mono">{{ $member->nid }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">শিক্ষাগত যোগ্যতা:</span>
                    <span class="text-slate-800">{{ $member->education }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">পেশা:</span>
                    <span class="text-slate-800">{{ $member->current_job }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">রক্তের গ্রুপ:</span>
                    <span class="text-slate-800 font-bold text-rose-600">{{ $member->blood_group ?: 'অজানা' }}</span>
                </div>
                <div class="sm:col-span-2">
                    <span class="text-slate-400 block">স্থায়ী ঠিকানা:</span>
                    <span class="text-slate-800">{{ $member->village }}, {{ $member->post_office }}, {{ $member->thana }}, {{ $member->district }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">মোবাইল:</span>
                    <span class="text-slate-800 font-mono font-bold">{{ $member->phone_number }}</span>
                </div>
            </div>

            <!-- Payment details -->
            <div class="p-4 rounded-xl bg-blue-50/60 border border-blue-200">
                <h4 class="font-bold text-blue-900 mb-2">পেমেন্ট বিবরণী:</h4>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                    <div><span class="text-slate-500 block">মেথড:</span> <strong>{{ $member->payment_gateway }}</strong></div>
                    <div><span class="text-slate-500 block">প্রেরক নম্বর:</span> <span class="font-mono">{{ $member->payment_number }}</span></div>
                    <div><span class="text-slate-500 block">ট্রানজেকশন আইডি:</span> <span class="font-mono font-bold text-blue-900">{{ $member->transaction_id }}</span></div>
                    <div><span class="text-slate-500 block">পরিমাণ:</span> <strong class="text-emerald-700">৳{{ $member->payment_amount ?: '250' }}</strong></div>
                </div>
            </div>
        </div>

        <div class="p-4 bg-slate-50 border-t border-slate-200 flex justify-between items-center text-xs">
            <a href="{{ route('dashboard') }}" class="text-slate-600 hover:text-slate-900 font-semibold flex items-center">
                <i class="fa-solid fa-arrow-left mr-1.5"></i>ড্যাশবোর্ডে ফিরে যান
            </a>
            <a href="{{ route('member.print', $member->id) }}" target="_blank" class="px-4 py-2 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-bold shadow transition flex items-center space-x-1.5">
                <i class="fa-solid fa-print"></i>
                <span>প্রিন্ট করুন</span>
            </a>
        </div>
    </div>
</div>
@endsection
