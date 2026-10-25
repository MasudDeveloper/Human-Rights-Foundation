@extends('layouts.app')

@section('title', 'অভিযোগের বিস্তারিত - #' . $complaint->id)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="bg-white rounded-3xl shadow-lg border border-slate-200/80 overflow-hidden">
        
        <!-- Header Banner -->
        <div class="p-6 bg-gradient-to-r from-brand-950 via-brand-900 to-brand-800 text-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <span class="text-xs text-amber-400 font-mono">ট্র্যাকিং নম্বর: #{{ $complaint->id }}</span>
                <h1 class="text-xl sm:text-2xl font-bold mt-1">{{ $complaint->name }}</h1>
                <p class="text-xs text-slate-300 font-medium mt-0.5"><i class="fa-solid fa-tag text-amber-400 mr-1.5"></i>{{ $complaint->complaint_type }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold border {{ $complaint->status_badge['bg'] }}">
                    {{ $complaint->status_badge['label'] }}
                </span>
                <a href="{{ route('complaint.print', $complaint->id) }}" target="_blank" class="px-3.5 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-brand-950 text-xs font-bold shadow transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-print"></i>
                    <span>প্রিন্ট কপি</span>
                </a>
            </div>
        </div>

        @if($complaint->status === 'rejected')
            <div class="p-4 bg-rose-50 border-b border-rose-200 text-rose-900 text-xs flex items-start space-x-3">
                <i class="fa-solid fa-circle-exclamation text-rose-600 text-base mt-0.5"></i>
                <div>
                    <strong class="font-bold">অভিযোগটি গৃহীত হয়নি:</strong>
                    <p class="mt-0.5 text-rose-700">{{ $complaint->reject_reason ?: 'প্রয়োজনীয় তথ্যের ঘাটতি বা ভুল পেমেন্ট বিবরণী।' }}</p>
                </div>
            </div>
        @endif

        <div class="p-6 sm:p-8 space-y-8 text-xs">
            <!-- 1. Complainant details -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b pb-2 mb-4">১. অভিযোগকারীর তথ্য</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <div>
                        <span class="text-slate-400 block">পূর্ণ নাম:</span>
                        <strong class="text-slate-800 text-sm">{{ $complaint->name }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block">বয়স:</span>
                        <span class="text-slate-800 font-medium">{{ $complaint->age }} বছর</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">মোবাইল:</span>
                        <span class="text-slate-800 font-medium">{{ $complaint->phone_number }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">পিতা/মাতা:</span>
                        <span class="text-slate-800">{{ $complaint->father_name ?: '-' }} / {{ $complaint->mother_name ?: '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">স্বামী/স্ত্রী:</span>
                        <span class="text-slate-800">{{ $complaint->spouse_name ?: '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">ঠিকানা:</span>
                        <span class="text-slate-800">{{ $complaint->village }}, {{ $complaint->thana }}, {{ $complaint->district }}</span>
                    </div>
                </div>
            </div>

            <!-- 2. Complaint details -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b pb-2 mb-4">২. ঘটনার বিবরণ</h3>
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 text-slate-700 leading-relaxed text-xs sm:text-sm">
                    {{ $complaint->details ?: 'কোনো বিবরণ প্রদান করা হয়নি।' }}
                </div>
            </div>

            <!-- 3. Accused list -->
            @if($complaint->accuseds->count() > 0)
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b pb-2 mb-4">৩. অভিযুক্ত ব্যক্তি বা আসামির তালিকা ({{ $complaint->accuseds->count() }} জন)</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($complaint->accuseds as $index => $acc)
                            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50">
                                <div class="flex justify-between items-center mb-1">
                                    <h4 class="font-bold text-slate-800 text-xs">{{ $index + 1 }}. {{ $acc->name }}</h4>
                                    @if($acc->age)<span class="text-slate-500 font-mono text-[11px]">{{ $acc->age }} বছর</span>@endif
                                </div>
                                <p class="text-slate-500 text-[11px]">পিতা: {{ $acc->father_name ?: '-' }}</p>
                                <p class="text-slate-500 text-[11px]">ঠিকানা: {{ $acc->address ?: '-' }}</p>
                                @if($acc->phone)<p class="text-slate-500 text-[11px]">ফোন: {{ $acc->phone }}</p>@endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 4. Witnesses list -->
            @if($complaint->witnesses->count() > 0)
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b pb-2 mb-4">৪. সাক্ষীদের তালিকা</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($complaint->witnesses as $index => $w)
                            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50">
                                <h4 class="font-bold text-slate-800 text-xs">{{ $index + 1 }}. {{ $w->name }}</h4>
                                <p class="text-slate-500 text-[11px]">পিতা: {{ $w->father_name ?: '-' }}</p>
                                <p class="text-slate-500 text-[11px]">ঠিকানা: {{ $w->address ?: '-' }}</p>
                                @if($w->phone_number)<p class="text-slate-500 text-[11px]">ফোন: {{ $w->phone_number }}</p>@endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 5. Payment info -->
            <div class="bg-amber-50/60 p-4 rounded-2xl border border-amber-200/80">
                <h3 class="text-xs font-bold uppercase tracking-wider text-amber-900 border-b border-amber-200 pb-2 mb-3">৫. ফি পেমেন্ট ও ট্রানজেকশন</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div>
                        <span class="text-slate-500 block">মেথড:</span>
                        <strong class="text-slate-800">{{ $complaint->payment_gateway }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-500 block">প্রেরক নম্বর:</span>
                        <span class="text-slate-800 font-mono">{{ $complaint->payment_number }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block">ট্রানজেকশন আইডি:</span>
                        <span class="font-mono bg-white px-2 py-0.5 rounded border border-amber-300 font-bold text-brand-900">{{ $complaint->transaction_id }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block">পরিমাণ:</span>
                        <span class="text-emerald-700 font-bold">৳{{ $complaint->payment_amount ?: '250' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4 bg-slate-50 border-t border-slate-200 flex justify-between items-center text-xs">
            <a href="{{ route('dashboard') }}" class="text-slate-600 hover:text-slate-900 font-semibold flex items-center">
                <i class="fa-solid fa-arrow-left mr-1.5"></i>ড্যাশবোর্ডে ফিরে যান
            </a>
            <a href="{{ route('complaint.print', $complaint->id) }}" target="_blank" class="px-4 py-2 rounded-xl bg-brand-900 hover:bg-brand-800 text-white font-bold shadow transition flex items-center space-x-1.5">
                <i class="fa-solid fa-print"></i>
                <span>অফিসিয়াল কপি প্রিন্ট</span>
            </a>
        </div>

    </div>
</div>
@endsection
