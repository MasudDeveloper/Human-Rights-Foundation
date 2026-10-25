@extends('layouts.app')

@section('title', 'যোগাযোগ ও জরুরি হেল্পলাইন - মানবাধিকার ফাউন্ডেশন')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 p-6 sm:p-10">
        
        <div class="text-center mb-8">
            <span class="text-xs font-bold text-emerald-600 uppercase">জরুরি সহায়তা</span>
            <h1 class="text-2xl font-bold text-slate-900 mt-1">কেন্দ্রীয় কার্যালয় ও হেল্পলাইন</h1>
            <p class="text-xs text-slate-500 mt-1">আইনি পরামর্শ বা জরুরি প্রয়োজনে আমাদের সাথে সরাসরি যোগাযোগ করুন</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center mx-auto mb-3 text-lg">
                    <i class="fa-solid fa-phone-volume"></i>
                </div>
                <h3 class="font-bold text-slate-800 text-sm">হটলাইন নম্বর</h3>
                <p class="text-xs font-mono text-emerald-700 font-bold mt-1">01758343597</p>
                <p class="text-[11px] text-slate-400 mt-1">সকাল ৯টা হতে রাত ৮টা</p>
            </div>

            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center mx-auto mb-3 text-lg">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
                <h3 class="font-bold text-slate-800 text-sm">অফিসিয়াল ইমেইল</h3>
                <p class="text-xs text-blue-700 font-semibold mt-1">manushmanusherjonna@gmail.com</p>
                <p class="text-[11px] text-slate-400 mt-1">যেকোনো লিখিত তথ্যের জন্য</p>
            </div>

            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center mx-auto mb-3 text-lg">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <h3 class="font-bold text-slate-800 text-sm">কেন্দ্রীয় কার্যালয়</h3>
                <p class="text-xs text-slate-600 mt-1">Head Office-37/2, Fayenez Bhabon, lift-08purana Paltan,culbut Road,dhaka</p>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-amber-50 border border-amber-200 text-center">
            <h4 class="font-bold text-amber-950 text-sm mb-1">অনলাইনে অভিযোগ দাখিল করতে চান?</h4>
            <p class="text-xs text-slate-600 mb-3">কাগজপত্র জমা না দিয়ে অনলাইনে সরাসরি অভিযোগপত্র দায়ের করুন</p>
            <a href="{{ route('complaints.create') }}" class="inline-flex items-center px-5 py-2.5 rounded-xl bg-brand-900 text-amber-400 font-bold text-xs shadow">
                <i class="fa-solid fa-pen-to-square mr-1.5"></i>অভিযোগ ফরম পূরণ করুন
            </a>
        </div>

    </div>
</div>
@endsection
