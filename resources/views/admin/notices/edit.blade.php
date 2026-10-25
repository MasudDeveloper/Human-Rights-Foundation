@extends('layouts.admin')

@section('title', 'নোটিশ সম্পাদনা - #' . $notice->id)
@section('page_title', 'নোটিশ ও বিজ্ঞপ্তি সম্পাদনা')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between border-b pb-4 mb-6">
            <div>
                <span class="text-xs text-amber-600 font-bold uppercase tracking-wider">নোটিশ আইডি: #{{ $notice->id }}</span>
                <h2 class="text-lg font-bold text-slate-900 mt-0.5">নোটিশ তথ্য ও ফাইল সম্পাদনা</h2>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('notices.show', $notice->id) }}" target="_blank" class="text-xs text-blue-700 hover:text-blue-900 font-semibold flex items-center">
                    <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i>লাইভ প্রিভিউ
                </a>
                <span class="text-slate-300">|</span>
                <a href="{{ route('admin.notices') }}" class="text-xs text-slate-500 hover:text-slate-900 font-semibold flex items-center">
                    <i class="fa-solid fa-arrow-left mr-1"></i>তালিকায় ফিরে যান
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.notices.update', $notice->id) }}" enctype="multipart/form-data" class="space-y-5 text-xs">
            @csrf

            <!-- Notice Title -->
            <div>
                <label class="block font-bold text-slate-800 mb-1">
                    নোটিশের শিরোনাম <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title', $notice->title) }}" required
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-slate-900 font-semibold text-slate-900">
                @error('title')
                    <span class="text-rose-600 text-[11px] mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Category & Published Date -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-800 mb-1">
                        ক্যাটাগরি / ধরন <span class="text-rose-500">*</span>
                    </label>
                    <select name="category" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white font-semibold text-slate-800 focus:ring-2 focus:ring-slate-900">
                        @foreach(['জরুরি বিজ্ঞপ্তি', 'সাধারণ নোটিশ', 'প্রেস বিজ্ঞপ্তি', 'আইনি নির্দেশনা', 'প্রশাসনিক নোটিশ'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $notice->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 mb-1">
                        প্রকাশের তারিখ <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="published_date" value="{{ old('published_date', $notice->published_date ? $notice->published_date->format('Y-m-d') : date('Y-m-d')) }}" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono text-slate-800 focus:ring-2 focus:ring-slate-900">
                </div>
            </div>

            <!-- Notice Description / Content -->
            <div>
                <label class="block font-bold text-slate-800 mb-1">
                    নোটিশের বিস্তারিত বিষয়বস্তু
                </label>
                <textarea name="description" rows="6"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs leading-relaxed focus:ring-2 focus:ring-slate-900 font-medium text-slate-800">{{ old('description', $notice->description) }}</textarea>
            </div>

            <!-- Optional PDF Attachment Box -->
            <div class="p-5 rounded-2xl border-2 border-dashed border-rose-300 bg-rose-50/40 space-y-3">
                <div class="flex items-center space-x-2">
                    <div class="w-9 h-9 rounded-xl bg-rose-600 text-white flex items-center justify-center text-base shadow">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-900 text-xs">
                            পিডিএফ (PDF) বা সংযুক্তি ফাইল পরিবর্তন / সংযোজন <span class="text-slate-400 font-normal">(ঐচ্ছিক)</span>
                        </label>
                        <span class="text-[11px] text-slate-500">নতুন ফাইল দিলে পূর্বের ফাইল প্রতিস্থাপিত হবে</span>
                    </div>
                </div>

                @if($notice->has_file)
                    <div class="p-3 bg-white rounded-xl border border-rose-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                        <div class="flex items-center space-x-2.5">
                            <i class="fa-solid fa-file-pdf text-rose-600 text-lg"></i>
                            <div>
                                <span class="font-bold text-slate-900 block text-xs">{{ $notice->file_name ?: basename($notice->file_path) }}</span>
                                <span class="text-[10px] text-slate-400 font-mono">{{ $notice->file_size ?: 'ডকুমেন্ট' }}</span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <a href="{{ $notice->file_url }}" target="_blank" class="px-3 py-1 bg-rose-100 hover:bg-rose-200 text-rose-800 rounded-lg text-xs font-bold transition flex items-center">
                                <i class="fa-solid fa-download mr-1"></i>ডাউনলোড
                            </a>

                            <label class="inline-flex items-center text-xs text-rose-600 font-semibold cursor-pointer">
                                <input type="checkbox" name="delete_file" value="1" class="rounded border-slate-300 text-rose-600 mr-1.5">
                                <span>ফাইলটি মুছে ফেলুন</span>
                            </label>
                        </div>
                    </div>
                @endif

                <div class="pt-1">
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">
                        {{ $notice->has_file ? 'নতুন ফাইল দিয়ে প্রতিস্থাপন করুন:' : 'ফাইল আপলোড করুন:' }}
                    </label>
                    <input type="file" name="pdf_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 bg-white text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-rose-600 file:text-white hover:file:bg-rose-500">
                    <span class="text-[10px] text-slate-400 mt-1 block">সমর্থিত ফরম্যাট: PDF, DOCX, JPG, PNG (সর্বোচ্চ ২৫ মেগাবাইট)</span>
                </div>
            </div>

            <!-- Ticker & Active Checkboxes -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200">
                <label class="flex items-start space-x-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $notice->is_active ? '1' : '0') == '1' ? 'checked' : '' }}
                        class="w-4 h-4 mt-0.5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <div>
                        <span class="font-bold text-slate-800 block">নোটিশটি সক্রিয় থাকবে</span>
                        <span class="text-[10px] text-slate-500 block">সরাসরি ওয়েবসাইট এবং নোটিশ বোর্ডে দৃশ্যমান হবে</span>
                    </div>
                </label>

                <label class="flex items-start space-x-3 cursor-pointer">
                    <input type="checkbox" name="is_ticker" value="1" {{ old('is_ticker', $notice->is_ticker ? '1' : '0') == '1' ? 'checked' : '' }}
                        class="w-4 h-4 mt-0.5 rounded border-slate-300 text-amber-500 focus:ring-amber-500">
                    <div>
                        <span class="font-bold text-slate-800 block">ওয়েবসাইটের স্ক্রলিং টিকারে দেখান</span>
                        <span class="text-[10px] text-slate-500 block">হোমপেজ ও সকল পেজের উপরের জরুরি বারে স্ক্রল করবে</span>
                    </div>
                </label>
            </div>

            <!-- Form Actions -->
            <div class="pt-4 border-t border-slate-200 flex justify-end space-x-3">
                <a href="{{ route('admin.notices') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition">
                    বাতিল
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-amber-400 font-extrabold shadow-md transition flex items-center space-x-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>পরিবর্তন সংরক্ষণ করুন</span>
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
