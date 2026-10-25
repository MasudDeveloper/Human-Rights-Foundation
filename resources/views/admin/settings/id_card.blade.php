@extends('layouts.admin')

@section('title', 'আইডি কার্ড ও ডিজিটাল স্বাক্ষর সেটিংস - সুপার অ্যাডমিন')
@section('page_title', 'আইডি কার্ড ও স্বাক্ষর কনফিগারেশন')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
        <div class="border-b pb-4 mb-6">
            <span class="text-xs text-amber-600 font-bold uppercase tracking-wider">সুপার অ্যাডমিন সেটিংস</span>
            <h2 class="text-lg font-bold text-slate-900 mt-0.5">সদস্য আইডি কার্ড ও স্বাক্ষর কনফিগারেশন</h2>
            <p class="text-xs text-slate-500 mt-1">আইডি কার্ডে প্রদর্শিত নম্বর প্রিফিক্স, মেয়াদ, সিল ও মহাসচিবের স্বাক্ষরের তথ্য</p>
        </div>

        <form method="POST" action="{{ route('admin.settings.id_card.post') }}" enctype="multipart/form-data" class="space-y-5 text-xs">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">আইডি কার্ড প্রিফিক্স (Prefix) <span class="text-rose-500">*</span></label>
                    <input type="text" name="id_card_prefix" value="{{ old('id_card_prefix', $settings['id_card_prefix']) }}" required placeholder="যেমন: ILHRF-"
                        class="w-full px-3 py-2 rounded-xl border border-slate-300 font-mono focus:ring-2 focus:ring-slate-900">
                    <span class="text-[10px] text-slate-400 mt-1 block">যেমন: ILHRF-0001, ILHRF-0002</span>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">মেয়াদকাল (বছর) <span class="text-rose-500">*</span></label>
                    <input type="number" name="id_card_validity_years" value="{{ old('id_card_validity_years', $settings['id_card_validity_years']) }}" required min="1" max="10"
                        class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-slate-900">
                    <span class="text-[10px] text-slate-400 mt-1 block">ইস্যু তারিখ হতে স্বয়ংক্রিয়ভাবে মেয়াদ হিসাব হবে</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">অনুমোদনকারী কর্মকর্তার নাম <span class="text-rose-500">*</span></label>
                    <input type="text" name="authorized_signature_name" value="{{ old('authorized_signature_name', $settings['authorized_signature_name']) }}" required placeholder="কর্মকর্তার নাম"
                        class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-slate-900">
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">অনুমোদনকারী কর্মকর্তার পদবী <span class="text-rose-500">*</span></label>
                    <input type="text" name="authorized_signature_title" value="{{ old('authorized_signature_title', $settings['authorized_signature_title']) }}" required placeholder="পদবী"
                        class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-slate-900">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">কার্ড লাইসেন্স নম্বর (Licence No)</label>
                    <input type="text" name="licence_no" value="{{ old('licence_no', $settings['licence_no'] ?? 'Licence No-s-15472/2026') }}" placeholder="Licence No-s-15472/2026"
                        class="w-full px-3 py-2 rounded-xl border border-slate-300 font-mono">
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">ওয়েবসাইট লিংক (Website URL)</label>
                    <input type="text" name="site_website" value="{{ old('site_website', $settings['site_website'] ?? 'https://internationallegalaidhumanrightsfoundration.org') }}" placeholder="https://..."
                        class="w-full px-3 py-2 rounded-xl border border-slate-300">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">কার্ডের জরুরি হটলাইন</label>
                    <input type="text" name="id_card_emergency_contact" value="{{ old('id_card_emergency_contact', $settings['id_card_emergency_contact']) }}" placeholder="ফোন নম্বর"
                        class="w-full px-3 py-2 rounded-xl border border-slate-300 font-mono">
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">কার্ডে কার্যালয় ঠিকানা (লাইন ১)</label>
                    <input type="text" name="id_card_office_address" value="{{ old('id_card_office_address', $settings['id_card_office_address']) }}" placeholder="ঠিকানা লাইন ১"
                        class="w-full px-3 py-2 rounded-xl border border-slate-300">
                </div>
            </div>

            <div>
                <label class="block font-semibold text-slate-700 mb-1">কার্ডে কার্যালয় ঠিকানা (লাইন ২)</label>
                <input type="text" name="id_card_office_address_2" value="{{ old('id_card_office_address_2', $settings['id_card_office_address_2'] ?? 'lift-08purana Paltan,culbut Road,dhaka') }}" placeholder="ঠিকানা লাইন ২"
                    class="w-full px-3 py-2 rounded-xl border border-slate-300">
            </div>

            <!-- Signature Image Upload -->
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                <label class="block font-semibold text-slate-700 mb-1">ডিজিটাল স্বাক্ষর বা অফিশিয়াল সিল ছবি (স্বচ্ছ PNG)</label>
                <div class="flex items-center space-x-4 mt-2">
                    @if(!empty($settings['authorized_signature_img']))
                        <div class="p-2 bg-white rounded-lg border">
                            <img src="{{ asset($settings['authorized_signature_img']) }}" alt="Signature" class="h-10 object-contain">
                        </div>
                    @endif
                    <input type="file" name="authorized_signature_img" accept="image/*"
                        class="w-full px-3 py-1.5 rounded-xl border border-slate-300 bg-white text-xs">
                </div>
                <span class="text-[10px] text-slate-400 mt-1 block">স্বাক্ষর ছবি আপলোড না করলে টেক্সট আকারে স্বয়ংক্রিয় স্ট্যাম্প প্রদর্শিত হবে।</span>
            </div>

            <div class="pt-4 border-t flex justify-end">
                <button type="submit" class="px-8 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-amber-400 font-bold shadow transition flex items-center space-x-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>সেটিংস সংরক্ষণ করুন</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
