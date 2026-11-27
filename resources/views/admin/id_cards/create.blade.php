@extends('layouts.admin')

@section('title', 'নতুন আইডি কার্ড জেনারেটর - অ্যাডমিন')
@section('page_title', 'তথ্য ও ছবি দিয়ে সরাসরি আইডি কার্ড তৈরি')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Top Action Links -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.id_cards') }}" class="inline-flex items-center space-x-2 text-xs font-bold text-slate-600 hover:text-slate-900 bg-white px-3.5 py-2 rounded-xl border border-slate-200 transition shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>সকল আইডি কার্ড তালিকায় ফিরুন</span>
        </a>

        @if(session('admin_role') === 'super_admin')
            <a href="{{ route('admin.settings.id_card') }}" class="inline-flex items-center space-x-1.5 text-xs font-bold text-amber-700 hover:text-amber-900 bg-amber-50 hover:bg-amber-100 px-3 py-2 rounded-xl border border-amber-200 transition">
                <i class="fa-solid fa-sliders"></i>
                <span>কার্ড সেটিংস ও স্বাক্ষর</span>
            </a>
        @endif
    </div>

    <!-- Header Description Card -->
    <div class="bg-gradient-to-r from-slate-900 to-indigo-950 text-white p-5 sm:p-6 rounded-2xl shadow-lg border border-slate-800 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <span class="text-xs font-bold text-amber-400 uppercase tracking-wider flex items-center">
                <i class="fa-solid fa-wand-magic-sparkles mr-1.5"></i>সরাসরি আইডি কার্ড প্রস্তুতকারক
            </span>
            <h2 class="text-lg sm:text-xl font-bold text-white mt-1">তথ্য ও ছবি প্রদান করে ডিজিটাল আইডি কার্ড জেনারেট করুন</h2>
            <p class="text-xs text-slate-300 mt-1">সদস্যের নাম, পদবী ও ছবি আপলোড করে সাবমিট করলেই তাৎক্ষণিক প্রিন্ট-উপযোগী CR80 পিভিসি আইডি কার্ড তৈরি হয়ে যাবে।</p>
        </div>
        <div class="flex-shrink-0">
            <span class="inline-flex items-center px-3 py-1.5 rounded-xl bg-amber-500/20 text-amber-300 text-xs font-bold border border-amber-500/30">
                <i class="fa-solid fa-bolt mr-1.5"></i>তাৎক্ষণিক প্রিন্ট ভিউ
            </span>
        </div>
    </div>

    <!-- Optional: Existing Member Auto-fill Selector -->
    <div class="bg-amber-50/60 p-4 rounded-2xl border border-amber-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
        <div class="flex items-center space-x-2 text-slate-800">
            <i class="fa-solid fa-user-check text-amber-600 text-base"></i>
            <div>
                <span class="font-bold">বিদ্যমান সদস্য তালিকা থেকে ডাটা আনুন (ঐচ্ছিক):</span>
                <p class="text-[11px] text-slate-500">কোনো নিবন্ধিত সদস্যের তথ্য দিয়ে অটো-ফিল করতে চাইলে নির্বাচন করুন</p>
            </div>
        </div>
        <div class="w-full sm:w-72">
            <select id="existingMemberSelect" class="w-full px-3 py-2 rounded-xl border border-amber-300 bg-white font-medium text-xs focus:ring-2 focus:ring-amber-500" onchange="autoFillMemberData(this.value)">
                <option value="">-- নতুন তথ্য দিয়ে শুরু করুন --</option>
                @foreach($members as $m)
                    <option value="{{ $m->id }}" 
                            data-bangla="{{ $m->bangla_name }}"
                            data-english="{{ $m->english_name }}"
                            data-post="{{ $m->post_name }}"
                            data-phone="{{ $m->phone_number }}"
                            data-blood="{{ $m->blood_group }}"
                            data-nid="{{ $m->nid }}"
                            data-dob="{{ $m->date_of_birth }}"
                            data-photo="{{ $m->effective_photo }}"
                            data-cardno="{{ $m->member_id_card_number }}"
                            data-village="{{ $m->village }}"
                            data-postoffice="{{ $m->post_office }}"
                            data-thana="{{ $m->thana }}"
                            data-district="{{ $m->district }}"
                            {{ (isset($selectedMember) && $selectedMember->id == $m->id) ? 'selected' : '' }}>
                        {{ $m->english_name ?: $m->bangla_name }} ({{ $m->post_name ?: 'সদস্য' }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Generator Form Grid -->
    <form id="idCardForm" method="POST" action="{{ route('admin.id_cards.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <input type="hidden" name="existing_member_id" id="existing_member_id" value="{{ $selectedMember->id ?? '' }}">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Column: Photo Upload & Live Card Preview Box -->
            <div class="lg:col-span-1 space-y-5">
                
                <!-- Photo Upload Box -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center">
                    <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-2">
                        আইডি কার্ডের ছবি <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-[11px] text-slate-400 mb-4">কার্ডের ফ্রন্ট ফ্রেমে প্রদর্শিত হবে</p>

                    <!-- Circular Photo Frame (Mirroring the CR80 card) -->
                    <div class="relative w-36 h-36 mx-auto rounded-full bg-slate-100 border-4 border-amber-400 overflow-hidden shadow-md flex items-center justify-center cursor-pointer group" onclick="document.getElementById('photoInput').click()">
                        <img id="photoPreview" src="{{ (isset($selectedMember) && $selectedMember->effective_photo) ? asset($selectedMember->effective_photo) : '' }}" class="{{ (isset($selectedMember) && $selectedMember->effective_photo) ? '' : 'hidden' }} w-full h-full object-cover">
                        <div id="photoPlaceholder" class="{{ (isset($selectedMember) && $selectedMember->effective_photo) ? 'hidden' : '' }} flex flex-col items-center justify-center text-slate-400 group-hover:text-amber-500 transition">
                            <i class="fa-solid fa-camera text-3xl mb-1"></i>
                            <span class="text-[10px] font-bold uppercase tracking-wider">ছবি সিলেক্ট</span>
                        </div>
                        <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-bold">
                            <i class="fa-solid fa-pen-to-square mr-1"></i>পরিবর্তন
                        </div>
                    </div>

                    <div class="mt-3">
                        <input type="file" 
                               name="photo" 
                               id="photoInput" 
                               accept="image/*" 
                               class="hidden" 
                               onchange="processCardPhoto(this)">
                        <button type="button" onclick="document.getElementById('photoInput').click()" class="mt-2 px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition inline-flex items-center space-x-1.5">
                            <i class="fa-solid fa-cloud-arrow-up text-amber-500"></i>
                            <span>ছবি নির্বাচন করুন</span>
                        </button>
                        <div id="photoStatus" class="mt-2 text-[11px]"></div>
                    </div>
                    @error('photo')
                        <p class="text-xs text-rose-500 mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mini Live Preview Card -->
                <div class="bg-gradient-to-b from-slate-900 to-slate-950 text-white p-5 rounded-2xl border border-slate-800 shadow-md">
                    <span class="text-[10px] font-bold text-amber-400 uppercase tracking-widest block mb-2">লাইভ ডাটা রিপ্রেজেন্টেশন</span>
                    
                    <div class="space-y-2 text-xs border-t border-slate-800 pt-3">
                        <div class="flex justify-between">
                            <span class="text-slate-400">কার্ড নম্বর:</span>
                            <span class="font-mono font-bold text-amber-300" id="liveCardNo">{{ $selectedMember->member_id_card_number ?? $suggestedCardNumber }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">নাম:</span>
                            <span class="font-bold text-white uppercase text-right truncate max-w-[150px]" id="liveName">{{ $selectedMember->english_name ?? 'MEMBER NAME' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">পদবী:</span>
                            <span class="font-semibold text-slate-200" id="livePost">{{ $selectedMember->post_name ?? 'Chairman' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">মোবাইল:</span>
                            <span class="font-mono text-slate-300" id="livePhone">{{ $selectedMember->phone_number ?? '01XXXXXXXXX' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">রক্তের গ্রুপ:</span>
                            <span class="font-bold text-rose-400" id="liveBlood">{{ $selectedMember->blood_group ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Card Information Form Fields -->
            <div class="lg:col-span-2 space-y-5">
                
                <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200 shadow-sm space-y-5 text-xs">
                    
                    <!-- Section: Card Number & Designation -->
                    <div class="p-4 rounded-xl bg-amber-50/50 border border-amber-200/80 space-y-4">
                        <h3 class="text-xs font-bold text-amber-950 uppercase tracking-wider flex items-center">
                            <i class="fa-solid fa-id-badge text-amber-600 mr-2 text-sm"></i>
                            কার্ড নম্বর ও পদবী কনফিগারেশন
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Card Number -->
                            <div>
                                <label for="member_id_card_number" class="block font-bold text-slate-800 mb-1">
                                    আইডি কার্ড নম্বর <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" 
                                       name="member_id_card_number" 
                                       id="member_id_card_number" 
                                       value="{{ old('member_id_card_number', $selectedMember->member_id_card_number ?? $suggestedCardNumber) }}" 
                                       required
                                       placeholder="যেমন: 00001 বা HRF-00001" 
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white font-mono font-bold text-slate-900 focus:ring-2 focus:ring-amber-500"
                                       oninput="document.getElementById('liveCardNo').textContent = this.value || 'N/A'">
                                <span class="text-[10px] text-slate-400 mt-1 block">স্বয়ংক্রিয়ভাবে পরবর্তী ক্রম দেওয়া হয়েছে, চাইলে কাস্টম লিখতে পারেন।</span>
                            </div>

                            <!-- Designation (Post Name) -->
                            <div>
                                <label for="post_name" class="block font-bold text-slate-800 mb-1">
                                    কার্ডের পদবী (Designation) <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" 
                                       name="post_name" 
                                       id="post_name" 
                                       list="postSuggestions"
                                       value="{{ old('post_name', $selectedMember->post_name ?? 'Chairman') }}" 
                                       required 
                                       placeholder="যেমন: Chairman / Secretary General" 
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white font-bold text-blue-900 focus:ring-2 focus:ring-amber-500"
                                       oninput="document.getElementById('livePost').textContent = this.value || 'N/A'">
                                <datalist id="postSuggestions">
                                    @foreach($posts as $p)
                                        <option value="{{ $p }}">
                                    @endforeach
                                </datalist>
                                <span class="text-[10px] text-slate-400 mt-1 block">ড্রপডাউন থেকে সিলেক্ট করতে পারেন বা সরাসরি টাইপ করুন।</span>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Names & Phone -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- English Name -->
                        <div>
                            <label for="english_name" class="block font-bold text-slate-700 mb-1">
                                নাম (ইংরেজিতে - কার্ডে বড় অক্ষরে প্রদর্শিত হবে) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" 
                                   name="english_name" 
                                   id="english_name" 
                                   value="{{ old('english_name', $selectedMember->english_name ?? '') }}" 
                                   required 
                                   placeholder="FULL NAME IN ENGLISH" 
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold text-slate-900 uppercase font-mono focus:ring-2 focus:ring-amber-500"
                                   oninput="document.getElementById('liveName').textContent = this.value ? this.value.toUpperCase() : 'MEMBER NAME'">
                        </div>

                        <!-- Bangla Name -->
                        <div>
                            <label for="bangla_name" class="block font-bold text-slate-700 mb-1">
                                নাম (বাংলায়)
                            </label>
                            <input type="text" 
                                   name="bangla_name" 
                                   id="bangla_name" 
                                   value="{{ old('bangla_name', $selectedMember->bangla_name ?? '') }}" 
                                   placeholder="বাংলায় পূর্ণ নাম" 
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold text-slate-800 focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>

                    <!-- Section: Phone, Blood Group, NID -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Phone Number -->
                        <div>
                            <label for="phone_number" class="block font-bold text-slate-700 mb-1">
                                মোবাইল নম্বর <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" 
                                   name="phone_number" 
                                   id="phone_number" 
                                   value="{{ old('phone_number', $selectedMember->phone_number ?? '') }}" 
                                   required 
                                   placeholder="01XXXXXXXXX" 
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono font-bold text-blue-900 focus:ring-2 focus:ring-amber-500"
                                   oninput="document.getElementById('livePhone').textContent = this.value || 'N/A'">
                        </div>

                        <!-- Blood Group -->
                        <div>
                            <label for="blood_group" class="block font-bold text-slate-700 mb-1">
                                রক্তের গ্রুপ (Blood Group)
                            </label>
                            <select name="blood_group" 
                                    id="blood_group" 
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white font-bold text-rose-600 focus:ring-2 focus:ring-amber-500"
                                    onchange="document.getElementById('liveBlood').textContent = this.value || 'N/A'">
                                <option value="">নির্বাচন করুন</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg)
                                    <option value="{{ $bg }}" {{ (old('blood_group', $selectedMember->blood_group ?? '') == $bg) ? 'selected' : '' }}>
                                        {{ $bg }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- NID Number -->
                        <div>
                            <label for="nid" class="block font-bold text-slate-700 mb-1">
                                জাতীয় পরিচয়পত্র (NID)
                            </label>
                            <input type="text" 
                                   name="nid" 
                                   id="nid" 
                                   value="{{ old('nid', $selectedMember->nid ?? '') }}" 
                                   placeholder="জাতীয় পরিচয়পত্র নম্বর" 
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono text-slate-800 focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>

                    <!-- Section: Dates -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Date of Birth -->
                        <div>
                            <label for="date_of_birth" class="block font-bold text-slate-700 mb-1">
                                জন্ম তারিখ
                            </label>
                            <input type="date" 
                                   name="date_of_birth" 
                                   id="date_of_birth" 
                                   value="{{ old('date_of_birth', $selectedMember->date_of_birth ?? '') }}" 
                                   class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white font-mono">
                        </div>

                        <!-- Issue Date -->
                        <div>
                            <label for="id_card_issue_date" class="block font-bold text-slate-700 mb-1">
                                ইস্যুর তারিখ (Issue Date)
                            </label>
                            <input type="date" 
                                   name="id_card_issue_date" 
                                   id="id_card_issue_date" 
                                   value="{{ old('id_card_issue_date', $selectedMember->id_card_issue_date ?? now()->format('Y-m-d')) }}" 
                                   class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white font-mono">
                        </div>

                        <!-- Expiry Date -->
                        <div>
                            <label for="id_card_expiry_date" class="block font-bold text-slate-700 mb-1">
                                মেয়াদ উত্তীর্ণ (Expiry Date)
                            </label>
                            @php
                                $validity = (int) \App\Models\Setting::get('id_card_validity_years', 2);
                                $defExpiry = now()->addYears($validity)->format('Y-m-d');
                            @endphp
                            <input type="date" 
                                   name="id_card_expiry_date" 
                                   id="id_card_expiry_date" 
                                   value="{{ old('id_card_expiry_date', $selectedMember->id_card_expiry_date ?? $defExpiry) }}" 
                                   class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white font-mono">
                        </div>
                    </div>

                    <!-- Section: Address (Optional details) -->
                    <div class="pt-3 border-t border-slate-100">
                        <span class="font-bold text-slate-800 text-[11px] block mb-2">সদস্যের ঠিকানা (ঐচ্ছিক):</span>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <div>
                                <label class="block text-slate-500 mb-1 text-[11px]">গ্রাম / এলাকা</label>
                                <input type="text" name="village" id="village" value="{{ old('village', $selectedMember->village ?? '') }}" placeholder="গ্রাম" class="w-full px-3 py-2 rounded-xl border border-slate-300">
                            </div>
                            <div>
                                <label class="block text-slate-500 mb-1 text-[11px]">ডাকঘর</label>
                                <input type="text" name="post_office" id="post_office" value="{{ old('post_office', $selectedMember->post_office ?? '') }}" placeholder="ডাকঘর" class="w-full px-3 py-2 rounded-xl border border-slate-300">
                            </div>
                            <div>
                                <label class="block text-slate-500 mb-1 text-[11px]">থানা / উপজেলা</label>
                                <input type="text" name="thana" id="thana" value="{{ old('thana', $selectedMember->thana ?? '') }}" placeholder="থানা" class="w-full px-3 py-2 rounded-xl border border-slate-300">
                            </div>
                            <div>
                                <label class="block text-slate-500 mb-1 text-[11px]">জেলা</label>
                                <input type="text" name="district" id="district" value="{{ old('district', $selectedMember->district ?? 'ঢাকা') }}" placeholder="জেলা" class="w-full px-3 py-2 rounded-xl border border-slate-300">
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button Area -->
                    <div class="pt-5 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <span class="text-[11px] text-slate-500 flex items-center">
                            <i class="fa-solid fa-circle-check text-emerald-500 mr-1.5"></i>
                            সাবমিট করার সাথে সাথে সম্পূর্ণ আইডি কার্ড ভিউ এবং প্রিন্ট বাটন প্রদর্শিত হবে।
                        </span>

                        <div class="flex items-center space-x-3 w-full sm:w-auto">
                            <a href="{{ route('admin.id_cards') }}" class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 font-bold transition text-center">
                                বাতিল
                            </a>
                            <button type="submit" id="submitCardBtn" class="w-full sm:w-auto px-7 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black shadow-lg transition flex items-center justify-center space-x-2">
                                <i class="fa-solid fa-wand-magic-sparkles" id="submitCardIcon"></i>
                                <span id="submitCardText">আইডি কার্ড জেনারেট করুন</span>
                            </button>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </form>

</div>
@endsection

@section('scripts')
<script>
    // Live Auto-fill from Existing Registered Member dropdown
    function autoFillMemberData(memberId) {
        if (!memberId) {
            document.getElementById('existing_member_id').value = '';
            return;
        }

        const select = document.getElementById('existingMemberSelect');
        const option = select.options[select.selectedIndex];
        if (!option) return;

        document.getElementById('existing_member_id').value = memberId;
        
        if (option.dataset.bangla) document.getElementById('bangla_name').value = option.dataset.bangla;
        if (option.dataset.english) {
            document.getElementById('english_name').value = option.dataset.english;
            document.getElementById('liveName').textContent = option.dataset.english.toUpperCase();
        }
        if (option.dataset.post) {
            document.getElementById('post_name').value = option.dataset.post;
            document.getElementById('livePost').textContent = option.dataset.post;
        }
        if (option.dataset.phone) {
            document.getElementById('phone_number').value = option.dataset.phone;
            document.getElementById('livePhone').textContent = option.dataset.phone;
        }
        if (option.dataset.blood) {
            document.getElementById('blood_group').value = option.dataset.blood;
            document.getElementById('liveBlood').textContent = option.dataset.blood;
        }
        if (option.dataset.nid) document.getElementById('nid').value = option.dataset.nid;
        if (option.dataset.dob) document.getElementById('date_of_birth').value = option.dataset.dob;
        if (option.dataset.cardno) {
            document.getElementById('member_id_card_number').value = option.dataset.cardno;
            document.getElementById('liveCardNo').textContent = option.dataset.cardno;
        }
        if (option.dataset.village) document.getElementById('village').value = option.dataset.village;
        if (option.dataset.postoffice) document.getElementById('post_office').value = option.dataset.postoffice;
        if (option.dataset.thana) document.getElementById('thana').value = option.dataset.thana;
        if (option.dataset.district) document.getElementById('district').value = option.dataset.district;

        if (option.dataset.photo) {
            const preview = document.getElementById('photoPreview');
            const placeholder = document.getElementById('photoPlaceholder');
            preview.src = option.dataset.photo;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        }
    }

    // Photo auto-compression & preview
    function processCardPhoto(input) {
        if (!input.files || !input.files[0]) return;

        const file = input.files[0];
        const preview = document.getElementById('photoPreview');
        const placeholder = document.getElementById('photoPlaceholder');
        const status = document.getElementById('photoStatus');

        if (status) {
            status.innerHTML = '<span class="text-blue-600 font-semibold inline-flex items-center"><i class="fa-solid fa-spinner fa-spin mr-1"></i>ছবি প্রস্তুত হচ্ছে...</span>';
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const tempImg = new Image();
            tempImg.onload = function() {
                const MAX_W = 800;
                const MAX_H = 800;

                let width = tempImg.width;
                let height = tempImg.height;

                if (width > MAX_W || height > MAX_H) {
                    const ratio = Math.min(MAX_W / width, MAX_H / height);
                    width = Math.round(width * ratio);
                    height = Math.round(height * ratio);
                }

                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');
                ctx.imageSmoothingEnabled = true;
                ctx.imageSmoothingQuality = 'high';
                ctx.drawImage(tempImg, 0, 0, width, height);

                canvas.toBlob(function(blob) {
                    if (blob && blob.size < file.size) {
                        const safeName = (file.name ? file.name.replace(/\.[^/.]+$/, "") : "photo") + ".jpg";
                        const compressedFile = new File([blob], safeName, { type: 'image/jpeg' });
                        try {
                            const dt = new DataTransfer();
                            dt.items.add(compressedFile);
                            input.files = dt.files;
                        } catch (err) {
                            console.warn("DataTransfer update error:", err);
                        }
                    }

                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');

                    if (status) {
                        const kb = blob ? (blob.size / 1024).toFixed(0) : (file.size / 1024).toFixed(0);
                        status.innerHTML = '<span class="text-emerald-700 font-bold inline-flex items-center"><i class="fa-solid fa-circle-check text-emerald-500 mr-1"></i>ছবি প্রস্তুত (' + kb + ' KB)</span>';
                    }
                }, 'image/jpeg', 0.85);
            };
            tempImg.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    // Submit handler with spinner
    document.getElementById('idCardForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitCardBtn');
        const icon = document.getElementById('submitCardIcon');
        const text = document.getElementById('submitCardText');
        if (btn) {
            btn.disabled = true;
            btn.classList.add('opacity-80', 'cursor-not-allowed');
            if (icon) icon.className = 'fa-solid fa-circle-notch fa-spin mr-1.5';
            if (text) text.textContent = 'আইডি কার্ড তৈরি হচ্ছে...';
        }
    });
</script>
@endsection
