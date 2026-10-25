@extends('layouts.app')

@section('title', 'অভিযোগ ট্র্যাকিং - সরাসরি স্ট্যাটাস যাচাই')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <!-- Header -->
    <div class="text-center mb-8">
        <div class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-2xl flex items-center justify-center mx-auto mb-3 text-xl">
            <i class="fa-solid fa-magnifying-glass-location"></i>
        </div>
        <h1 class="text-2xl font-bold text-slate-900">অভিযোগের লাইভ ট্র্যাকিং</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">আপনার অভিযোগ আইডি, মোবাইল নম্বর অথবা পেমেন্ট ট্রানজেকশন আইডি দিয়ে বর্তমান অবস্থা জানুন</p>
    </div>

    <!-- Search Box -->
    <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-200/80 mb-8">
        <form method="GET" action="{{ route('track') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-grow">
                <i class="fa-solid fa-search absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="অভিযোগ নম্বর (যেমন: 28), ফোন নম্বর বা TrxID..." required
                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-xs sm:text-sm">
            </div>
            <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm shadow-md transition flex items-center justify-center space-x-2">
                <i class="fa-solid fa-search"></i>
                <span>অনুসন্ধান করুন</span>
            </button>
        </form>
    </div>

    <!-- Result Area -->
    @if(request('search'))
        @if($complaint)
            <div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">
                <!-- Status Header Banner -->
                <div class="p-6 bg-gradient-to-r from-brand-950 to-brand-900 text-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-amber-400 font-mono">আইডি: #{{ $complaint->id }}</span>
                            <span class="text-slate-400">•</span>
                            <span class="text-xs text-slate-300">{{ $complaint->created_at ? $complaint->created_at->format('d M, Y h:i A') : $complaint->time }}</span>
                        </div>
                        <h2 class="text-lg font-bold text-white mt-1">{{ $complaint->name }}</h2>
                        <p class="text-xs text-slate-300 font-medium"><i class="fa-solid fa-tag text-amber-400 mr-1.5"></i>{{ $complaint->complaint_type }}</p>
                    </div>
                    <div>
                        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold border {{ $complaint->status_badge['bg'] }}">
                            <span class="w-2 h-2 rounded-full mr-2 bg-current animate-pulse"></span>
                            {{ $complaint->status_badge['label'] }}
                        </span>
                    </div>
                </div>

                <!-- Rejection Alert if rejected -->
                @if($complaint->status === 'rejected')
                    <div class="p-4 bg-rose-50 border-b border-rose-200 text-rose-900 text-xs flex items-start space-x-3">
                        <i class="fa-solid fa-circle-exclamation text-rose-600 text-base mt-0.5"></i>
                        <div>
                            <p class="font-bold">অভিযোগটি গৃহীত হয়নি (কারণ):</p>
                            <p class="mt-0.5 text-rose-700">{{ $complaint->reject_reason ?: 'প্রয়োজনীয় তথ্যের ঘাটতি অথবা অস্পষ্ট পেমেন্ট বিবরণী।' }}</p>
                        </div>
                    </div>
                @endif

                <!-- Visual Step Progress Tracker -->
                <div class="p-6 border-b border-slate-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-6">তদন্তের অগ্রগতি ধাপ</h3>
                    
                    @php
                        $step = match($complaint->status) {
                            'pending' => 1,
                            'approved' => 2,
                            'investigated' => 3,
                            'complete' => 4,
                            'rejected' => 1,
                            default => 1
                        };
                    @endphp

                    <div class="relative flex items-center justify-between">
                        <!-- Progress Line -->
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-slate-200 w-full z-0"></div>
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-emerald-500 z-0 transition-all duration-500" style="width: {{ ($step - 1) * 33.33 }}%;"></div>

                        <!-- Step 1 -->
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold {{ $step >= 1 ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500' }}">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <span class="text-[11px] font-semibold mt-2 text-slate-700">জমা হয়েছে</span>
                        </div>

                        <!-- Step 2 -->
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold {{ $step >= 2 ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500' }}">
                                @if($step >= 2)<i class="fa-solid fa-check"></i>@else 2 @endif
                            </div>
                            <span class="text-[11px] font-semibold mt-2 text-slate-700">যাচাই ও অনুমোদন</span>
                        </div>

                        <!-- Step 3 -->
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold {{ $step >= 3 ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500' }}">
                                @if($step >= 3)<i class="fa-solid fa-check"></i>@else 3 @endif
                            </div>
                            <span class="text-[11px] font-semibold mt-2 text-slate-700">মাঠপর্যায়ে তদন্ত</span>
                        </div>

                        <!-- Step 4 -->
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold {{ $step >= 4 ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500' }}">
                                @if($step >= 4)<i class="fa-solid fa-check"></i>@else 4 @endif
                            </div>
                            <span class="text-[11px] font-semibold mt-2 text-slate-700">আইনি নিষ্পত্তি</span>
                        </div>
                    </div>
                </div>

                <!-- Complaint Details Preview -->
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
                    <div class="space-y-2">
                        <h4 class="font-bold text-slate-900 border-b pb-1 text-xs uppercase text-slate-500">অভিযোগকারী ও ঠিকানা</h4>
                        <p><span class="text-slate-500">নাম:</span> <strong class="text-slate-800">{{ $complaint->name }}</strong> (বয়স: {{ $complaint->age }})</p>
                        <p><span class="text-slate-500">পিতা/মাতা:</span> {{ $complaint->father_name ?: '-' }} / {{ $complaint->mother_name ?: '-' }}</p>
                        <p><span class="text-slate-500">ঠিকানা:</span> {{ $complaint->village }}, {{ $complaint->thana }}, {{ $complaint->district }}</p>
                        <p><span class="text-slate-500">যোগাযোগ:</span> {{ $complaint->phone_number }}</p>
                    </div>

                    <div class="space-y-2">
                        <h4 class="font-bold text-slate-900 border-b pb-1 text-xs uppercase text-slate-500">পেমেন্ট ও ট্রানজেকশন</h4>
                        <p><span class="text-slate-500">গেটওয়ে:</span> <strong class="text-slate-800">{{ $complaint->payment_gateway }}</strong></p>
                        <p><span class="text-slate-500">প্রেরক নম্বর:</span> {{ $complaint->payment_number }}</p>
                        <p><span class="text-slate-500">ট্রানজেকশন আইডি:</span> <span class="font-mono bg-slate-100 px-2 py-0.5 rounded text-brand-900 font-bold">{{ $complaint->transaction_id }}</span></p>
                        <p><span class="text-slate-500">ফি পরিমাণ:</span> ৳{{ $complaint->payment_amount ?: '250' }}</p>
                    </div>

                    <div class="md:col-span-2 pt-2">
                        <h4 class="font-bold text-slate-900 border-b pb-1 text-xs uppercase text-slate-500 mb-2">ঘটনার সংক্ষিপ্ত বিবরণ</h4>
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/80 text-slate-700 leading-relaxed">
                            {{ $complaint->details ?: 'কোনো বিবরণ প্রদান করা হয়নি।' }}
                        </div>
                    </div>

                    <!-- Accused List if any -->
                    @if($complaint->accuseds->count() > 0)
                        <div class="md:col-span-2 pt-2">
                            <h4 class="font-bold text-slate-900 border-b pb-1 text-xs uppercase text-slate-500 mb-2">অভিযুক্ত ব্যক্তি / আসামির তালিকা</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($complaint->accuseds as $acc)
                                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                                        <p class="font-bold text-slate-800">{{ $acc->name }} @if($acc->age)({{ $acc->age }} বছর)@endif</p>
                                        <p class="text-slate-500 text-[11px]">পিতা: {{ $acc->father_name ?: '-' }}</p>
                                        <p class="text-slate-500 text-[11px]">ঠিকানা: {{ $acc->address ?: '-' }}</p>
                                        @if($acc->phone)<p class="text-slate-500 text-[11px]">ফোন: {{ $acc->phone }}</p>@endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Print & PDF Footer Action -->
                <div class="p-4 bg-slate-50 border-t border-slate-200 flex justify-end space-x-3">
                    <a href="{{ route('complaint.print', $complaint->id) }}" target="_blank" class="px-4 py-2 rounded-xl bg-brand-900 hover:bg-brand-800 text-white text-xs font-semibold shadow-sm transition flex items-center space-x-1.5">
                        <i class="fa-solid fa-print"></i>
                        <span>অফিসিয়াল কপি প্রিন্ট / PDF</span>
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200 text-center text-slate-500">
                <i class="fa-solid fa-file-circle-xmark text-4xl text-slate-300 mb-3"></i>
                <p class="font-bold text-slate-700 text-sm">প্রদত্ত তথ্যে কোনো অভিযোগ পাওয়া যায়নি!</p>
                <p class="text-xs text-slate-400 mt-1">দয়া করে সঠিক অভিযোগ আইডি, মোবাইল নম্বর অথবা ট্রানজেকশন আইডি প্রবেশ করান।</p>
            </div>
        @endif
    @endif
</div>
@endsection
