@extends('layouts.app')

@section('title', 'অনুমোদিত সদস্য ও দায়িত্বশীলবৃন্দ - আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন')

@section('content')
<div class="bg-gradient-to-b from-slate-100/70 via-white to-slate-50 min-h-screen py-10 sm:py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-extrabold bg-amber-500/10 text-amber-700 border border-amber-300 mb-2">
                <i class="fa-solid fa-users mr-1.5 text-amber-600"></i>সারাদেশের অনুমোদিত প্রতিনিধিগণ
            </span>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">অনুমোদিত সদস্য ও দায়িত্বশীলবৃন্দ</h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-2">সংস্থার কেন্দ্রীয় কমিটি, জেলা ও উপজেলা পর্যায়ের অনুমোদিত সদস্য ও কর্মকর্তাদের তালিকা</p>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white p-4 sm:p-5 rounded-3xl shadow-sm border border-slate-200/90 mb-10">
            <form method="GET" action="{{ route('members.directory') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                <div class="sm:col-span-7 relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="সদস্যের নাম, ইংরেজি নাম, কার্ড নম্বর বা পদবী..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-2xl border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900 font-medium">
                </div>
                <div class="sm:col-span-3">
                    <input type="text" name="district" value="{{ request('district') }}" placeholder="জেলা (যেমন: ঢাকা / চট্টগ্রাম)"
                        class="w-full px-4 py-2.5 rounded-2xl border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900 font-medium">
                </div>
                <div class="sm:col-span-2 flex gap-2">
                    <button type="submit" class="w-full py-2.5 px-4 rounded-2xl bg-gradient-to-r from-slate-900 to-indigo-950 hover:from-slate-800 hover:to-indigo-900 text-amber-400 font-extrabold text-xs shadow-md transition flex items-center justify-center space-x-1.5">
                        <i class="fa-solid fa-filter text-[11px]"></i>
                        <span>ফিল্টার</span>
                    </button>
                    @if(request('search') || request('district'))
                        <a href="{{ route('members.directory') }}" class="py-2.5 px-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs flex items-center justify-center" title="রিসেট">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Members Grid -->
        @if($members->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($members as $m)
                    <div class="group bg-white rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col justify-between overflow-hidden relative">
                        
                        <!-- Top Accent Banner -->
                        <div class="h-20 bg-gradient-to-r from-[#06182c] via-[#0b2949] to-[#123e6b] relative px-4 pt-3 flex justify-between items-start">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-mono font-bold bg-amber-400 text-slate-950 shadow-sm">
                                ID: {{ $m->member_id_card_number ?: str_pad($m->id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                            @if($m->blood_group)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-600 text-white shadow-sm">
                                    <i class="fa-solid fa-droplet mr-1 text-[8px]"></i>{{ $m->blood_group }}
                                </span>
                            @endif
                        </div>

                        <!-- Member Avatar (Overlapping Top Banner) -->
                        <div class="px-5 pb-5 -mt-12 text-center flex-grow flex flex-col items-center">
                            
                            <!-- Avatar Frame with Golden Border -->
                            <div class="w-24 h-24 rounded-full p-1 bg-white shadow-lg ring-4 ring-amber-400/40 relative mb-3 group-hover:scale-105 transition duration-300">
                                @if($m->effective_photo)
                                    <img src="{{ $m->effective_photo }}" alt="{{ $m->english_name }}" class="w-full h-full object-cover rounded-full">
                                @else
                                    <div class="w-full h-full rounded-full bg-gradient-to-tr from-slate-900 to-indigo-900 text-amber-400 font-extrabold text-2xl flex items-center justify-center">
                                        {{ mb_substr($m->bangla_name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="absolute bottom-1 right-1 w-5 h-5 rounded-full bg-emerald-500 border-2 border-white flex items-center justify-center text-[10px] text-white shadow" title="অনুমোদিত সদস্য">
                                    <i class="fa-solid fa-check"></i>
                                </span>
                            </div>

                            <!-- Designation Badge -->
                            <div class="mb-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-900 border border-amber-300/80 shadow-xs">
                                    <i class="fa-solid fa-award mr-1.5 text-amber-600"></i>
                                    {{ $m->post_name ?: 'সাধারণ সদস্য' }}
                                </span>
                            </div>

                            <!-- Member Name -->
                            <h3 class="font-extrabold text-slate-900 text-base leading-snug group-hover:text-blue-900 transition line-clamp-1">
                                {{ $m->bangla_name }}
                            </h3>
                            <p class="text-[11px] text-slate-400 font-mono font-semibold uppercase tracking-wider mt-0.5 line-clamp-1">
                                {{ $m->english_name }}
                            </p>

                            <!-- Location Info -->
                            <div class="mt-3 pt-3 border-t border-slate-100 w-full flex items-center justify-center text-xs text-slate-500 space-x-1.5">
                                <i class="fa-solid fa-location-dot text-rose-500 text-[11px]"></i>
                                <span class="line-clamp-1">
                                    {{ $m->district ? ($m->thana ? $m->thana . ', ' . $m->district : $m->district) : 'কেন্দ্রীয় কার্যালয়' }}
                                </span>
                            </div>

                        </div>

                        <!-- Card Action Footer -->
                        <div class="p-4 bg-slate-50 border-t border-slate-100/80 space-y-2">
                            <div class="flex items-center justify-between text-[11px] px-1 text-slate-500 font-semibold">
                                <span class="text-emerald-700 flex items-center">
                                    <i class="fa-solid fa-shield-halved mr-1 text-emerald-600"></i>অনুমোদিত সদস্য
                                </span>
                                <span class="text-slate-400 font-mono text-[10px]">
                                    {{ $m->id_card_expiry_date ? date('Y', strtotime($m->id_card_expiry_date)) . ' পর্যন্ত' : 'আজীবন' }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 pt-1">
                                <a href="{{ route('member.id_card', $m->id) }}" target="_blank" class="py-2 px-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-extrabold text-[11px] shadow transition flex items-center justify-center space-x-1 text-center">
                                    <i class="fa-solid fa-id-card"></i>
                                    <span>আইডি কার্ড</span>
                                </a>
                                <a href="{{ route('member.verify', ['search' => $m->member_id_card_number ?: $m->id]) }}" target="_blank" class="py-2 px-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-[11px] shadow transition flex items-center justify-center space-x-1 text-center">
                                    <i class="fa-solid fa-qrcode text-amber-400"></i>
                                    <span>যাচাই</span>
                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                {{ $members->links() }}
            </div>
        @else
            <div class="bg-white rounded-3xl p-12 border border-slate-200 text-center shadow-sm">
                <i class="fa-solid fa-users-slash text-4xl mb-3 text-slate-300"></i>
                <h3 class="text-base font-bold text-slate-800">কোনো সদস্য পাওয়া যায়নি</h3>
                <p class="text-xs text-slate-500 mt-1">আপনার অনুসন্ধানের সাথে মিলে এমন কোনো অনুমোদিত সদস্যের তথ্য নেই।</p>
                <a href="{{ route('members.directory') }}" class="inline-flex items-center px-5 py-2.5 mt-4 rounded-xl bg-slate-900 text-amber-400 font-bold text-xs shadow">
                    সকল সদস্য দেখুন
                </a>
            </div>
        @endif

    </div>
</div>
@endsection
