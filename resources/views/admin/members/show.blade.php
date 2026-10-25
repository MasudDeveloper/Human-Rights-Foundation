@extends('layouts.admin')

@section('title', 'সদস্য আবেদন যাচাই - #' . $member->id)
@section('page_title', 'সদস্য আবেদন বিস্তারিত ও অনুমোদন')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Top Card -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <span class="text-xs text-slate-400 font-mono">আবেদন আইডি: #{{ $member->id }}</span>
            <h2 class="text-xl font-bold text-slate-900 mt-1">{{ $member->bangla_name }} ({{ $member->english_name }})</h2>
            <p class="text-xs text-blue-700 font-semibold"><i class="fa-solid fa-award mr-1"></i>আবেদনকৃত পদবী: {{ $member->post_name }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            @if(session('admin_role') === 'super_admin')
                @if($member->user_id)
                    <form method="POST" action="{{ route('admin.users.impersonate', $member->user_id) }}">
                        @csrf
                        <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-bold shadow transition flex items-center space-x-1.5" title="সরাসরি এই মেম্বারের প্রোফাইল অ্যাকাউন্টে লগইন করুন">
                            <i class="fa-solid fa-user-secret"></i>
                            <span>মেম্বার অ্যাকাউন্টে প্রবেশ (Login)</span>
                        </button>
                    </form>
                @endif
                <a href="{{ route('admin.members.edit', $member->id) }}" class="px-3.5 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-amber-400 text-xs font-bold shadow transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-user-pen"></i>
                    <span>সম্পাদনা (Edit)</span>
                </a>
            @endif
            @if($member->member_id_card_number)
                <a href="{{ route('member.id_card', $member->id) }}" target="_blank" class="px-3.5 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold shadow transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-id-card text-amber-400"></i>
                    <span>আইডি কার্ড</span>
                </a>
            @endif
            @if($member->status === 'approved')
                <form method="POST" action="{{ route('admin.members.generate_id', $member->id) }}">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold transition flex items-center space-x-1 border border-slate-300">
                        <i class="fa-solid fa-arrows-rotate"></i>
                        <span>আইডি কার্ড রি-জেনারেট</span>
                    </button>
                </form>
            @endif
            <a href="{{ route('member.print', $member->id) }}" target="_blank" class="px-3.5 py-1.5 rounded-xl bg-blue-700 hover:bg-blue-800 text-white text-xs font-bold shadow transition flex items-center space-x-1.5">
                <i class="fa-solid fa-print"></i>
                <span>প্রিন্ট</span>
            </a>
        </div>
    </div>

    <!-- Status Change Action Form -->
    <div class="bg-blue-50/70 p-6 rounded-2xl border border-blue-200">
        <h3 class="text-xs font-bold text-blue-950 uppercase tracking-wider mb-3 flex items-center">
            <i class="fa-solid fa-stamp mr-2"></i>
            <span>সদস্য আবেদনের স্ট্যাটাস পরিবর্তন</span>
        </h3>

        <form method="POST" action="{{ route('admin.members.status', $member->id) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                <div class="sm:col-span-4">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">স্ট্যাটাস নির্বাচন করুন</label>
                    <select name="status" id="memberStatusSelect" required onchange="toggleMemberReject(this.value)"
                        class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs font-semibold">
                        <option value="pending" {{ $member->status == 'pending' ? 'selected' : '' }}>অপেক্ষমান (Pending)</option>
                        <option value="approved" {{ $member->status == 'approved' ? 'selected' : '' }}>অনুমোদিত (Approved)</option>
                        <option value="rejected" {{ $member->status == 'rejected' ? 'selected' : '' }}>বাতিল (Rejected)</option>
                    </select>
                </div>

                <div class="sm:col-span-4">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">কার্ডের পদবী নির্ধারণ</label>
                    <input type="text" name="post_name" value="{{ old('post_name', $member->post_name) }}" placeholder="যেমন: সাধারণ সদস্য / তদন্ত কর্মকর্তা"
                        class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs font-semibold">
                </div>

                <div class="sm:col-span-4">
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs shadow transition">
                        <i class="fa-solid fa-check mr-1.5"></i>স্ট্যাটাস ও তথ্য সংরক্ষণ
                    </button>
                </div>
            </div>

            <!-- Member ID Card Photo Upload -->
            <div class="p-3 bg-white rounded-xl border border-slate-200 flex flex-col sm:flex-row items-center gap-3">
                <div class="w-12 h-14 rounded-lg bg-slate-100 border overflow-hidden flex-shrink-0 flex items-center justify-center">
                    @if($member->effective_photo)
                        <img src="{{ $member->effective_photo }}" alt="Photo" class="w-full h-full object-cover">
                    @else
                        <i class="fa-solid fa-user text-slate-400 text-lg"></i>
                    @endif
                </div>
                <div class="flex-grow">
                    <label class="block text-xs font-bold text-slate-700">সদস্যের ছবি আপলোড / পরিবর্তন (ID Card Photo)</label>
                    <input type="file" name="id_card_photo" accept="image/*" class="w-full text-xs text-slate-600 mt-1 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700">
                </div>
            </div>


            <!-- Reject Reason Box (Visible if rejected) -->
            <div id="memberRejectBox" class="{{ $member->status == 'rejected' ? '' : 'hidden' }} mt-3">
                <label class="block text-xs font-semibold text-rose-800 mb-1">বাতিলের কারণ</label>
                <textarea name="reject_reason" rows="2" placeholder="আবেদন বাতিলের কারণ..."
                    class="w-full px-3 py-2 rounded-xl border border-rose-300 bg-white text-xs text-rose-900">{{ $member->reject_reason }}</textarea>
            </div>
        </form>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider border-b pb-2">ব্যক্তিগত ও যোগাযোগের তথ্য</h3>
            <p><span class="text-slate-400">বাংলা নাম:</span> <strong class="text-slate-900">{{ $member->bangla_name }}</strong></p>
            <p><span class="text-slate-400">ইংরেজি নাম:</span> <span class="font-mono">{{ $member->english_name }}</span></p>
            <p><span class="text-slate-400">পিতা/মাতা:</span> {{ $member->father_name ?: '-' }} / {{ $member->mother_name ?: '-' }}</p>
            <p><span class="text-slate-400">জন্ম তারিখ:</span> {{ $member->date_of_birth }}</p>
            <p><span class="text-slate-400">এনআইডি নম্বর:</span> <strong class="font-mono text-slate-900">{{ $member->nid }}</strong></p>
            <p><span class="text-slate-400">মোবাইল নম্বর:</span> <strong class="font-mono text-brand-900">{{ $member->phone_number }}</strong></p>
            <p><span class="text-slate-400">শিক্ষাগত যোগ্যতা:</span> {{ $member->education }}</p>
            <p><span class="text-slate-400">পেশা:</span> {{ $member->current_job }}</p>
            <p><span class="text-slate-400">রক্তের গ্রুপ:</span> <strong class="text-rose-600">{{ $member->blood_group ?: 'অজানা' }}</strong></p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider border-b pb-2">ঠিকানা ও পেমেন্ট</h3>
            <p><span class="text-slate-400">স্থায়ী ঠিকানা:</span> {{ $member->village }}, {{ $member->post_office }}, {{ $member->thana }}, {{ $member->district }}</p>
            <p><span class="text-slate-400">বর্তমান ঠিকানা:</span> {{ $member->village2 ?: '-' }}, {{ $member->thana2 ?: '-' }}, {{ $member->district2 ?: '-' }}</p>
            <div class="pt-3 border-t space-y-2 bg-blue-50/50 p-3 rounded-xl border border-blue-100">
                <p><span class="text-slate-500">পেমেন্ট গেটওয়ে:</span> <strong>{{ $member->payment_gateway }}</strong></p>
                <p><span class="text-slate-500">প্রেরক নম্বর:</span> <span class="font-mono">{{ $member->payment_number }}</span></p>
                <p><span class="text-slate-500">ট্রানজেকশন আইডি:</span> <span class="bg-white px-2 py-0.5 rounded font-mono font-bold text-blue-900 border">{{ $member->transaction_id }}</span></p>
                <p><span class="text-slate-500">পরিমাণ:</span> <strong class="text-emerald-700">৳{{ $member->payment_amount ?: '250' }}</strong></p>
            </div>
        </div>
    </div>

</div>

<script>
    function toggleMemberReject(val) {
        const box = document.getElementById('memberRejectBox');
        if (val === 'rejected') {
            box.classList.remove('hidden');
        } else {
            box.classList.add('hidden');
        }
    }
</script>
@endsection
