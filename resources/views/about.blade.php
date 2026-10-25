@extends('layouts.app')

@section('title', 'সংস্থার পরিচিতি ও লক্ষ্য - আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 p-6 sm:p-10 space-y-8">
        
        <div class="text-center border-b pb-6">
            <img src="{{ $siteLogo }}" class="h-24 w-24 mx-auto mb-3 object-contain drop-shadow">
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 uppercase tracking-tight">{{ $siteSettings['org_name_en'] ?? 'International Legal Aid & Human Rights Foundation' }}</h1>
            <h3 class="text-base font-bold text-amber-600 mt-1">{{ $siteSettings['org_name_bn'] ?? 'আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন' }}</h3>
            <p class="text-xs text-slate-500 mt-1"><i class="fa-solid fa-scale-balanced text-amber-500 mr-1"></i>{{ $siteSettings['site_slogan'] ?? 'ন্যায় বিচার প্রতিষ্ঠায় আপোষহীন' }}</p>
        </div>

        <div class="space-y-4 text-xs sm:text-sm text-slate-700 leading-relaxed">
            <div class="bg-amber-50/60 p-4 rounded-2xl border border-amber-200 text-amber-950 font-medium">
                <i class="fa-solid fa-quote-left mr-2 text-amber-500 text-base"></i>
                জাতিসংঘ ঘোষিত সার্বজনীন মানবাধিকার ঘোষণাপত্র বাস্তবায়নে আমরা দৃঢ় অঙ্গীকারবদ্ধ। বাংলাদেশের প্রতিটি নাগরিকের মৌলিক মানবাধিকার ও আইনি অধিকার সুরক্ষায় আমরা নিরলস কাজ করছি।
            </div>

            <h3 class="text-base font-bold text-slate-900 border-l-4 border-brand-900 pl-3">আমাদের লক্ষ্য ও উদ্দেশ্য</h3>
            <ul class="space-y-2 list-disc list-inside text-slate-600">
                <li>আইনি সহায়তাবঞ্চিত দরিদ্র ও নিরীহ মানুষদের সম্পূর্ণ আইনি পরামর্শ ও ন্যায়বিচার প্রাপ্তিতে সহযোগিতা করা।</li>
                <li>নারী ও শিশু নির্যাতন, যৌতুক, পারিবারিক সহিংসতা এবং পারিবারিক বিরোধ নিষ্পত্তিতে মধ্যস্থতা করা।</li>
                <li>জমিজমা সংক্রান্ত জালিয়াতি, প্রতারণা ও সাইবার অপরাধের শিকার ব্যক্তিদের আইনি দিকনির্দেশনা প্রদান।</li>
                <li>বিশেষ তদন্ত টিমের মাধ্যমে নিরপেক্ষ মাঠপর্যায়ে অনুসন্ধান ও সত্য উদঘাটন করা।</li>
                <li>সারা দেশে জেলা ও উপজেলা পর্যায়ে দক্ষ ও সৎ মানবাধিকার কর্মীদের নেটওয়ার্ক তৈরি করা।</li>
            </ul>

            <h3 class="text-base font-bold text-slate-900 border-l-4 border-brand-900 pl-3 pt-4">কেন্দ্রীয় কার্যালয়</h3>
            <p>Head Office-37/2, Fayenez Bhabon, lift-08purana Paltan,culbut Road,dhaka, বাংলাদেশ।</p>
            <p>হটলাইন: 01758343597 | ইমেইল: manushmanusherjonna@gmail.com</p>
        </div>

    </div>
</div>
@endsection
