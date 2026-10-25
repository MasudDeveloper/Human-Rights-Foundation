@extends('layouts.admin')

@section('title', 'অভিযোগ পর্যালোচনা - #' . $complaint->id)
@section('page_title', 'অভিযোগ বিস্তারিত ও স্ট্যাটাস ব্যবস্থাপনা')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Top Card & Status Management -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <span class="text-xs text-slate-400 font-mono">অভিযোগ আইডি: #{{ $complaint->id }}</span>
            <h2 class="text-xl font-bold text-slate-900 mt-1">{{ $complaint->name }}</h2>
            <p class="text-xs text-amber-600 font-semibold"><i class="fa-solid fa-tag mr-1"></i>{{ $complaint->complaint_type }}</p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $complaint->status_badge['bg'] }}">
                {{ $complaint->status_badge['label'] }}
            </span>
            <a href="{{ route('complaint.print', $complaint->id) }}" target="_blank" class="px-3.5 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-amber-400 text-xs font-bold shadow transition flex items-center space-x-1.5">
                <i class="fa-solid fa-print"></i>
                <span>অফিসিয়াল কপি প্রিন্ট</span>
            </a>
        </div>
    </div>

    <!-- Status Change Action Form -->
    <div class="bg-amber-50/70 p-6 rounded-2xl border border-amber-200">
        <h3 class="text-xs font-bold text-amber-950 uppercase tracking-wider mb-3 flex items-center">
            <i class="fa-solid fa-sliders mr-2"></i>
            <span>অভিযোগের স্ট্যাটাস পরিবর্তন করুন</span>
        </h3>

        <form method="POST" action="{{ route('admin.complaints.status', $complaint->id) }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                <div class="sm:col-span-5">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">নতুন স্ট্যাটাস নির্বাচন করুন</label>
                    <select name="status" id="statusSelect" required onchange="toggleRejectReason(this.value)"
                        class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs font-semibold">
                        <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>অপেক্ষমান (Pending)</option>
                        <option value="investigated" {{ $complaint->status == 'investigated' ? 'selected' : '' }}>তদন্তাধীন (Under Investigation)</option>
                        <option value="approved" {{ $complaint->status == 'approved' ? 'selected' : '' }}>অনুমোদিত (Approved)</option>
                        <option value="complete" {{ $complaint->status == 'complete' ? 'selected' : '' }}>নিষ্পত্তিকৃত (Complete)</option>
                        <option value="rejected" {{ $complaint->status == 'rejected' ? 'selected' : '' }}>বাতিল (Rejected)</option>
                    </select>
                </div>

                <div class="sm:col-span-4">
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-amber-400 font-bold text-xs shadow transition">
                        <i class="fa-solid fa-check mr-1.5"></i>স্ট্যাটাস আপডেট করুন
                    </button>
                </div>
            </div>

            <!-- Reject Reason Box (Visible if rejected) -->
            <div id="rejectReasonBox" class="{{ $complaint->status == 'rejected' ? '' : 'hidden' }} mt-3">
                <label class="block text-xs font-semibold text-rose-800 mb-1">বাতিলের কারণ লিখুন (ব্যবহারকারী দেখতে পারবেন)</label>
                <textarea name="reject_reason" rows="2" placeholder="যেমন: আপনার পেমেন্ট নম্বর বা TrxID সঠিক নয়..."
                    class="w-full px-3 py-2 rounded-xl border border-rose-300 bg-white text-xs text-rose-900">{{ $complaint->reject_reason }}</textarea>
            </div>
        </form>
    </div>

    <!-- Detailed Inspection Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- 1. Complainant Info -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3 text-xs">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider border-b pb-2">অভিযোগকারীর তথ্য</h3>
            <p><span class="text-slate-400">নাম:</span> <strong class="text-slate-900">{{ $complaint->name }}</strong> (বয়স: {{ $complaint->age }})</p>
            <p><span class="text-slate-400">পিতা/মাতা:</span> {{ $complaint->father_name ?: '-' }} / {{ $complaint->mother_name ?: '-' }}</p>
            <p><span class="text-slate-400">স্বামী/স্ত্রী:</span> {{ $complaint->spouse_name ?: '-' }}</p>
            <p><span class="text-slate-400">ঠিকানা:</span> {{ $complaint->village }}, {{ $complaint->post_office }}, {{ $complaint->thana }}, {{ $complaint->district }}</p>
            <p><span class="text-slate-400">মোবাইল:</span> <strong class="text-brand-900 font-mono">{{ $complaint->phone_number }}</strong></p>
            @if($complaint->user)
                <div class="pt-2 border-t text-[11px] text-slate-500">
                    <span>সংযুক্ত নাগরিক অ্যাকাউন্ট: <a href="{{ route('admin.users.show', $complaint->user->id) }}" class="text-brand-700 font-bold hover:underline">{{ $complaint->user->name }} (ID #{{ $complaint->user->id }})</a></span>
                </div>
            @endif
        </div>

        <!-- 2. Payment Verification -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3 text-xs">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider border-b pb-2">পেমেন্ট বিবরণী</h3>
            <p><span class="text-slate-400">মেথড:</span> <strong class="text-slate-900">{{ $complaint->payment_gateway }}</strong></p>
            <p><span class="text-slate-400">প্রেরক নম্বর:</span> <strong class="font-mono text-slate-800">{{ $complaint->payment_number }}</strong></p>
            <p><span class="text-slate-400">ট্রানজেকশন আইডি:</span> <span class="bg-slate-100 px-2 py-0.5 rounded font-mono font-bold text-brand-900">{{ $complaint->transaction_id }}</span></p>
            <p><span class="text-slate-400">ফি পরিমাণ:</span> <strong class="text-emerald-700">৳{{ $complaint->payment_amount ?: '250' }}</strong></p>
            <p><span class="text-slate-400">জমার সময়:</span> {{ $complaint->created_at ? $complaint->created_at->format('d/m/Y h:i A') : $complaint->time }}</p>
            @if($complaint->pdf_url)
                <p><span class="text-slate-400">সংযুক্ত ফাইল:</span> <a href="{{ asset($complaint->pdf_url) }}" target="_blank" class="text-blue-600 font-bold hover:underline">ডাউনলোড ফাইল</a></p>
            @endif
        </div>
    </div>

    <!-- Event details -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-xs">
        <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider border-b pb-2 mb-3">ঘটনার বিস্তারিত বিবরণ</h3>
        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-slate-700 leading-relaxed text-xs sm:text-sm">
            {{ $complaint->details ?: 'কোনো বিবরণ প্রদান করা হয়নি।' }}
        </div>
    </div>

    <!-- Accused Persons Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden text-xs">
        <div class="p-4 bg-slate-50 border-b border-slate-100 font-bold text-slate-800">
            অভিযুক্ত ব্যক্তি বা আসামির তালিকা ({{ $complaint->accuseds->count() }} জন)
        </div>
        @if($complaint->accuseds->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-100 text-slate-600 border-b">
                        <tr>
                            <th class="p-3 pl-4">নং</th>
                            <th class="p-3">নাম</th>
                            <th class="p-3">বয়স</th>
                            <th class="p-3">পিতার নাম</th>
                            <th class="p-3">ঠিকানা</th>
                            <th class="p-3">ফোন</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($complaint->accuseds as $i => $acc)
                            <tr>
                                <td class="p-3 pl-4 font-mono">{{ $i + 1 }}</td>
                                <td class="p-3 font-bold text-slate-900">{{ $acc->name }}</td>
                                <td class="p-3">{{ $acc->age ? $acc->age . ' বছর' : '-' }}</td>
                                <td class="p-3">{{ $acc->father_name ?: '-' }}</td>
                                <td class="p-3">{{ $acc->address }}</td>
                                <td class="p-3 font-mono">{{ $acc->phone ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="p-4 text-slate-400">নির্দিষ্ট আসামির নাম উল্লেখ করা হয়নি।</p>
        @endif
    </div>

    <!-- Witnesses Table -->
    @if($complaint->witnesses->count() > 0)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden text-xs">
            <div class="p-4 bg-slate-50 border-b border-slate-100 font-bold text-slate-800">
                সাক্ষীদের তালিকা
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-100 text-slate-600 border-b">
                        <tr>
                            <th class="p-3 pl-4">নং</th>
                            <th class="p-3">নাম</th>
                            <th class="p-3">পিতার নাম</th>
                            <th class="p-3">ঠিকানা</th>
                            <th class="p-3">ফোন</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($complaint->witnesses as $i => $w)
                            <tr>
                                <td class="p-3 pl-4 font-mono">{{ $i + 1 }}</td>
                                <td class="p-3 font-bold">{{ $w->name }}</td>
                                <td class="p-3">{{ $w->father_name ?: '-' }}</td>
                                <td class="p-3">{{ $w->address ?: '-' }}</td>
                                <td class="p-3 font-mono">{{ $w->phone_number ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>

<script>
    function toggleRejectReason(val) {
        const box = document.getElementById('rejectReasonBox');
        if (val === 'rejected') {
            box.classList.remove('hidden');
        } else {
            box.classList.add('hidden');
        }
    }
</script>
@endsection
