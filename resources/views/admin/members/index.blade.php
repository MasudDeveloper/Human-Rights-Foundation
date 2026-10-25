@extends('layouts.admin')

@section('title', 'সদস্য আবেদনসমূহ - অ্যাডমিন')
@section('page_title', 'সংস্থার সদস্য আবেদন ব্যবস্থাপনা')

@section('content')
<div class="space-y-6">

    <!-- Search & Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-3 justify-between items-center">
        <!-- Status Tabs -->
        <div class="flex flex-wrap gap-1.5 text-xs font-semibold">
            <a href="{{ route('admin.members') }}" class="px-3 py-1.5 rounded-lg {{ !request('status') ? 'bg-slate-900 text-amber-400' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">সকল</a>
            <a href="{{ route('admin.members', ['status' => 'pending']) }}" class="px-3 py-1.5 rounded-lg {{ request('status') == 'pending' ? 'bg-amber-500 text-slate-950 font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">পেন্ডিং</a>
            <a href="{{ route('admin.members', ['status' => 'approved']) }}" class="px-3 py-1.5 rounded-lg {{ request('status') == 'approved' ? 'bg-emerald-600 text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">অনুমোদিত</a>
            <a href="{{ route('admin.members', ['status' => 'rejected']) }}" class="px-3 py-1.5 rounded-lg {{ request('status') == 'rejected' ? 'bg-rose-600 text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">বাতিল</a>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.members') }}" class="w-full md:w-72 flex gap-2">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}" placeholder="নাম, পদবী, NID বা ফোন..."
                class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-slate-900">
            <button type="submit" class="px-3 py-1.5 rounded-lg bg-slate-900 text-amber-400 font-bold text-xs">
                খুঁজুন
            </button>
        </form>
    </div>

    <!-- Members Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @if($members->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 border-b border-slate-100">
                        <tr>
                            <th class="p-3.5 pl-5">আইডি</th>
                            <th class="p-3.5">নাম (বাংলা ও ইংরেজি)</th>
                            <th class="p-3.5">আবেদনকৃত পদবী</th>
                            <th class="p-3.5">মোবাইল</th>
                            <th class="p-3.5">জেলা</th>
                            <th class="p-3.5">পেমেন্ট TrxID</th>
                            <th class="p-3.5">স্ট্যাটাস</th>
                            <th class="p-3.5 text-right pr-5">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($members as $m)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="p-3.5 pl-5 font-mono font-bold">#{{ $m->id }}</td>
                                <td class="p-3.5">
                                    <strong class="text-slate-900 block">{{ $m->bangla_name }}</strong>
                                    <span class="text-slate-400 font-mono text-[10px]">{{ $m->english_name }}</span>
                                </td>
                                <td class="p-3.5 font-bold text-blue-700">{{ $m->post_name }}</td>
                                <td class="p-3.5 font-mono">{{ $m->phone_number }}</td>
                                <td class="p-3.5">{{ $m->district }}</td>
                                <td class="p-3.5 font-mono text-slate-800">{{ $m->transaction_id }}</td>
                                <td class="p-3.5">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold border {{ $m->status_badge['bg'] }}">
                                        {{ $m->status_badge['label'] }}
                                    </span>
                                </td>
                                <td class="p-3.5 text-right pr-5 space-x-1.5 whitespace-nowrap">
                                    @if(session('admin_role') === 'super_admin')
                                        <a href="{{ route('admin.members.edit', $m->id) }}" class="inline-flex items-center px-2 py-1 rounded-lg bg-amber-100 hover:bg-amber-200 text-amber-900 font-bold text-[11px] transition" title="সদস্য প্রোফাইল সম্পাদনা">
                                            <i class="fa-solid fa-user-pen mr-1"></i>এডিট
                                        </a>
                                    @endif
                                    @if($m->member_id_card_number)
                                        <a href="{{ route('member.id_card', $m->id) }}" target="_blank" class="inline-flex items-center px-2 py-1 rounded-lg bg-slate-900 hover:bg-slate-800 text-amber-400 font-bold text-[11px] transition" title="ডিজিটাল আইডি কার্ড">
                                            <i class="fa-solid fa-id-card mr-1"></i>কার্ড
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.members.show', $m->id) }}" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-[11px] transition" title="যাচাই ও অনুমোদন">
                                        <i class="fa-solid fa-eye mr-1"></i>বিস্তারিত
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
            <div class="p-4 border-t border-slate-100">
                {{ $members->links() }}
            </div>
        @else
            <div class="p-12 text-center text-slate-400 text-xs">
                <i class="fa-solid fa-id-card-clip text-4xl mb-2 text-slate-300"></i>
                <p>কোনো সদস্য আবেদন পাওয়া যায়নি।</p>
            </div>
        @endif
    </div>

</div>
@endsection
