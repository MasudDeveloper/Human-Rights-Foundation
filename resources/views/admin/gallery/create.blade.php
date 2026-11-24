@extends('layouts.admin')

@section('title', 'নতুন ছবি আপলোড - ফটো গ্যালারি')
@section('page_title', 'গ্যালারিতে নতুন ছবি যোগ করুন')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Action Link -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.gallery') }}" class="inline-flex items-center space-x-2 text-xs font-bold text-slate-600 hover:text-slate-900 bg-white px-3.5 py-2 rounded-xl border border-slate-200 transition shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>গ্যালারি তালিকায় ফিরে যান</span>
        </a>
    </div>

    <!-- Upload Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data" class="space-y-6" id="galleryUploadForm" onsubmit="return handleGallerySubmit(event)">
            @csrf

            <!-- Image File Upload Area with Realtime Preview & Auto-Compress -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    ছবি নির্বাচন করুন <span class="text-rose-500">*</span>
                </label>

                <div class="relative border-2 border-dashed border-slate-300 hover:border-amber-500 rounded-2xl p-6 text-center transition bg-slate-50/50 cursor-pointer" id="dropArea" onclick="document.getElementById('galleryImageInput').click()">
                    <!-- Real File Input -->
                    <input type="file" 
                           name="image" 
                           id="galleryImageInput" 
                           accept="image/*" 
                           class="hidden"
                           onchange="handleImageSelection(event)">

                    <!-- Preview Container -->
                    <div id="previewContainer" class="hidden mb-3">
                        <img id="imagePreview" src="" alt="Preview" class="max-h-64 mx-auto rounded-xl object-contain shadow-md border border-slate-200">
                        <div class="mt-3 flex flex-wrap items-center justify-center gap-2">
                            <span class="text-xs font-bold px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200" id="fileStatusBadge">
                                ছবি প্রস্তুত
                            </span>
                            <button type="button" onclick="event.stopPropagation(); document.getElementById('galleryImageInput').click()" class="text-xs font-bold px-3 py-1 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
                                <i class="fa-solid fa-arrows-rotate mr-1"></i>ছবি পরিবর্তন করুন
                            </button>
                        </div>
                    </div>

                    <!-- Placeholder Container -->
                    <div id="placeholderContainer" class="py-4">
                        <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl mx-auto mb-3 shadow-inner">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                        </div>
                        <p class="text-sm font-bold text-slate-800">ছবি আপলোড করতে এখানে ক্লিক করুন অথবা ড্র্যাগ করুন</p>
                        <p class="text-xs text-slate-400 mt-1">সমর্থিত ফরম্যাট: JPG, JPEG, PNG, WEBP (ক্যামেরার বড় ছবি স্বয়ংক্রিয়ভাবে অপ্টিমাইজ হয়ে দ্রুত আপলোড হবে)</p>
                    </div>

                    <!-- Processing Spinner (During Canvas Compression) -->
                    <div id="compressionSpinner" class="hidden py-6">
                        <div class="w-10 h-10 border-4 border-amber-500 border-t-transparent rounded-full animate-spin mx-auto mb-2"></div>
                        <p class="text-xs font-bold text-amber-600">ছবি অপ্টিমাইজ করা হচ্ছে, অনুগ্রহ করে অপেক্ষা করুন...</p>
                    </div>
                </div>

                <p id="imageErrorLabel" class="text-xs text-rose-500 mt-1.5 font-semibold hidden"></p>
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
                           value="{{ old('title') }}" 
                           required 
                           placeholder="উদাঃ কেন্দ্রীয় প্রতিনিধি সম্মেলন ২০২৬" 
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
                           value="{{ old('category', 'কার্যক্রম') }}" 
                           placeholder="ক্যাটাগরি লিখুন বা বাছাই করুন" 
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
                           value="{{ old('event_date', date('Y-m-d')) }}" 
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
                           value="{{ old('sort_order', 0) }}" 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                    <p class="text-[10px] text-slate-400 mt-1">ছোট সংখ্যা আগে প্রদর্শিত হবে (যেমন ০, ১, ২...)</p>
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
                          placeholder="ছবি বা অনুষ্ঠান সম্পর্কিত সংক্ষিপ্ত বিবরণ লিখুন..." 
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">{{ old('description') }}</textarea>
            </div>

            <!-- Is Active Checkbox -->
            <div class="flex items-center space-x-2 pt-2">
                <input type="checkbox" 
                       name="is_active" 
                       id="is_active" 
                       value="1" 
                       {{ old('is_active', true) ? 'checked' : '' }} 
                       class="w-4 h-4 rounded text-amber-500 focus:ring-amber-400 border-slate-300">
                <label for="is_active" class="text-xs font-bold text-slate-700 cursor-pointer">
                    ছবিটি সঙ্গে সঙ্গে মূল ওয়েবসাইটে সক্রিয় ও প্রকাশ করুন
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.gallery') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 text-xs font-bold transition">
                    বাতিল
                </a>
                <button type="submit" id="submitBtn" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold text-xs shadow-md transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-cloud-arrow-up" id="submitIcon"></i>
                    <span id="submitText">ছবি আপলোড সম্পন্ন করুন</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

