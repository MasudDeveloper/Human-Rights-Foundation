@extends('layouts.admin')

@section('title', 'ভিডিও সম্পাদনা - ভিডিও গ্যালারি')
@section('page_title', 'ভিডিও তথ্য সম্পাদনা')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Action Link -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.videos') }}" class="inline-flex items-center space-x-2 text-xs font-bold text-slate-600 hover:text-slate-900 bg-white px-3.5 py-2 rounded-xl border border-slate-200 transition shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>ভিডিও তালিকায় ফিরে যান</span>
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form id="videoEditForm" method="POST" action="{{ route('admin.videos.update', $video->id) }}" class="space-y-6">
            @csrf

            <!-- YouTube URL Input with Live Preview -->
            <div>
                <label for="youtube_url" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">
                    ইউটিউব ভিডিওর লিংক (YouTube URL) <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <i class="fa-brands fa-youtube absolute left-3.5 top-3.5 text-red-600 text-base"></i>
                    <input type="text" 
                           name="youtube_url" 
                           id="youtube_url" 
                           value="{{ old('youtube_url', $video->youtube_url) }}" 
                           required 
                           placeholder="যেমন: https://www.youtube.com/watch?v=... অথবা https://youtu.be/..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition"
                           oninput="updateVideoPreview(this.value)">
                </div>
                <p class="text-[11px] text-slate-400 mt-1">
                    ইউটিউবের যেকোনো সাধারণ ভিডিও লিংক, শর্ট লিংক (youtu.be) অথবা Shorts লিংক এখানে পেস্ট করতে পারেন।
                </p>
                @error('youtube_url')
                    <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror

                <!-- Live Video Preview Box -->
                <div id="videoPreviewContainer" class="mt-4 p-4 bg-slate-950 rounded-2xl border border-slate-800 text-center">
                    <span class="inline-flex items-center text-xs text-emerald-400 font-bold mb-3">
                        <i class="fa-solid fa-circle-check mr-1.5"></i>ভিডিও প্রিভিউ
                    </span>
                    <div class="relative w-full max-w-lg mx-auto aspect-[16/9] rounded-xl overflow-hidden bg-black shadow-lg">
                        <iframe id="videoIframe" class="w-full h-full" src="{{ $video->embed_url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </div>

            <!-- Title & Category Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-xs font-bold text-slate-700 mb-1.5">
                        ভিডিওর শিরোনাম <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title', $video->title) }}" 
                           required 
                           placeholder="ভিডিওর শিরোনাম লিখুন" 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                    @error('title')
                        <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-xs font-bold text-slate-700 mb-1.5">
                        ক্যাটাগরি / বিষয়
                    </label>
                    <input type="text" 
                           name="category" 
                           id="category" 
                           list="categorySuggestions"
                           value="{{ old('category', $video->category) }}" 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                    <datalist id="categorySuggestions">
                        <option value="ভিডিও প্রতিবেদন">
                        <option value="মানবাধিকার সেমিনার">
                        <option value="আইনি সহায়তা ক্যাম্প">
                        <option value="সংবাদ সম্মেলন">
                        <option value="ত্রাণ ও পুনর্বাসন">
                        <option value="কেন্দ্রীয় সম্মেলন">
                        <option value="বিশেষ সাক্ষাৎকার">
                    </datalist>
                    @error('category')
                        <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Sort Order Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="sort_order" class="block text-xs font-bold text-slate-700 mb-1.5">
                        প্রদর্শনের ক্রম (Sort Order)
                    </label>
                    <input type="number" 
                           name="sort_order" 
                           id="sort_order" 
                           value="{{ old('sort_order', $video->sort_order) }}" 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                </div>

                <div class="flex items-center pt-6">
                    <label class="flex items-center space-x-2.5 cursor-pointer">
                        <input type="checkbox" 
                               name="is_active" 
                               id="is_active" 
                               value="1" 
                               {{ old('is_active', $video->is_active) ? 'checked' : '' }} 
                               class="w-4 h-4 rounded text-amber-500 focus:ring-amber-400 border-slate-300">
                        <span class="text-xs font-bold text-slate-800">
                            ভিডিওটি মূল ওয়েবসাইটে সক্রিয় ও প্রকাশ রাখুন
                        </span>
                    </label>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 mb-1.5">
                    সংক্ষিপ্ত বিবরণ (ঐচ্ছিক)
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="3" 
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">{{ old('description', $video->description) }}</textarea>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.videos') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 text-xs font-bold transition">
                    বাতিল
                </a>
                <button type="submit" id="submitBtn" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold text-xs shadow-md transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-check" id="submitIcon"></i>
                    <span id="submitText">পরিবর্তন সংরক্ষণ করুন</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

@section('scripts')
<script>
    function extractYtId(url) {
        if (!url) return null;
        url = url.trim();
        if (/^[a-zA-Z0-9_-]{11}$/.test(url)) return url;
        const m = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/|youtube\.com\/live\/)([a-zA-Z0-9_-]{11})/);
        return m ? m[1] : null;
    }

    function updateVideoPreview(url) {
        const id = extractYtId(url);
        const container = document.getElementById('videoPreviewContainer');
        const iframe = document.getElementById('videoIframe');

        if (id && container && iframe) {
            iframe.src = 'https://www.youtube-nocookie.com/embed/' + id + '?rel=0';
            container.classList.remove('hidden');
        } else if (container && iframe) {
            iframe.src = '';
            container.classList.add('hidden');
        }
    }

    document.getElementById('videoEditForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        const icon = document.getElementById('submitIcon');
        const text = document.getElementById('submitText');
        if (btn) {
            btn.disabled = true;
            btn.classList.add('opacity-80', 'cursor-not-allowed');
            if (icon) icon.className = 'fa-solid fa-circle-notch fa-spin mr-1.5';
            if (text) text.textContent = 'সংরক্ষণ হচ্ছে...';
        }
    });
</script>
@endsection
