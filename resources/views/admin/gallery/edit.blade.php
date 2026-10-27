@extends('layouts.admin')

@section('title', 'ছবি সম্পাদনা - ফটো গ্যালারি')
@section('page_title', 'গ্যালারির ছবি ও তথ্য সম্পাদনা')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Action Link -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.gallery') }}" class="inline-flex items-center space-x-2 text-xs font-bold text-slate-600 hover:text-slate-900 bg-white px-3.5 py-2 rounded-xl border border-slate-200 transition shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>গ্যালারি তালিকায় ফিরে যান</span>
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form method="POST" action="{{ route('admin.gallery.update', $photo->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Current Image & Replacement Upload Area -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    বর্তমান ছবি ও পরিবর্তন
                </label>

                <div class="flex flex-col sm:flex-row items-center gap-6 p-4 bg-slate-50 rounded-2xl border border-slate-200">
                    <!-- Current Image Preview -->
                    <div class="w-full sm:w-48 aspect-[4/3] rounded-xl overflow-hidden border border-slate-300 shadow-sm bg-white flex-shrink-0 relative">
                        <img id="imagePreview" src="{{ $photo->image_url }}" alt="{{ $photo->title }}" class="w-full h-full object-cover">
                        <span class="absolute bottom-1 right-1 bg-slate-950/80 text-white text-[9px] px-1.5 py-0.5 rounded font-mono">বর্তমান</span>
                    </div>

                    <!-- File Input for New Image -->
                    <div class="flex-grow w-full text-center sm:text-left">
                        <p class="text-xs font-bold text-slate-800">ছবি পরিবর্তন করতে চান?</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">নতুন ছবি না দিলে আগের ছবিটিই বহাল থাকবে।</p>
                        
                        <div class="mt-3">
                            <input type="file" 
                                   name="image" 
                                   id="galleryImageInput" 
                                   accept="image/*" 
                                   class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-amber-500 file:text-slate-950 hover:file:bg-amber-400 file:cursor-pointer cursor-pointer"
                                   onchange="previewGalleryImage(event)">
                            <p class="text-[11px] text-emerald-600 font-bold mt-1.5 hidden" id="fileNameLabel"></p>
                        </div>
                    </div>
                </div>
                @error('image')
                    <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title & Category Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-xs font-bold text-slate-700 mb-1.5">
                        ছবির শিরোনাম <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title', $photo->title) }}" 
                           required 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                    @error('title')
                        <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-xs font-bold text-slate-700 mb-1.5">
                        ক্যাটাগরি / ইভেন্ট
                    </label>
                    <input type="text" 
                           name="category" 
                           id="category" 
                           list="categorySuggestions"
                           value="{{ old('category', $photo->category) }}" 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                    <datalist id="categorySuggestions">
                        <option value="সম্মেলন ও সভা">
                        <option value="আইনি সহায়তা ক্যাম্প">
                        <option value="মানবাধিকার র‍্যালি">
                        <option value="ত্রাণ ও পুনর্বাসন">
                        <option value="সেমিনার ও কর্মশালা">
                        <option value="কেন্দ্রীয় কমিটি">
                    </datalist>
                    @error('category')
                        <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Event Date & Sort Order Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Event Date -->
                <div>
                    <label for="event_date" class="block text-xs font-bold text-slate-700 mb-1.5">
                        অনুষ্ঠানের তারিখ
                    </label>
                    <input type="date" 
                           name="event_date" 
                           id="event_date" 
                           value="{{ old('event_date', $photo->event_date ? $photo->event_date->format('Y-m-d') : '') }}" 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-xs font-bold text-slate-700 mb-1.5">
                        প্রদর্শনের ক্রম (Sort Order)
                    </label>
                    <input type="number" 
                           name="sort_order" 
                           id="sort_order" 
                           value="{{ old('sort_order', $photo->sort_order) }}" 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 mb-1.5">
                    সংক্ষিপ্ত বিবরণ / ক্যাপশন (ঐচ্ছিক)
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="3" 
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">{{ old('description', $photo->description) }}</textarea>
            </div>

            <!-- Is Active Checkbox -->
            <div class="flex items-center space-x-2 pt-2">
                <input type="checkbox" 
                       name="is_active" 
                       id="is_active" 
                       value="1" 
                       {{ old('is_active', $photo->is_active) ? 'checked' : '' }} 
                       class="w-4 h-4 rounded text-amber-500 focus:ring-amber-400 border-slate-300">
                <label for="is_active" class="text-xs font-bold text-slate-700 cursor-pointer">
                    ছবিটি মূল ওয়েবসাইটে সক্রিয় রাখুন
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.gallery') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 text-xs font-bold transition">
                    বাতিল
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold text-xs shadow-md transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-check"></i>
                    <span>পরিবর্তন সংরক্ষণ করুন</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

@section('scripts')
<script>
    function previewGalleryImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        const fileNameLabel = document.getElementById('fileNameLabel');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                fileNameLabel.textContent = 'নির্বাচিত নতুন ছবি: ' + file.name + ' (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)';
                fileNameLabel.classList.remove('hidden');
            }

            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