@section('scripts')
<script>
    const fileInput = document.getElementById('galleryImageInput');
    const previewContainer = document.getElementById('previewContainer');
    const placeholderContainer = document.getElementById('placeholderContainer');
    const compressionSpinner = document.getElementById('compressionSpinner');
    const imagePreview = document.getElementById('imagePreview');
    const fileStatusBadge = document.getElementById('fileStatusBadge');
    const imageErrorLabel = document.getElementById('imageErrorLabel');
    const dropArea = document.getElementById('dropArea');

    // Drag and Drop handling
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropArea.classList.add('border-amber-500', 'bg-amber-50/50');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropArea.classList.remove('border-amber-500', 'bg-amber-50/50');
        }, false);
    });

    dropArea.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        if (files && files.length > 0) {
            fileInput.files = files;
            processImageFile(files[0]);
        }
    }, false);

    function handleImageSelection(event) {
        if (event.target.files && event.target.files[0]) {
            processImageFile(event.target.files[0]);
        }
    }

    // Smart Canvas Compressor (Resizes high-res camera photos to web-optimal 1920px max)
    async function processImageFile(file) {
        imageErrorLabel.classList.add('hidden');
        imageErrorLabel.textContent = '';

        if (!file.type.startsWith('image/')) {
            imageErrorLabel.textContent = 'দয়া করে একটি সঠিক ইমেজ ফাইল (JPG, PNG, WEBP) নির্বাচন করুন।';
            imageErrorLabel.classList.remove('hidden');
            return;
        }

        const originalSizeMB = (file.size / (1024 * 1024)).toFixed(2);

        // If file is already small (< 500KB), direct preview
        if (file.size <= 500 * 1024) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.src = e.target.result;
                fileStatusBadge.innerHTML = `<i class="fa-solid fa-circle-check mr-1"></i> ছবি প্রস্তুত: ${file.name} (${(file.size / 1024).toFixed(0)} KB)`;
                placeholderContainer.classList.add('hidden');
                compressionSpinner.classList.add('hidden');
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
            return;
        }

        // Show compression spinner
        placeholderContainer.classList.add('hidden');
        previewContainer.classList.add('hidden');
        compressionSpinner.classList.remove('hidden');

        try {
            const compressedFile = await compressImageToBlob(file, 1920, 1200, 0.84);

            // Update file input with compressed file using DataTransfer API
            if (window.DataTransfer) {
                const dt = new DataTransfer();
                dt.items.add(compressedFile);
                fileInput.files = dt.files;
            }

            const newSizeKB = (compressedFile.size / 1024).toFixed(0);

            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.src = e.target.result;
                fileStatusBadge.innerHTML = `<i class="fa-solid fa-circle-check mr-1"></i> ছবি অপ্টিমাইজড: (${originalSizeMB} MB ➔ ${newSizeKB} KB)`;
                compressionSpinner.classList.add('hidden');
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(compressedFile);
        } catch (err) {
            console.warn('Canvas compression fallback to original:', err);
            // Fallback: show original preview
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.src = e.target.result;
                fileStatusBadge.innerHTML = `<i class="fa-solid fa-circle-check mr-1"></i> ফাইল প্রস্তুত: (${originalSizeMB} MB)`;
                compressionSpinner.classList.add('hidden');
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }

    function compressImageToBlob(file, maxW, maxH, quality) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = new Image();
                img.onload = () => {
                    let w = img.width;
                    let h = img.height;

                    if (w > maxW) {
                        h = Math.round((h * maxW) / w);
                        w = maxW;
                    }
                    if (h > maxH) {
                        w = Math.round((w * maxH) / h);
                        h = maxH;
                    }

                    const canvas = document.createElement('canvas');
                    canvas.width = w;
                    canvas.height = h;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, w, h);

                    canvas.toBlob((blob) => {
                        if (!blob || blob.size >= file.size) {
                            resolve(file);
                            return;
                        }
                        const cleanName = file.name.replace(/\.[^/.]+$/, "") + ".jpg";
                        const resultFile = new File([blob], cleanName, {
                            type: 'image/jpeg',
                            lastModified: Date.now()
                        });
                        resolve(resultFile);
                    }, 'image/jpeg', quality);
                };
                img.onerror = reject;
                img.src = e.target.result;
            };
            reader.onerror = reject;
            reader.readAsDataURL(file);
        });
    }

    function handleGallerySubmit(e) {
        if (!fileInput.files || fileInput.files.length === 0) {
            e.preventDefault();
            imageErrorLabel.textContent = 'অনুগ্রহ করে গ্যালারির জন্য একটি ছবি নির্বাচন করুন।';
            imageErrorLabel.classList.remove('hidden');
            dropArea.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }

        const submitBtn = document.getElementById('submitBtn');
        const submitIcon = document.getElementById('submitIcon');
        const submitText = document.getElementById('submitText');

        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
        submitIcon.className = 'fa-solid fa-spinner fa-spin';
        submitText.textContent = 'ছবি আপলোড হচ্ছে...';
        return true;
    }
</script>
@endsection
