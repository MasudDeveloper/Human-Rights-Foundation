@extends('layouts.admin')

@section('title', 'ড্যাশবোর্ড - অ্যাডমিন')
@section('page_title', 'প্রশাসনিক ড্যাশবোর্ড ওভারভিউ')

@section('content')
<div class="space-y-6">

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <!-- Total Complaints -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-[11px] font-bold">মোট অভিযোগ</span>
                <i class="fa-solid fa-folder-closed text-brand-600"></i>
            </div>
            <h3 class="text-2xl font-black text-slate-800 font-mono">{{ $stats['total_complaints'] }}</h3>
        </div>

        <!-- Pending -->
        <div class="bg-amber-50 p-4 rounded-2xl border border-amber-200 shadow-sm">
            <div class="flex items-center justify-between text-amber-700 mb-2">
                <span class="text-[11px] font-bold">পেন্ডিং (Pending)</span>
                <i class="fa-solid fa-hourglass-start text-amber-600"></i>
            </div>
            <h3 class="text-2xl font-black text-amber-600 font-mono">{{ $stats['pending_complaints'] }}</h3>
        </div>

        <!-- Investigated -->
        <div class="bg-blue-50 p-4 rounded-2xl border border-blue-200 shadow-sm">
            <div class="flex items-center justify-between text-blue-700 mb-2">
                <span class="text-[11px] font-bold">তদন্তাধীন</span>
                <i class="fa-solid fa-magnifying-glass text-blue-600"></i>
            </div>
            <h3 class="text-2xl font-black text-blue-600 font-mono">{{ $stats['investigated_complaints'] }}</h3>
        </div>

        <!-- Approved -->
        <div class="bg-emerald-50 p-4 rounded-2xl border border-emerald-200 shadow-sm">
            <div class="flex items-center justify-between text-emerald-700 mb-2">
                <span class="text-[11px] font-bold">অনুমোদিত</span>
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
            </div>
            <h3 class="text-2xl font-black text-emerald-600 font-mono">{{ $stats['approved_complaints'] }}</h3>
        </div>

        <!-- Rejected -->
        <div class="bg-rose-50 p-4 rounded-2xl border border-rose-200 shadow-sm">
            <div class="flex items-center justify-between text-rose-700 mb-2">
                <span class="text-[11px] font-bold">বাতিল (Rejected)</span>
                <i class="fa-solid fa-circle-xmark text-rose-600"></i>
            </div>
            <h3 class="text-2xl font-black text-rose-600 font-mono">{{ $stats['rejected_complaints'] }}</h3>
        </div>

        <!-- Total Members -->
        <div class="bg-purple-50 p-4 rounded-2xl border border-purple-200 shadow-sm">
            <div class="flex items-center justify-between text-purple-700 mb-2">
                <span class="text-[11px] font-bold">সদস্য আবেদন</span>
                <i class="fa-solid fa-id-card text-purple-600"></i>
            </div>
            <h3 class="text-2xl font-black text-purple-600 font-mono">{{ $stats['total_members'] }}</h3>
        </div>
    </div>

    <!-- Recent Complaints Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-sm font-bold text-slate-800 flex items-center">
                <i class="fa-solid fa-file-lines text-amber-500 mr-2"></i>
                <span>সাম্প্রতিক অভিযোগসমূহ</span>
            </h3>
            <a href="{{ route('admin.complaints') }}" class="text-xs text-brand-700 font-bold hover:underline">
                সকল অভিযোগ দেখুন &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 border-b border-slate-100">
                    <tr>
                        <th class="p-3 pl-5">আইডি</th>
                        <th class="p-3">অভিযোগকারীর নাম</th>
                        <th class="p-3">মোবাইল</th>
                        <th class="p-3">অভিযোগের ধরণ</th>
                        <th class="p-3">জেলা</th>
                        <th class="p-3">পেমেন্ট TrxID</th>
                        <th class="p-3">স্ট্যাটাস</th>
                        <th class="p-3 text-right pr-5">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @foreach($recentComplaints as $c)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="p-3 pl-5 font-mono font-bold text-slate-900">#{{ $c->id }}</td>
                            <td class="p-3 font-semibold text-slate-900">{{ $c->name }}</td>
                            <td class="p-3 font-mono text-slate-600">{{ $c->phone_number }}</td>
                            <td class="p-3">{{ $c->complaint_type }}</td>
                            <td class="p-3">{{ $c->district }}</td>
                            <td class="p-3 font-mono font-semibold text-brand-800">{{ $c->transaction_id }}</td>
                            <td class="p-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold border {{ $c->status_badge['bg'] }}">
                                    {{ $c->status_badge['label'] }}
                                </span>
                            </td>
                            <td class="p-3 text-right pr-5 space-x-2">
                                <a href="{{ route('admin.complaints.show', $c->id) }}" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-900 hover:bg-slate-800 text-amber-400 font-semibold text-[11px] transition">
                                    <i class="fa-solid fa-pen-to-square mr-1"></i>ব্যবস্থাপনা
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
    </div>

    <!-- Recent Member Applications -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-sm font-bold text-slate-800 flex items-center">
                <i class="fa-solid fa-id-badge text-blue-600 mr-2"></i>
                <span>সাম্প্রতিক সদস্য আবেদনসমূহ</span>
            </h3>
            <a href="{{ route('admin.members') }}" class="text-xs text-brand-700 font-bold hover:underline">
                সকল সদস্য আবেদন &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 border-b border-slate-100">
                    <tr>
                        <th class="p-3 pl-5">আইডি</th>
                        <th class="p-3">নাম</th>
                        <th class="p-3">আবেদনকৃত পদবী</th>
                        <th class="p-3">মোবাইল</th>
                        <th class="p-3">জেলা</th>
                        <th class="p-3">স্ট্যাটাস</th>
                        <th class="p-3 text-right pr-5">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @foreach($recentMembers as $m)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="p-3 pl-5 font-mono font-bold">#{{ $m->id }}</td>
                            <td class="p-3 font-semibold text-slate-900">{{ $m->bangla_name }}</td>
                            <td class="p-3 font-semibold text-blue-700">{{ $m->post_name }}</td>
                            <td class="p-3 font-mono">{{ $m->phone_number }}</td>
                            <td class="p-3">{{ $m->district }}</td>
                            <td class="p-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold border {{ $m->status_badge['bg'] }}">
                                    {{ $m->status_badge['label'] }}
                                </span>
                            </td>
                            <td class="p-3 text-right pr-5 space-x-2">
                                <a href="{{ route('admin.members.show', $m->id) }}" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold text-[11px] transition">
                                    বিস্তারিত
                                </a>
                                <a href="{{ route('member.print', $m->id) }}" target="_blank" class="inline-flex items-center px-2 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition" title="প্রিন্ট">
                                    <i class="fa-solid fa-print"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
