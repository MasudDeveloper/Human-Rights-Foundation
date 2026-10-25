@extends('layouts.app')

@section('title', 'আমার অভিযোগসমূহ - মানবাধিকার ফাউন্ডেশন')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900">আমার অভিযোগসমূহ</h1>
            <p class="text-xs text-slate-500 mt-0.5">আপনার দায়েরকৃত সকল অভিযোগ ও বর্তমান অবস্থা</p>
        </div>
        <a href="{{ route('complaints.create') }}" class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-brand-950 font-bold text-xs shadow transition flex items-center space-x-1.5">
            <i class="fa-solid fa-plus-circle"></i>
            <span>নতুন অভিযোগ দাখিল</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        @if($complaints->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 border-b border-slate-100">
                        <tr>
                            <th class="p-4 pl-6">আইডি</th>
                            <th class="p-4">অভিযোগের ধরণ</th>
                            <th class="p-4">ঠিকানা</th>
                            <th class="p-4">আসামি সংখ্যা</th>
                            <th class="p-4">তারিখ</th>
                            <th class="p-4">স্ট্যাটাস</th>
                            <th class="p-4 text-right pr-6">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($complaints as $c)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="p-4 pl-6 font-mono font-bold text-slate-800">#{{ $c->id }}</td>
                                <td class="p-4 font-bold text-slate-900">{{ $c->complaint_type }}</td>
                                <td class="p-4">{{ $c->district }}, {{ $c->thana }}</td>
                                <td class="p-4 font-mono">{{ $c->accuseds->count() }} জন</td>
                                <td class="p-4 text-slate-500">{{ $c->created_at ? $c->created_at->format('d M, Y') : $c->time }}</td>
                                <td class="p-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold border {{ $c->status_badge['bg'] }}">
                                        {{ $c->status_badge['label'] }}
                                    </span>
                                </td>
                                <td class="p-4 text-right pr-6 space-x-2">
                                    <a href="{{ route('complaints.show', $c->id) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-brand-50 hover:bg-brand-100 text-brand-800 font-semibold transition">
                                        <i class="fa-solid fa-eye mr-1"></i>বিস্তারিত
                                    </a>
                                    <a href="{{ route('complaint.print', $c->id) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition" title="প্রিন্ট">
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
                <i class="fa-solid fa-file-circle-xmark text-4xl mb-3 text-slate-300"></i>
                <p class="font-bold text-slate-600">কোনো অভিযোগ রেকর্ড পাওয়া যায়নি।</p>
                <a href="{{ route('complaints.create') }}" class="inline-block mt-3 px-5 py-2.5 rounded-xl bg-amber-500 text-brand-950 font-bold shadow">
                    প্রথম অভিযোগ জমা দিন
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
