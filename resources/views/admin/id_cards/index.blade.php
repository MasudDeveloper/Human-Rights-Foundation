@extends('layouts.admin')

@section('title', 'আইডি কার্ড ব্যবস্থাপনা - অ্যাডমিন')
@section('page_title', 'সদস্য ডিজিটাল আইডি কার্ড ব্যবস্থাপনা ও জেনারেটর')

@section('content')
<div class="space-y-6">

    <!-- Header Stats Banner -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-500 font-semibold block">মোট ইস্যুকৃত আইডি কার্ড</span>
                <span class="text-2xl font-extrabold text-amber-600 mt-1 block">{{ $totalCards }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-address-card"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-500 font-semibold block">নিবন্ধিত মোট সদস্য</span>
                <span class="text-2xl font-extrabold text-blue-600 mt-1 block">{{ $totalMembers }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-500 font-semibold block">কার্ড অপেক্ষমাণ সদস্য</span>
                <span class="text-2xl font-extrabold text-rose-500 mt-1 block">{{ $pendingCards }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center text-xl">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
        </div>
    </div>

    <!-- Actions & Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-3 justify-between items-center">
        <!-- Status & Designation Filters -->
        <div class="flex flex-wrap items-center gap-1.5 text-xs font-semibold w-full md:w-auto">
            <a href="{{ route('admin.id_cards') }}" class="px-3 py-1.5 rounded-lg transition {{ !request('status') || request('status') === 'generated' ? 'bg-slate-900 text-amber-400 font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                ইস্যুকৃত কার্ড ({{ $totalCards }})
            </a>
            <a href="{{ route('admin.id_cards', ['status' => 'not_generated']) }}" class="px-3 py-1.5 rounded-lg transition {{ request('status') === 'not_generated' ? 'bg-amber-500 text-slate-950 font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                অপেক্ষমাণ তালিকা ({{ $pendingCards }})
            </a>
        </div>

        <!-- Search Form & Create Action Button -->
        <div class="flex items-center space-x-2.5 w-full md:w-auto">
            <form method="GET" action="{{ route('admin.id_cards') }}" class="relative flex-grow md:w-60">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="নাম, কার্ড নং, ফোন বা পদবী..." 
                       class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
            </form>

            <a href="{{ route('admin.id_cards.create') }}" class="px-4 py-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold text-xs rounded-xl shadow-md transition flex items-center space-x-1.5 flex-shrink-0">
                <i class="fa-solid fa-plus"></i>
                <span>সরাসরি নতুন কার্ড তৈরি</span>
            </a>
        </div>
    </div>

    <!-- ID Cards Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3 px-4 text-center w-12">#</th>
                        <th class="py-3 px-4 w-20 text-center">ছবি</th>
                        <th class="py-3 px-4 w-32">কার্ড নং</th>
                        <th class="py-3 px-4">সদস্যের নাম</th>
                        <th class="py-3 px-4">পদবী</th>
                        <th class="py-3 px-4">মোবাইল ও রক্ত</th>
                        <th class="py-3 px-4">ইস্যু ও মেয়াদ</th>
                        <th class="py-3 px-4 text-center">কার্ড স্ট্যাটাস</th>
                        <th class="py-3 px-4 text-right">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($cards as $index => $c)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3 px-4 text-center font-mono text-slate-400">
                                {{ $cards->firstItem() + $index }}
                            </td>
                            
                            <!-- Circular Photo Frame -->
                            <td class="py-3 px-4 text-center">
                                <div class="w-11 h-11 rounded-full bg-slate-100 border-2 border-amber-400 overflow-hidden mx-auto flex items-center justify-center shadow-xs">
                                    @if($c->effective_photo)
                                        <img src="{{ $c->effective_photo }}" alt="{{ $c->bangla_name }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fa-solid fa-user text-slate-400 text-sm"></i>
                                    @endif
                                </div>
                            </td>

                            <!-- Card Number -->
                            <td class="py-3 px-4">
                                @if($c->member_id_card_number)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-amber-100 text-amber-950 font-mono font-bold text-xs border border-amber-200 shadow-2xs">
                                        {{ $c->member_id_card_number }}
                                    </span>
                                @else
                                    <span class="text-slate-400 font-mono text-[11px]">জেনারেট হয়নি</span>
                                @endif
                            </td>

                            <!-- Name -->
                            <td class="py-3 px-4">
                                <div class="font-bold text-slate-900 text-xs">
                                    {{ $c->bangla_name }}
                                </div>
                                <div class="text-[11px] font-mono text-slate-500 uppercase tracking-tight">
                                    {{ $c->english_name }}
                                </div>
                            </td>

                            <!-- Designation -->
                            <td class="py-3 px-4">
                                <span class="font-semibold text-blue-900 bg-blue-50 px-2 py-0.5 rounded border border-blue-100">
                                    {{ $c->post_name ?: 'সদস্য' }}
                                </span>
                            </td>

                            <!-- Phone & Blood -->
                            <td class="py-3 px-4">
                                <div class="font-mono text-slate-700 text-xs">{{ $c->phone_number }}</div>
                                @if($c->blood_group)
                                    <span class="inline-block text-[10px] font-bold text-rose-600 bg-rose-50 px-1.5 py-0.2 rounded mt-0.5">
                                        {{ $c->blood_group }}
                                    </span>
                                @endif
                            </td>

                            <!-- Issue & Expiry -->
                            <td class="py-3 px-4 text-[11px]">
                                <div class="text-slate-600">
                                    <span class="text-slate-400">ইস্যু:</span> {{ $c->id_card_issue_date ? date('d M Y', strtotime($c->id_card_issue_date)) : 'N/A' }}
                                </div>
                                <div class="text-slate-600">
                                    <span class="text-slate-400">মেয়াদ:</span> {{ $c->id_card_expiry_date ? date('d M Y', strtotime($c->id_card_expiry_date)) : 'N/A' }}
                                </div>
                            </td>

                            <!-- Card Status -->
                            <td class="py-3 px-4 text-center">
                                @if($c->id_card_status === 'generated')
                                    @php
                                        $isExpired = $c->id_card_expiry_date && strtotime($c->id_card_expiry_date) < time();
                                    @endphp
                                    @if($isExpired)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700">
                                            মেয়াদোত্তীর্ণ
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                            সক্রিয় কার্ড
                                        </span>
                                    @endif
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                        কার্ডহীন
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="py-3 px-4 text-right">
                                <div class="inline-flex items-center space-x-1.5">
                                    @if($c->id_card_status === 'generated')
                                        <a href="{{ route('member.id_card', $c->id) }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-[11px] transition shadow-xs flex items-center space-x-1" title="ডিজিটাল আইডি কার্ড দেখুন ও প্রিন্ট করুন">
                                            <i class="fa-solid fa-id-card"></i>
                                            <span>কার্ড</span>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.id_cards.create', ['member_id' => $c->id]) }}" class="px-2.5 py-1 rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-bold text-[11px] transition shadow-xs flex items-center space-x-1" title="কার্ড জেনারেট করুন">
                                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                                            <span>জেনারেট</span>
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.members.edit', $c->id) }}" class="p-1.5 text-slate-500 hover:text-amber-600 transition" title="তথ্য ও ছবি এডিট">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <a href="{{ route('admin.members.show', $c->id) }}" class="p-1.5 text-slate-500 hover:text-blue-600 transition" title="সম্পূর্ণ প্রোফাইল দেখুন">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-address-card text-4xl mb-2 block text-slate-300"></i>
                                <p class="text-xs">কোনো আইডি কার্ড পাওয়া যায়নি।</p>
                                <a href="{{ route('admin.id_cards.create') }}" class="inline-block mt-3 px-4 py-1.5 bg-amber-500 text-slate-950 font-bold text-xs rounded-xl shadow hover:bg-amber-400 transition">
                                    নতুন আইডি কার্ড জেনারেট করুন
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($cards->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $cards->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
