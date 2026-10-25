@extends('layouts.admin')

@section('title', 'সকল অভিযোগ - অ্যাডমিন')
@section('page_title', 'অভিযোগ ব্যবস্থাপনা')

@section('content')
<div class="space-y-6">

    <!-- Search & Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-3 justify-between items-center">
        <!-- Status Tabs -->
        <div class="flex flex-wrap gap-1.5 text-xs font-semibold">
            <a href="{{ route('admin.complaints') }}" class="px-3 py-1.5 rounded-lg {{ !request('status') ? 'bg-slate-900 text-amber-400' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">সকল</a>
            <a href="{{ route('admin.complaints', ['status' => 'pending']) }}" class="px-3 py-1.5 rounded-lg {{ request('status') == 'pending' ? 'bg-amber-500 text-slate-950 font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">পেন্ডিং</a>
            <a href="{{ route('admin.complaints', ['status' => 'investigated']) }}" class="px-3 py-1.5 rounded-lg {{ request('status') == 'investigated' ? 'bg-blue-600 text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">তদন্তাধীন</a>
            <a href="{{ route('admin.complaints', ['status' => 'approved']) }}" class="px-3 py-1.5 rounded-lg {{ request('status') == 'approved' ? 'bg-emerald-600 text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">অনুমোদিত</a>
            <a href="{{ route('admin.complaints', ['status' => 'complete']) }}" class="px-3 py-1.5 rounded-lg {{ request('status') == 'complete' ? 'bg-purple-600 text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">নিষ্পত্তিকৃত</a>
            <a href="{{ route('admin.complaints', ['status' => 'rejected']) }}" class="px-3 py-1.5 rounded-lg {{ request('status') == 'rejected' ? 'bg-rose-600 text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">বাতিল</a>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.complaints') }}" class="w-full md:w-72 flex gap-2">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}" placeholder="নাম, ফোন বা TrxID..."
                class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900">
            <button type="submit" class="px-3 py-1.5 rounded-lg bg-slate-900 text-amber-400 font-bold text-xs">
                খুঁজুন
            </button>
        </form>
    </div>

    <!-- Complaints Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @if($complaints->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 border-b border-slate-100">
                        <tr>
                            <th class="p-3.5 pl-5">আইডি</th>
                            <th class="p-3.5">অভিযোগকারীর নাম</th>
                            <th class="p-3.5">মোবাইল</th>
                            <th class="p-3.5">অভিযোগের ধরণ</th>
                            <th class="p-3.5">ঠিকানা</th>
                            <th class="p-3.5">পেমেন্ট TrxID</th>
                            <th class="p-3.5">তারিখ</th>
                            <th class="p-3.5">স্ট্যাটাস</th>
                            <th class="p-3.5 text-right pr-5">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($complaints as $c)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="p-3.5 pl-5 font-mono font-bold text-slate-900">#{{ $c->id }}</td>
                                <td class="p-3.5 font-bold text-slate-900">{{ $c->name }}</td>
                                <td class="p-3.5 font-mono">{{ $c->phone_number }}</td>
                                <td class="p-3.5 font-medium">{{ $c->complaint_type }}</td>
                                <td class="p-3.5">{{ $c->district }}, {{ $c->thana }}</td>
                                <td class="p-3.5 font-mono text-brand-800 font-semibold">{{ $c->transaction_id }}</td>
                                <td class="p-3.5 text-slate-400 text-[11px]">{{ $c->created_at ? $c->created_at->format('d/m/Y') : $c->time }}</td>
                                <td class="p-3.5">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold border {{ $c->status_badge['bg'] }}">
                                        {{ $c->status_badge['label'] }}
                                    </span>
                                </td>
                                <td class="p-3.5 text-right pr-5 space-x-2">
                                    <a href="{{ route('admin.complaints.show', $c->id) }}" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-900 hover:bg-slate-800 text-amber-400 font-bold text-[11px] transition">
                                        <i class="fa-solid fa-gear mr-1"></i>ব্যবস্থাপনা
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
            <div class="p-4 border-t border-slate-100">
                {{ $complaints->links() }}
            </div>
        @else
            <div class="p-12 text-center text-slate-400 text-xs">
                <i class="fa-solid fa-folder-open text-4xl mb-2 text-slate-300"></i>
                <p>কোনো অভিযোগ পাওয়া যায়নি।</p>
            </div>
        @endif
    </div>

</div>
@endsection
