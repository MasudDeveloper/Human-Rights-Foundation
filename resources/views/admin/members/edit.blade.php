@extends('layouts.admin')

@section('title', 'সদস্য তথ্য ও আইডি কার্ড সম্পাদনা - #' . $member->id)
@section('page_title', 'সদস্য প্রোফাইল, ছবি ও NID সম্পাদনা')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Card -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <span class="text-xs font-bold text-amber-600 uppercase tracking-wider flex items-center">
                <i class="fa-solid fa-user-pen mr-1.5"></i>অ্যাডমিন নিয়ন্ত্রণ
            </span>
            <h2 class="text-xl font-bold text-slate-900 mt-1">সদস্য প্রোফাইল, ছবি ও NID সম্পাদনা</h2>
            <p class="text-xs text-slate-500 mt-0.5">সদস্যের ছবি, জাতীয় পরিচয়পত্র (NID), ব্যক্তিগত তথ্য ও কার্ড নম্বর যেকোনো সময় আপডেট করতে পারেন</p>
        </div>
        <div class="flex items-center space-x-2">
            @if($member->member_id_card_number)
                <a href="{{ route('member.id_card', $member->id) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold transition flex items-center space-x-1.5 shadow">
                    <i class="fa-solid fa-id-card"></i>
                    <span>কার্ড প্রিভিউ</span>
                </a>
            @endif
            <a href="{{ route('admin.members.show', $member->id) }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center space-x-1">
                <i class="fa-solid fa-arrow-left mr-1"></i>ফিরে যান
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <form method="POST" action="{{ route('admin.members.update', $member->id) }}" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6 text-xs">
        @csrf

        <!-- Section 1: ID Card & Status Settings -->
        <div class="p-5 rounded-2xl bg-amber-50/50 border border-amber-200 space-y-4">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center">
                <i class="fa-solid fa-id-card text-amber-600 mr-2 text-sm"></i>
                আইডি কার্ড ও আবেদন স্ট্যাটাস
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">আইডি কার্ড নম্বর <span class="text-rose-500">*</span></label>
                    <input type="text" name="member_id_card_number" value="{{ old('member_id_card_number', $member->member_id_card_number) }}"
                        placeholder="যেমন: 00001"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono font-bold text-slate-900 bg-white">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">কার্ডের পদবী (Designation) <span class="text-rose-500">*</span></label>
                    <input type="text" name="post_name" value="{{ old('post_name', $member->post_name) }}" required
                        placeholder="যেমন: Chairman / Secretary General"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold text-blue-900 bg-white">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">আবেদন স্ট্যাটাস</label>
                    <select name="status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white font-semibold">
                        <option value="pending" {{ $member->status == 'pending' ? 'selected' : '' }}>পেন্ডিং (Pending)</option>
                        <option value="approved" {{ $member->status == 'approved' ? 'selected' : '' }}>অনুমোদিত (Approved)</option>
                        <option value="rejected" {{ $member->status == 'rejected' ? 'selected' : '' }}>বাতিল (Rejected)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">আইডি কার্ড স্ট্যাটাস</label>
                    <select name="id_card_status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white font-semibold">
                        <option value="generated" {{ $member->id_card_status == 'generated' ? 'selected' : '' }}>জেনারেট হয়েছে (Generated)</option>
                        <option value="not_generated" {{ $member->id_card_status == 'not_generated' ? 'selected' : '' }}>জেনারেট হয়নি (Not Generated)</option>
                        <option value="expired" {{ $member->id_card_status == 'expired' ? 'selected' : '' }}>মেয়াদোত্তীর্ণ (Expired)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">ইস্যু তারিখ (Issue Date)</label>
                    <input type="date" name="id_card_issue_date" value="{{ old('id_card_issue_date', $member->id_card_issue_date) }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white font-mono">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">মেয়াদ উত্তীর্ণ তারিখ (Expiry Date)</label>
                    <input type="date" name="id_card_expiry_date" value="{{ old('id_card_expiry_date', $member->id_card_expiry_date) }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white font-mono">
                </div>
            </div>

            <!-- Member Photo & NID Documents Upload Cards -->
            <div class="space-y-2 pt-2">
                <label class="block font-bold text-slate-800 text-xs uppercase tracking-wider flex items-center">
                    <i class="fa-solid fa-camera text-purple-600 mr-1.5"></i>
                    সদস্যের ছবি ও জাতীয় পরিচয়পত্র (NID) ডকুমেন্টস পরিবর্তন
                </label>
                <p class="text-[11px] text-slate-500">নতুন ছবি বা NID আপলোড করলে সংশ্লিষ্ট নাগরিক অ্যাকাউন্টে এবং আইডি কার্ডে স্বয়ংক্রিয়ভাবে আপডেট হবে। কোনো ছবি পরিবর্তন করতে না চাইলে খালি রাখুন।</p>

                @php
                    $nidFront = $member->nid_front_image ?: ($member->user->nid_front_image ?? null);
                    $nidBack = $member->nid_back_image ?: ($member->user->nid_back_image ?? null);
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                    <!-- Profile Photo Card -->
                    <div class="p-4 bg-white rounded-2xl border border-amber-200 flex flex-col items-center text-center shadow-xs">
                        <div class="w-20 h-24 rounded-xl bg-slate-100 border-2 border-amber-300 overflow-hidden mb-2.5 flex items-center justify-center relative shadow-inner">
                            <img id="previewMemberPhoto" src="{{ $member->effective_photo ? asset($member->effective_photo) : '' }}" class="{{ $member->effective_photo ? '' : 'hidden' }} w-full h-full object-cover">
                            <i id="iconMemberPhoto" class="fa-solid fa-user text-slate-400 text-2xl {{ $member->effective_photo ? 'hidden' : '' }}"></i>
                            @if($member->effective_photo)
                                <a href="{{ asset($member->effective_photo) }}" target="_blank" title="বড় আকারে দেখুন" class="absolute bottom-1 right-1 bg-slate-900/80 text-white text-[9px] px-1.5 py-0.5 rounded font-mono hover:bg-slate-900">
                                    <i class="fa-solid fa-up-right-from-square"></i>
                                </a>
                            @endif
                        </div>
                        <span class="block font-bold text-slate-800 text-xs">পাসপোর্ট সাইজ ছবি</span>
                        <span class="block text-[10px] text-slate-400 mb-2">ID Card Profile Photo</span>
                        <input type="file" name="id_card_photo" id="inputMemberPhoto" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-amber-400 file:text-slate-950 file:cursor-pointer cursor-pointer" onchange="previewAdminImg(this, 'previewMemberPhoto', 'iconMemberPhoto')">
                    </div>

                    <!-- NID Front Card -->
                    <div class="p-4 bg-white rounded-2xl border border-indigo-200 flex flex-col items-center text-center shadow-xs">
                        <div class="w-28 h-20 rounded-xl bg-indigo-50 border-2 border-indigo-200 overflow-hidden mb-2.5 flex items-center justify-center relative shadow-inner">
                            <img id="previewNidFront" src="{{ $nidFront ? asset($nidFront) : '' }}" class="{{ $nidFront ? '' : 'hidden' }} w-full h-full object-cover">
                            <i id="iconNidFront" class="fa-solid fa-id-card text-indigo-300 text-2xl {{ $nidFront ? 'hidden' : '' }}"></i>
                            @if($nidFront)
                                <a href="{{ asset($nidFront) }}" target="_blank" title="বড় আকারে দেখুন" class="absolute bottom-1 right-1 bg-slate-900/80 text-white text-[9px] px-1.5 py-0.5 rounded font-mono hover:bg-slate-900">
                                    <i class="fa-solid fa-up-right-from-square"></i>
                                </a>
                            @endif
                        </div>
                        <span class="block font-bold text-slate-800 text-xs">NID সামনের পাতা</span>
                        <span class="block text-[10px] text-slate-400 mb-2">National ID Front</span>
                        <input type="file" name="nid_front_image" id="inputNidFront" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-indigo-500 file:text-white file:cursor-pointer cursor-pointer" onchange="previewAdminImg(this, 'previewNidFront', 'iconNidFront')">
                    </div>

                    <!-- NID Back Card -->
                    <div class="p-4 bg-white rounded-2xl border border-purple-200 flex flex-col items-center text-center shadow-xs">
                        <div class="w-28 h-20 rounded-xl bg-purple-50 border-2 border-purple-200 overflow-hidden mb-2.5 flex items-center justify-center relative shadow-inner">
                            <img id="previewNidBack" src="{{ $nidBack ? asset($nidBack) : '' }}" class="{{ $nidBack ? '' : 'hidden' }} w-full h-full object-cover">
                            <i id="iconNidBack" class="fa-solid fa-id-card text-purple-300 text-2xl {{ $nidBack ? 'hidden' : '' }}"></i>
                            @if($nidBack)
                                <a href="{{ asset($nidBack) }}" target="_blank" title="বড় আকারে দেখুন" class="absolute bottom-1 right-1 bg-slate-900/80 text-white text-[9px] px-1.5 py-0.5 rounded font-mono hover:bg-slate-900">
                                    <i class="fa-solid fa-up-right-from-square"></i>
                                </a>
                            @endif
                        </div>
                        <span class="block font-bold text-slate-800 text-xs">NID পিছনের পাতা</span>
                        <span class="block text-[10px] text-slate-400 mb-2">National ID Back</span>
                        <input type="file" name="nid_back_image" id="inputNidBack" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-purple-500 file:text-white file:cursor-pointer cursor-pointer" onchange="previewAdminImg(this, 'previewNidBack', 'iconNidBack')">
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Personal Information -->
        <div class="space-y-4">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center border-b pb-2">
                <i class="fa-solid fa-user text-blue-700 mr-2 text-sm"></i>
                ব্যক্তিগত তথ্যাবলী
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">ইংরেজি নাম (English Name) <span class="text-rose-500">*</span></label>
                    <input type="text" name="english_name" value="{{ old('english_name', $member->english_name) }}" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold text-slate-900 uppercase font-mono">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">বাংলা নাম (Bangla Name) <span class="text-rose-500">*</span></label>
                    <input type="text" name="bangla_name" value="{{ old('bangla_name', $member->bangla_name) }}" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold text-slate-900">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">মোবাইল নম্বর <span class="text-rose-500">*</span></label>
                    <input type="text" name="phone_number" value="{{ old('phone_number', $member->phone_number) }}" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono font-bold text-blue-900">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">জাতীয় পরিচয়পত্র (NID) <span class="text-rose-500">*</span></label>
                    <input type="text" name="nid" value="{{ old('nid', $member->nid) }}" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono font-bold text-slate-900">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">রক্তের গ্রুপ (Blood Group)</label>
                    <select name="blood_group" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white font-bold text-rose-600">
                        <option value="">নির্বাচন করুন</option>
                        @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg)
                            <option value="{{ $bg }}" {{ (strtoupper(trim($member->blood_group)) == $bg) ? 'selected' : '' }}>{{ $bg }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">ইমেইল ঠিকানা</label>
                    <input type="email" name="email" value="{{ old('email', $member->email) }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">জন্ম তারিখ</label>
                    <input type="text" name="date_of_birth" value="{{ old('date_of_birth', $member->date_of_birth) }}" placeholder="YYYY-MM-DD বা DD/MM/YYYY"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">পেশা / পদবী</label>
                    <input type="text" name="current_job" value="{{ old('current_job', $member->current_job) }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">পিতার নাম</label>
                    <input type="text" name="father_name" value="{{ old('father_name', $member->father_name) }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">মাতার নাম</label>
                    <input type="text" name="mother_name" value="{{ old('mother_name', $member->mother_name) }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">শিক্ষাগত যোগ্যতা</label>
                    <input type="text" name="education" value="{{ old('education', $member->education) }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">ধর্ম</label>
                    <input type="text" name="religion" value="{{ old('religion', $member->religion) }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">বৈবাহিক অবস্থা</label>
                    <input type="text" name="marital_status" value="{{ old('marital_status', $member->marital_status) }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                </div>
            </div>
        </div>

        <!-- Section 3: Address Information -->
        <div class="space-y-4">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center border-b pb-2">
                <i class="fa-solid fa-location-dot text-emerald-600 mr-2 text-sm"></i>
                ঠিকানা সংক্রান্ত তথ্য
            </h3>

            <!-- Permanent Address -->
            <div>
                <span class="font-bold text-slate-800 text-[11px] block mb-2 text-blue-900">স্থায়ী ঠিকানা:</span>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-slate-500 mb-1">গ্রাম / বাড়ি / রোড</label>
                        <input type="text" name="village" value="{{ old('village', $member->village) }}"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300">
                    </div>
                    <div>
                        <label class="block text-slate-500 mb-1">ডাকঘর</label>
                        <input type="text" name="post_office" value="{{ old('post_office', $member->post_office) }}"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300">
                    </div>
                    <div>
                        <label class="block text-slate-500 mb-1">থানা / উপজেলা</label>
                        <input type="text" name="thana" value="{{ old('thana', $member->thana) }}"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300">
                    </div>
                    <div>
                        <label class="block text-slate-500 mb-1">জেলা</label>
                        <input type="text" name="district" value="{{ old('district', $member->district) }}"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300">
                    </div>
                </div>
            </div>

            <!-- Present Address -->
            <div class="pt-2">
                <span class="font-bold text-slate-800 text-[11px] block mb-2 text-slate-700">বর্তমান ঠিকানা:</span>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-slate-500 mb-1">গ্রাম / এলাকা</label>
                        <input type="text" name="village2" value="{{ old('village2', $member->village2) }}"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300">
                    </div>
                    <div>
                        <label class="block text-slate-500 mb-1">ডাকঘর</label>
                        <input type="text" name="post_office2" value="{{ old('post_office2', $member->post_office2) }}"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300">
                    </div>
                    <div>
                        <label class="block text-slate-500 mb-1">থানা / উপজেলা</label>
                        <input type="text" name="thana2" value="{{ old('thana2', $member->thana2) }}"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300">
                    </div>
                    <div>
                        <label class="block text-slate-500 mb-1">জেলা</label>
                        <input type="text" name="district2" value="{{ old('district2', $member->district2) }}"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300">
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="pt-6 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-4">
            <span class="text-[11px] text-slate-400">
                <i class="fa-solid fa-circle-check text-emerald-500 mr-1"></i>তথ্য সংরক্ষণ করলে সংশ্লিষ্ট নাগরিক অ্যাকাউন্ট ও আইডি কার্ডে স্বয়ংক্রিয়ভাবে আপডেট হবে।
            </span>

            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.members.show', $member->id) }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition">
                    বাতিল
                </a>
                <button type="submit" class="px-7 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-extrabold shadow-lg transition flex items-center space-x-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>সদস্য তথ্য আপডেট করুন</span>
                </button>
            </div>
        </div>

    </form>

</div>

<script>
    function previewAdminImg(input, imgId, iconId) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(imgId);
                const icon = document.getElementById(iconId);
                if (img) {
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                }
                if (icon) {
                    icon.classList.add('hidden');
                }
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
