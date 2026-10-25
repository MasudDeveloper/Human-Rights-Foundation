@extends('layouts.app')

@section('title', 'নতুন অভিযোগ দাখিল - মানবাধিকার ফাউন্ডেশন')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200/80 p-6 sm:p-10">
        
        <!-- Header -->
        <div class="border-b border-slate-100 pb-6 mb-8 text-center sm:text-left flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold text-amber-600 uppercase tracking-wider">অফিসিয়াল অভিযোগপত্র</span>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 mt-0.5">নতুন অভিযোগ দাখিল ফরম</h1>
                <p class="text-xs text-slate-500 mt-1">সঠিক ও নির্ভুল তথ্য প্রদান করে অভিযোগ নিবন্ধন সম্পন্ন করুন</p>
            </div>
            <div class="flex items-center space-x-2 bg-amber-50 border border-amber-200 px-3.5 py-2 rounded-xl text-amber-900 text-xs">
                <i class="fa-solid fa-receipt text-amber-600 text-sm"></i>
                <span>প্রসেসিং ফি: <strong>৳২৫০ টাকা</strong></span>
            </div>
        </div>

        <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Section 1: Complainant Details -->
            <div class="bg-slate-50/70 p-5 sm:p-6 rounded-2xl border border-slate-200/80">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-4 flex items-center border-b pb-2">
                    <i class="fa-solid fa-user-shield mr-2 text-brand-700 text-sm"></i>
                    <span>১. অভিযোগকারীর তথ্য</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-xs">
                    <div class="sm:col-span-2">
                        <label class="block font-semibold text-slate-700 mb-1">অভিযোগকারীর নাম <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required placeholder="অভিযোগকারীর পূর্ণ নাম"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 bg-white">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">বয়স <span class="text-rose-500">*</span></label>
                        <input type="number" name="age" value="{{ old('age') }}" required placeholder="যেমন: ৩০"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 bg-white">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">পিতার নাম</label>
                        <input type="text" name="father_name" value="{{ old('father_name') }}" placeholder="পিতার নাম"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 bg-white">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">মাতার নাম</label>
                        <input type="text" name="mother_name" value="{{ old('mother_name') }}" placeholder="মাতার নাম"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 bg-white">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">স্বামী/স্ত্রীর নাম</label>
                        <input type="text" name="spouse_name" value="{{ old('spouse_name') }}" placeholder="যদি থাকে"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 bg-white">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">গ্রাম/মহল্লা <span class="text-rose-500">*</span></label>
                        <input type="text" name="village" value="{{ old('village') }}" required placeholder="গ্রাম/মহল্লা/রোড"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 bg-white">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">ডাকঘর</label>
                        <input type="text" name="post_office" value="{{ old('post_office') }}" placeholder="ডাকঘর"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 bg-white">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">থানা <span class="text-rose-500">*</span></label>
                        <input type="text" name="thana" value="{{ old('thana') }}" required placeholder="থানা"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 bg-white">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">জেলা <span class="text-rose-500">*</span></label>
                        <input type="text" name="district" value="{{ old('district') }}" required placeholder="জেলা"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 bg-white">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">যোগাযোগের মোবাইল <span class="text-rose-500">*</span></label>
                        <input type="text" name="phone_number" value="{{ old('phone_number', $user->number) }}" required placeholder="01XXXXXXXXX"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 bg-white">
                    </div>
                </div>
            </div>

            <!-- Section 2: Complaint Details -->
            <div class="bg-slate-50/70 p-5 sm:p-6 rounded-2xl border border-slate-200/80">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-4 flex items-center border-b pb-2">
                    <i class="fa-solid fa-file-lines mr-2 text-amber-600 text-sm"></i>
                    <span>২. অভিযোগের প্রকৃতি ও ঘটনার বিবরণ</span>
                </h3>

                <div class="space-y-4 text-xs">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">অভিযোগের ধরণ <span class="text-rose-500">*</span></label>
                        <select name="complaint_type" required class="w-full px-3 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 bg-white text-xs">
                            <option value="">-- অভিযোগের বিষয় নির্বাচন করুন --</option>
                            @foreach($complaintTypes as $type)
                                <option value="{{ $type }}" {{ old('complaint_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">ঘটনার বিস্তারিত বিবরণ <span class="text-rose-500">*</span></label>
                        <textarea name="details" rows="5" required placeholder="ঘটনার স্থান, সময়, কারণ এবং আপনার সাথে ঘটে যাওয়া অন্যায়ের বিশদ বিবরণ বাংলায় লিখুন..."
                            class="w-full px-3 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 bg-white text-xs sm:text-sm leading-relaxed">{{ old('details') }}</textarea>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">সংযুক্ত ডকুমেন্ট বা অভিযোগের স্ক্যান কপি (ঐচ্ছিক)</label>
                        <input type="file" name="pdf_file" accept=".pdf,image/*"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700">
                        <span class="text-[10px] text-slate-400 mt-1 block">সমর্থনমূলক প্রমাণাদি বা লিখিত দরখাস্ত (PDF অথবা ছবি)</span>
                    </div>
                </div>
            </div>

            <!-- Section 3: Dynamic Accused (আসামী) List -->
            <div class="bg-slate-50/70 p-5 sm:p-6 rounded-2xl border border-slate-200/80">
                <div class="flex items-center justify-between border-b pb-2 mb-4">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center">
                        <i class="fa-solid fa-user-xmark mr-2 text-rose-600 text-sm"></i>
                        <span>৩. অভিযুক্ত ব্যক্তি বা আসামির তালিকা</span>
                    </h3>
                    <button type="button" onclick="addAccused()" class="px-3 py-1.5 rounded-lg bg-rose-50 border border-rose-200 hover:bg-rose-100 text-rose-700 font-bold text-xs flex items-center space-x-1 transition">
                        <i class="fa-solid fa-plus"></i>
                        <span>আসামি যোগ করুন</span>
                    </button>
                </div>

                <div id="accusedContainer" class="space-y-3">
                    <!-- Default 1st Accused -->
                    <div class="accused-row p-4 rounded-xl bg-white border border-slate-200 relative text-xs">
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                            <div class="sm:col-span-4">
                                <label class="block text-slate-600 mb-1">আসামির নাম</label>
                                <input type="text" name="accused[0][name]" placeholder="নাম লিখুন" class="w-full px-3 py-1.5 rounded-lg border border-slate-200">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-slate-600 mb-1">বয়স</label>
                                <input type="number" name="accused[0][age]" placeholder="বয়স" class="w-full px-3 py-1.5 rounded-lg border border-slate-200">
                            </div>
                            <div class="sm:col-span-3">
                                <label class="block text-slate-600 mb-1">পিতার নাম</label>
                                <input type="text" name="accused[0][father_name]" placeholder="পিতার নাম" class="w-full px-3 py-1.5 rounded-lg border border-slate-200">
                            </div>
                            <div class="sm:col-span-3">
                                <label class="block text-slate-600 mb-1">মোবাইল</label>
                                <input type="text" name="accused[0][phone]" placeholder="মোবাইল" class="w-full px-3 py-1.5 rounded-lg border border-slate-200">
                            </div>
                            <div class="sm:col-span-12">
                                <label class="block text-slate-600 mb-1">আসামির পূর্ণ ঠিকানা</label>
                                <input type="text" name="accused[0][address]" placeholder="গ্রাম, ডাকঘর, থানা ও জেলা" class="w-full px-3 py-1.5 rounded-lg border border-slate-200">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 4: Dynamic Witnesses (সাক্ষী) List -->
            <div class="bg-slate-50/70 p-5 sm:p-6 rounded-2xl border border-slate-200/80">
                <div class="flex items-center justify-between border-b pb-2 mb-4">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center">
                        <i class="fa-solid fa-users mr-2 text-indigo-600 text-sm"></i>
                        <span>৪. সাক্ষীদের বিবরণ (যদি থাকে)</span>
                    </h3>
                    <button type="button" onclick="addWitness()" class="px-3 py-1.5 rounded-lg bg-indigo-50 border border-indigo-200 hover:bg-indigo-100 text-indigo-700 font-bold text-xs flex items-center space-x-1 transition">
                        <i class="fa-solid fa-plus"></i>
                        <span>সাক্ষী যোগ করুন</span>
                    </button>
                </div>

                <div id="witnessContainer" class="space-y-3">
                    <div class="witness-row p-4 rounded-xl bg-white border border-slate-200 text-xs">
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                            <div class="sm:col-span-4">
                                <label class="block text-slate-600 mb-1">সাক্ষীর নাম</label>
                                <input type="text" name="witnesses[0][name]" placeholder="নাম লিখুন" class="w-full px-3 py-1.5 rounded-lg border border-slate-200">
                            </div>
                            <div class="sm:col-span-4">
                                <label class="block text-slate-600 mb-1">পিতার নাম</label>
                                <input type="text" name="witnesses[0][father_name]" placeholder="পিতার নাম" class="w-full px-3 py-1.5 rounded-lg border border-slate-200">
                            </div>
                            <div class="sm:col-span-4">
                                <label class="block text-slate-600 mb-1">মোবাইল নম্বর</label>
                                <input type="text" name="witnesses[0][phone_number]" placeholder="ফোন" class="w-full px-3 py-1.5 rounded-lg border border-slate-200">
                            </div>
                            <div class="sm:col-span-12">
                                <label class="block text-slate-600 mb-1">ঠিকানা</label>
                                <input type="text" name="witnesses[0][address]" placeholder="সাক্ষীর ঠিকানা" class="w-full px-3 py-1.5 rounded-lg border border-slate-200">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 5: Processing Fee Payment -->
            <div class="bg-gradient-to-br from-amber-50 to-orange-50/40 p-5 sm:p-6 rounded-2xl border border-amber-200">
                <h3 class="text-xs font-bold text-amber-900 uppercase tracking-wider mb-4 flex items-center border-b border-amber-200/80 pb-2">
                    <i class="fa-solid fa-money-bill-wave mr-2 text-amber-700 text-sm"></i>
                    <span>৫. প্রসেসিং ফি পরিশোধ (বিকাশ / নগদ / রকেট / উপায়)</span>
                </h3>

                <!-- Instructions banner -->
                <div class="bg-white/80 p-4 rounded-xl border border-amber-200/60 mb-5 text-xs text-slate-700 space-y-2">
                    <p class="font-bold text-amber-900">পেমেন্ট নির্দেশনা:</p>
                    <p>অভিযোগ তদন্ত ও প্রক্রিয়াকরণ ফি <strong>৳২৫০ টাকা</strong> নিচের যেকোনো নম্বরে "Send Money" বা "Payment" করুন:</p>
                    <div class="flex flex-wrap gap-2 pt-1 font-mono">
                        <span class="bg-pink-100 text-pink-800 px-3 py-1 rounded-lg font-bold border border-pink-200">বিকাশ: 01644416378</span>
                        <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-lg font-bold border border-orange-200">নগদ: 01644416378</span>
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-lg font-bold border border-purple-200">রকেট: 01644416378</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                    <div>
                        <label class="block font-semibold text-slate-800 mb-1">পেমেন্ট মেথড <span class="text-rose-500">*</span></label>
                        <select name="payment_gateway" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white">
                            <option value="বিকাশ">বিকাশ (bKash)</option>
                            <option value="নগদ">নগদ (Nagad)</option>
                            <option value="রকেট">রকেট (Rocket)</option>
                            <option value="উপায়">উপায় (Upay)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-800 mb-1">প্রেরক নম্বর (Sender No) <span class="text-rose-500">*</span></label>
                        <input type="text" name="payment_number" value="{{ old('payment_number') }}" required placeholder="যে নম্বর থেকে টাকা পাঠিয়েছেন"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white font-mono">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-800 mb-1">ট্রানজেকশন আইডি (TrxID) <span class="text-rose-500">*</span></label>
                        <input type="text" name="transaction_id" value="{{ old('transaction_id') }}" required placeholder="যেমন: BL92XK38"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white font-mono uppercase">
                    </div>
                </div>
            </div>

            <!-- Signature & Confirmation -->
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 text-xs">
                <label class="flex items-start space-x-2.5 cursor-pointer">
                    <input type="checkbox" required class="mt-0.5 rounded border-slate-300 text-brand-600">
                    <span class="text-slate-600 leading-relaxed">
                        আমি অঙ্গীকার করছি যে, উপরে বর্ণিত অভিযোগের সমস্ত বিবরণ সম্পূর্ণ সত্য ও নির্ভুল। কোনো অসত্য বা বিভ্রান্তিকর তথ্য দিলে তার দায়ভার আমার উপর বর্তাবে।
                    </span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="w-full sm:w-auto px-10 py-3.5 rounded-xl bg-gradient-to-r from-brand-900 via-brand-800 to-brand-700 hover:from-brand-800 hover:to-brand-600 text-amber-400 font-bold text-sm shadow-xl transition transform active:scale-95 inline-flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>অভিযোগ জমা দিন ও রিসিট ডাউনলোড করুন</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let accusedCount = 1;
    function addAccused() {
        const container = document.getElementById('accusedContainer');
        const div = document.createElement('div');
        div.className = 'accused-row p-4 rounded-xl bg-white border border-slate-200 relative text-xs mt-3';
        div.innerHTML = `
            <button type="button" onclick="this.closest('.accused-row').remove()" class="absolute right-3 top-3 text-rose-500 hover:text-rose-700 font-bold text-xs" title="মুছে ফেলুন">
                <i class="fa-solid fa-trash-can"></i>
            </button>
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 pr-6">
                <div class="sm:col-span-4">
                    <label class="block text-slate-600 mb-1">আসামির নাম</label>
                    <input type="text" name="accused[${accusedCount}][name]" placeholder="নাম লিখুন" class="w-full px-3 py-1.5 rounded-lg border border-slate-200">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-slate-600 mb-1">বয়স</label>
                    <input type="number" name="accused[${accusedCount}][age]" placeholder="বয়স" class="w-full px-3 py-1.5 rounded-lg border border-slate-200">
                </div>
                <div class="sm:col-span-3">
                    <label class="block text-slate-600 mb-1">পিতার নাম</label>
                    <input type="text" name="accused[${accusedCount}][father_name]" placeholder="পিতার নাম" class="w-full px-3 py-1.5 rounded-lg border border-slate-200">
                </div>
                <div class="sm:col-span-3">
                    <label class="block text-slate-600 mb-1">মোবাইল</label>
                    <input type="text" name="accused[${accusedCount}][phone]" placeholder="মোবাইল" class="w-full px-3 py-1.5 rounded-lg border border-slate-200">
                </div>
                <div class="sm:col-span-12">
                    <label class="block text-slate-600 mb-1">আসামির পূর্ণ ঠিকানা</label>
                    <input type="text" name="accused[${accusedCount}][address]" placeholder="গ্রাম, ডাকঘর, থানা ও জেলা" class="w-full px-3 py-1.5 rounded-lg border border-slate-200">
                </div>
            </div>
        `;
        container.appendChild(div);
        accusedCount++;
    }

    let witnessCount = 1;
    function addWitness() {
        const container = document.getElementById('witnessContainer');
        const div = document.createElement('div');
        div.className = 'witness-row p-4 rounded-xl bg-white border border-slate-200 relative text-xs mt-3';
        div.innerHTML = `
            <button type="button" onclick="this.closest('.witness-row').remove()" class="absolute right-3 top-3 text-rose-500 hover:text-rose-700 font-bold text-xs" title="মুছে ফেলুন">
                <i class="fa-solid fa-trash-can"></i>
            </button>
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 pr-6">
                <div class="sm:col-span-4">
                    <label class="block text-slate-600 mb-1">সাক্ষীর নাম</label>
                    <input type="text" name="witnesses[${witnessCount}][name]" placeholder="নাম লিখুন" class="w-full px-3 py-1.5 rounded-lg border border-slate-200">
                </div>
                <div class="sm:col-span-4">
                    <label class="block text-slate-600 mb-1">পিতার নাম</label>
                    <input type="text" name="witnesses[${witnessCount}][father_name]" placeholder="পিতার নাম" class="w-full px-3 py-1.5 rounded-lg border border-slate-200">
                </div>
                <div class="sm:col-span-4">
                    <label class="block text-slate-600 mb-1">মোবাইল নম্বর</label>
                    <input type="text" name="witnesses[${witnessCount}][phone_number]" placeholder="ফোন" class="w-full px-3 py-1.5 rounded-lg border border-slate-200">
                </div>
                <div class="sm:col-span-12">
                    <label class="block text-slate-600 mb-1">ঠিকানা</label>
                    <input type="text" name="witnesses[${witnessCount}][address]" placeholder="সাক্ষীর ঠিকানা" class="w-full px-3 py-1.5 rounded-lg border border-slate-200">
                </div>
            </div>
        `;
        container.appendChild(div);
        witnessCount++;
    }
</script>
@endsection
