@extends('layouts.app')

@section('title', 'ইউজার ড্যাশবোর্ড - মানবাধিকার ফাউন্ডেশন')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- User Welcome Banner -->
    <div class="bg-gradient-to-r from-brand-950 via-brand-900 to-brand-800 text-white rounded-3xl p-6 sm:p-8 shadow-xl mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="flex items-center space-x-4">
            <div class="relative">
                @if($user->profile_image)
                    <img src="{{ asset($user->profile_image) }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-amber-400 shadow-md">
                @else
                    <div class="w-16 h-16 rounded-2xl bg-amber-400 text-brand-950 font-bold flex items-center justify-center text-2xl">
                        {{ mb_substr($user->name, 0, 1) }}
                    </div>
                @endif
                <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-emerald-500 border-2 border-brand-950"></span>
            </div>
            <div>
                <div class="flex items-center space-x-2">
                    <h1 class="text-xl sm:text-2xl font-bold text-white">{{ $user->name }}</h1>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">ভেরিফাইড নাগরিক</span>
                </div>
                <p class="text-xs text-slate-300 mt-1 flex items-center space-x-3">
                    <span><i class="fa-solid fa-phone mr-1 text-slate-400"></i>{{ $user->number }}</span>
                    <span>•</span>
                    <span><i class="fa-solid fa-id-card mr-1 text-slate-400"></i>NID: {{ $user->nid_number }}</span>
                </p>
            </div>
        </div>

        <!-- Quick Top Actions -->
        <div class="flex flex-wrap gap-2 w-full md:w-auto">
            <a href="{{ route('complaints.create') }}" class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-brand-950 font-bold text-xs shadow transition flex items-center justify-center space-x-1.5">
                <i class="fa-solid fa-plus-circle"></i>
                <span>নতুন অভিযোগ দাখিল</span>
            </a>
            <a href="{{ route('member.create') }}" class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-xs border border-white/20 transition flex items-center justify-center space-x-1.5">
                <i class="fa-solid fa-id-badge"></i>
                <span>সদস্য আবেদন</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-medium">আমার মোট অভিযোগ</p>
                <h3 class="text-2xl font-black text-slate-800 font-mono mt-1">{{ $stats['total_complaints'] }}</h3>
            </div>
            <div class="w-11 h-11 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-folder-open"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-medium">অপেক্ষমান (Pending)</p>
                <h3 class="text-2xl font-black text-amber-500 font-mono mt-1">{{ $stats['pending_complaints'] }}</h3>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-medium">তদন্তাধীন (Investigating)</p>
                <h3 class="text-2xl font-black text-blue-500 font-mono mt-1">{{ $stats['investigated_complaints'] }}</h3>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-magnifying-glass-arrow-right"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-medium">অনুমোদিত ও নিষ্পত্তিকৃত</p>
                <h3 class="text-2xl font-black text-emerald-500 font-mono mt-1">{{ $stats['approved_complaints'] }}</h3>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>
    </div>

    <!-- My Complaints Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden mb-8">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
            <h2 class="text-sm font-bold text-slate-900 flex items-center">
                <i class="fa-solid fa-file-lines text-brand-600 mr-2"></i>
                <span>আমার অভিযোগসমূহ</span>
            </h2>
            <a href="{{ route('complaints.create') }}" class="text-xs font-semibold text-brand-700 hover:text-amber-600 flex items-center">
                <i class="fa-solid fa-plus mr-1"></i>নতুন অভিযোগ
            </a>
        </div>

        @if($complaints->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 border-b border-slate-100">
                        <tr>
                            <th class="p-3.5 pl-5">আইডি</th>
                            <th class="p-3.5">অভিযোগের ধরণ</th>
                            <th class="p-3.5">জেলা/থানা</th>
                            <th class="p-3.5">তারিখ</th>
                            <th class="p-3.5">স্ট্যাটাস</th>
                            <th class="p-3.5 text-right pr-5">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($complaints as $c)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="p-3.5 pl-5 font-mono font-bold text-slate-800">#{{ $c->id }}</td>
                                <td class="p-3.5 font-semibold text-slate-900">{{ $c->complaint_type }}</td>
                                <td class="p-3.5">{{ $c->district }}, {{ $c->thana }}</td>
                                <td class="p-3.5 text-slate-500">{{ $c->created_at ? $c->created_at->format('d M, Y') : $c->time }}</td>
                                <td class="p-3.5">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold border {{ $c->status_badge['bg'] }}">
                                        {{ $c->status_badge['label'] }}
                                    </span>
                                </td>
                                <td class="p-3.5 text-right pr-5 space-x-2">
                                    <a href="{{ route('complaints.show', $c->id) }}" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-brand-50 hover:bg-brand-100 text-brand-800 font-semibold transition">
                                        <i class="fa-solid fa-eye mr-1"></i>বিস্তারিত
                                    </a>
                                    <a href="{{ route('complaint.print', $c->id) }}" target="_blank" class="inline-flex items-center px-2 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition" title="প্রিন্ট">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center text-slate-400 text-xs">
                <i class="fa-solid fa-inbox text-3xl mb-2 text-slate-300"></i>
                <p>এখনো কোনো অভিযোগ দাখিল করেননি।</p>
                <a href="{{ route('complaints.create') }}" class="inline-block mt-3 px-4 py-2 rounded-xl bg-amber-500 text-brand-950 font-bold text-xs shadow">
                    অভিযোগ দায়ের করুন
                </a>
            </div>
        @endif
    </div>

    <!-- My Membership Applications -->
    @if($memberships->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="p-5 border-b border-slate-100">
                <h2 class="text-sm font-bold text-slate-900 flex items-center">
                    <i class="fa-solid fa-id-badge text-blue-600 mr-2"></i>
                    <span>আমার সদস্য আবেদনসমূহ</span>
                </h2>
            </div>
            <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($memberships as $m)
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 flex justify-between items-center">
                        <div>
                            <span class="text-[10px] text-slate-400 font-mono">আবেদন #{{ $m->id }}</span>
                            <h4 class="text-sm font-bold text-slate-800">{{ $m->bangla_name }}</h4>
                            <p class="text-xs text-blue-700 font-semibold mt-0.5">পদবী: {{ $m->post_name }}</p>
                            <span class="inline-block mt-2 px-2.5 py-0.5 rounded-full text-[10px] font-semibold border {{ $m->status_badge['bg'] }}">
                                {{ $m->status_badge['label'] }}
                            </span>
                        </div>
                        <div class="space-y-1.5 text-right">
                            @if($m->status === 'approved' || $m->member_id_card_number)
                                <a href="{{ route('member.id_card', $m->id) }}" target="_blank" class="block px-3 py-1.5 rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-bold shadow-sm transition">
                                    <i class="fa-solid fa-id-card mr-1"></i>ডিজিটাল আইডি কার্ড
                                </a>
                            @endif
                            <a href="{{ route('member.show', $m->id) }}" class="block px-3 py-1 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 text-xs font-semibold text-slate-700 shadow-sm transition">
                                বিস্তারিত
                            </a>
                            <a href="{{ route('member.print', $m->id) }}" target="_blank" class="block px-3 py-1 rounded-lg bg-blue-700 hover:bg-blue-800 text-xs font-semibold text-white shadow-sm transition">
                                <i class="fa-solid fa-print mr-1"></i>প্রিন্ট
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
