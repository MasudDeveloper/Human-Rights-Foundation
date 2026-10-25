@extends('layouts.app')

@section('title', 'সদস্য পরিচিতি ও আইডি কার্ড যাচাই - মানবাধিকার ফাউন্ডেশন')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    
    <!-- Header -->
    <div class="text-center mb-8">
        <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-2xl flex items-center justify-center mx-auto mb-3 text-xl shadow-sm">
            <i class="fa-solid fa-id-card"></i>
        </div>
        <h1 class="text-2xl font-bold text-slate-900">অনলাইন সদস্য পরিচিতি ও আইডি কার্ড যাচাই</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">সদস্যের কার্ড নম্বর, নাম বা মোবাইল নম্বর দিয়ে অফিশিয়াল ভেরিফিকেশন স্ট্যাটাস ও ডিজিটাল কার্ড দেখুন</p>
    </div>

    <!-- Search Form -->
    <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-200/80 mb-8">
        <form method="GET" action="{{ route('member.verify') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-grow">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="সদস্য আইডি (যেমন: ILHRF-0003), নাম বা মোবাইল..." required
                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-xs sm:text-sm">
            </div>
            <button type="submit" class="px-6 py-3 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs sm:text-sm shadow-md transition flex items-center justify-center space-x-2">
                <i class="fa-solid fa-search"></i>
                <span>যাচাই করুন</span>
            </button>
        </form>
    </div>

    <!-- Result Area -->
    @if(request('search'))
        @if($member)
            <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden">
                <!-- Verified Top Banner -->
                <div class="p-6 bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-800 text-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-full bg-white text-emerald-700 flex items-center justify-center text-2xl shadow">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <span class="text-xs text-emerald-200 font-bold uppercase tracking-wider">ভেরিফাইড সদস্য প্রোফাইল</span>
                            <h2 class="text-xl font-bold text-white mt-0.5">{{ $member->bangla_name }} ({{ $member->english_name }})</h2>
                            <p class="text-xs text-emerald-100 font-mono">আইডি নং: <strong>{{ $member->member_id_card_number }}</strong></p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('member.id_card', $member->id) }}" target="_blank" class="px-4 py-2 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold text-xs shadow-md transition flex items-center space-x-1.5">
                            <i class="fa-solid fa-id-card"></i>
                            <span>ডিজিটাল আইডি কার্ড দেখুন</span>
                        </a>
                    </div>
                </div>

                <!-- Verification Body -->
                <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-12 gap-6 text-xs items-center">
                    <!-- Photo -->
                    <div class="md:col-span-3 text-center">
                        <div class="w-28 h-32 mx-auto rounded-2xl overflow-hidden border-2 border-emerald-500 shadow-md bg-slate-100 mb-2 flex items-center justify-center">
                            @if($member->effective_photo)
                                <img src="{{ $member->effective_photo }}" alt="{{ $member->bangla_name }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-center text-slate-400">
                                    <i class="fa-solid fa-user-tie text-4xl text-slate-400/80 mb-1"></i>
                                    <span class="block text-[8px] font-bold text-slate-500 uppercase">MEMBER</span>
                                </div>
                            @endif
                        </div>
                        <span class="inline-block px-3 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                            অনুমোদিত সদস্য
                        </span>
                    </div>


                    <!-- Details -->
                    <div class="md:col-span-9 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block text-[11px]">সংস্থার পদবী:</span>
                            <strong class="text-blue-900 text-sm">{{ $member->post_name }}</strong>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block text-[11px]">রক্তের গ্রুপ:</span>
                            <strong class="text-rose-600 text-sm font-bold">{{ $member->blood_group ?: 'অজানা' }}</strong>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block text-[11px]">জেলা ও কর্মএলাকা:</span>
                            <strong class="text-slate-800">{{ $member->district ? $member->district . ', ' . $member->thana : 'কেন্দ্রীয়' }}</strong>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block text-[11px]">আইডি কার্ড মেয়াদকাল:</span>
                            <strong class="text-slate-800">
                                {{ $member->id_card_issue_date ? date('d M, Y', strtotime($member->id_card_issue_date)) : '-' }} হতে 
                                {{ $member->id_card_expiry_date ? date('d M, Y', strtotime($member->id_card_expiry_date)) : '-' }}
                            </strong>
                        </div>
                    </div>
                </div>

                <!-- Footer Action -->
                <div class="p-4 bg-slate-50 border-t border-slate-200 flex justify-between items-center text-xs">
                    <span class="text-slate-500 text-[11px]">অনুমোদনকারী: {{ $siteSettings['authorized_signature_name'] ?? 'ব্যারিস্টার এ. কে. এম. শহীদুল ইসলাম' }}</span>

                    <a href="{{ route('member.id_card', $member->id) }}" target="_blank" class="px-4 py-2 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-bold shadow transition flex items-center space-x-1.5">
                        <i class="fa-solid fa-print"></i>
                        <span>প্রিন্ট আইডি কার্ড</span>
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200 text-center text-slate-500">
                <i class="fa-solid fa-id-card-clip text-4xl text-slate-300 mb-3"></i>
                <p class="font-bold text-slate-700 text-sm">প্রদত্ত তথ্যে কোনো অনুমোদিত সদস্যের রেকর্ড পাওয়া যায়নি!</p>
                <p class="text-xs text-slate-400 mt-1">সদস্যের সঠিক কার্ড নম্বর (যেমন: ILHRF-0003), মোবাইল নম্বর অথবা নাম পুনরায় যাচাই করুন।</p>
            </div>
        @endif
    @endif

</div>
@endsection
