@extends('layouts.app')

@section('title', 'কার্যক্রম ও ফটো গ্যালারি')

@section('content')
<div class="bg-slate-50 min-h-screen py-10 sm:py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="text-center max-w-3xl mx-auto mb-10">
            <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-extrabold bg-amber-500/10 text-amber-700 border border-amber-300 mb-2">
                <i class="fa-solid fa-camera-retro mr-1.5 text-amber-600"></i>সচিত্র প্রতিবেদন ও ফটো আর্কাইভ
            </span>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                কার্যক্রম ও ফটো গ্যালারি
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">
                আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশনের কেন্দ্রীয় ও মাঠপর্যায়ের কার্যক্রম, সম্মেলন, আইনি সহায়তা ও সচেতনতামূলক কর্মকাণ্ডের আলোকচিত্রসমূহ
            </p>
        </div>

        <!-- Filter Categories -->
        <div class="flex flex-wrap items-center justify-center gap-2 mb-8">
            <a href="{{ route('gallery') }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition shadow-sm {{ $currentCategory === 'all' ? 'bg-brand-900 text-amber-300 shadow-md ring-2 ring-amber-400/50' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                <i class="fa-solid fa-layer-group mr-1.5"></i>সকল ছবি
            </a>

            @foreach($categories as $cat)
                <a href="{{ route('gallery', ['category' => $cat]) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold transition shadow-sm {{ $currentCategory === $cat ? 'bg-brand-900 text-amber-300 shadow-md ring-2 ring-amber-400/50' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        <!-- Photo Grid -->
        @if($photos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="photoGalleryGrid">
                @foreach($photos as $index => $photo)
                    <div class="group bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col cursor-pointer transform hover:-translate-y-1"
                         onclick="openGalleryModal({{ $index }})">
                        
                        <!-- Image Container with Hover Zoom & Action Overlay -->
                        <div class="relative aspect-[4/3] bg-slate-100 overflow-hidden">
                            <img src="{{ $photo->image_url }}" 
                                 alt="{{ $photo->title }}" 
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                            <!-- Category Badge -->
                            <span class="absolute top-2.5 left-2.5 bg-brand-950/80 backdrop-blur-md text-amber-300 border border-amber-400/30 text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow">
                                {{ $photo->category }}
                            </span>

                            <!-- Center Zoom / View Icon Overlay -->
                            <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <span class="w-11 h-11 rounded-full bg-amber-400 text-slate-950 flex items-center justify-center text-sm font-bold shadow-lg transform scale-75 group-hover:scale-100 transition-transform duration-300">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-4 flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="text-sm font-bold text-slate-900 group-hover:text-brand-700 transition line-clamp-2 leading-snug">
                                    {{ $photo->title }}
                                </h3>

                                @if($photo->description)
                                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                        {{ $photo->description }}
                                    </p>
                                @endif
                            </div>

                            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                                <span class="flex items-center">
                                    <i class="fa-regular fa-calendar mr-1.5 text-amber-500"></i>
                                    {{ $photo->formatted_date }}
                                </span>
                                <span class="text-brand-700 font-semibold group-hover:underline flex items-center">
                                    দেখুন <i class="fa-solid fa-arrow-right text-[9px] ml-1"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                {{ $photos->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-3xl p-12 text-center max-w-md mx-auto border border-slate-200 shadow-sm">
                <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-2xl mx-auto mb-4 border border-amber-200">
                    <i class="fa-regular fa-images"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900">গ্যালারিতে কোনো ছবি পাওয়া যায়নি</h3>
                <p class="text-xs text-slate-500 mt-1">নির্বাচিত ক্যাটাগরিতে এখনো কোনো ছবি আপলোড করা হয়নি।</p>
                @if($currentCategory !== 'all')
                    <a href="{{ route('gallery') }}" class="inline-flex items-center px-4 py-2 mt-4 rounded-xl text-xs font-bold bg-brand-900 text-amber-300 hover:bg-brand-800 transition">
                        সকল ছবি দেখুন
                    </a>
                @endif
            </div>
        @endif

    </div>
</div>

<!-- ================= Interactive In-Page Lightbox Modal ================= -->
<div id="galleryLightboxModal" class="fixed inset-0 z-50 bg-slate-950/95 backdrop-blur-md hidden flex-col justify-between select-none">
    
    <!-- Top Action Bar -->
    <div class="flex items-center justify-between px-4 sm:px-8 py-3.5 border-b border-white/10 text-white z-10 bg-slate-950/60">
        <!-- Photo Counter & Category -->
        <div class="flex items-center space-x-3 text-xs sm:text-sm font-semibold">
            <span class="bg-amber-500 text-slate-950 px-2.5 py-0.5 rounded-full text-xs font-bold font-mono" id="modalCounter">
                ১ / ১২
            </span>
            <span class="text-slate-300 hidden sm:inline" id="modalCategory">
                ক্যাটাগরি
            </span>
        </div>

        <!-- Controls: Fullscreen & Close -->
        <div class="flex items-center space-x-2">
            <button type="button" onclick="toggleLightboxFullscreen()" class="w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition" title="ফুলস্ক্রিন">
                <i class="fa-solid fa-expand text-sm"></i>
            </button>
            <button type="button" onclick="closeGalleryModal()" class="w-9 h-9 rounded-xl bg-white/10 hover:bg-rose-600 text-white flex items-center justify-center transition" title="বন্ধ করুন (Esc)">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
    </div>

    <!-- Center Stage: Prev Button + Image + Next Button -->
    <div class="relative flex-grow flex items-center justify-center p-3 sm:p-6 overflow-hidden">
        
        <!-- Prev Button -->
        <button type="button" 
                onclick="prevGalleryImage()" 
                id="modalPrevBtn"
                class="absolute left-2 sm:left-6 z-20 w-11 h-11 sm:w-14 sm:h-14 rounded-full bg-slate-900/80 hover:bg-amber-500 text-white hover:text-slate-950 flex items-center justify-center text-base sm:text-xl shadow-2xl border border-white/15 transition transform hover:scale-110 active:scale-95 cursor-pointer"
                title="পূর্ববর্তী ছবি (বাম তীর / ←)">
            <i class="fa-solid fa-chevron-left"></i>
        </button>

        <!-- Current Active Image -->
        <div class="max-w-5xl max-h-[72vh] flex items-center justify-center transition-all duration-200" id="modalImageContainer">
            <img id="modalMainImage" 
                 src="" 
                 alt="Gallery Image" 
                 class="max-w-full max-h-[72vh] object-contain rounded-2xl shadow-2xl border border-white/10">
        </div>

        <!-- Next Button -->
        <button type="button" 
                onclick="nextGalleryImage()" 
                id="modalNextBtn"
                class="absolute right-2 sm:right-6 z-20 w-11 h-11 sm:w-14 sm:h-14 rounded-full bg-slate-900/80 hover:bg-amber-500 text-white hover:text-slate-950 flex items-center justify-center text-base sm:text-xl shadow-2xl border border-white/15 transition transform hover:scale-110 active:scale-95 cursor-pointer"
                title="পরবর্তী ছবি (ডান তীর / →)">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>

    <!-- Bottom Bar: Title, Description & Date -->
    <div class="px-4 sm:px-8 py-3.5 border-t border-white/10 bg-slate-950/80 text-white">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-sm sm:text-base font-bold text-amber-300 leading-snug" id="modalTitle">
                ছবির শিরোনাম
            </h2>
            <p class="text-xs text-slate-300 mt-1 max-w-2xl mx-auto line-clamp-2" id="modalDescription">
                ছবির বিস্তারিত বিবরণ
            </p>
            <p class="text-[11px] text-slate-400 mt-1" id="modalDate">
                তারিখ
            </p>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Gallery Data Array
    const galleryItems = [
        @foreach($photos as $photo)
            {
                id: {{ $photo->id }},
                title: @json($photo->title),
                category: @json($photo->category),
                description: @json($photo->description ?? ''),
                date: @json($photo->formatted_date),
                imageUrl: @json($photo->image_url),
            },
        @endforeach
    ];

    let currentPhotoIndex = 0;
    const modal = document.getElementById('galleryLightboxModal');
    const modalImage = document.getElementById('modalMainImage');
    const modalTitle = document.getElementById('modalTitle');
    const modalDescription = document.getElementById('modalDescription');
    const modalDate = document.getElementById('modalDate');
    const modalCounter = document.getElementById('modalCounter');
    const modalCategory = document.getElementById('modalCategory');

    function openGalleryModal(index) {
        if (!galleryItems.length || index < 0 || index >= galleryItems.length) return;
        currentPhotoIndex = index;
        updateModalContent();
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeGalleryModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    function updateModalContent() {
        const item = galleryItems[currentPhotoIndex];
        if (!item) return;

        modalImage.src = item.imageUrl;
        modalTitle.textContent = item.title;
        modalDescription.textContent = item.description || '';
        modalDescription.style.display = item.description ? 'block' : 'none';
        modalDate.textContent = item.date ? 'তারিখ: ' + item.date : '';
        modalCategory.textContent = item.category || 'কার্যক্রম';
        modalCounter.textContent = (currentPhotoIndex + 1) + ' / ' + galleryItems.length;
    }

    function nextGalleryImage() {
        if (galleryItems.length === 0) return;
        currentPhotoIndex = (currentPhotoIndex + 1) % galleryItems.length;
        updateModalContent();
    }

    function prevGalleryImage() {
        if (galleryItems.length === 0) return;
        currentPhotoIndex = (currentPhotoIndex - 1 + galleryItems.length) % galleryItems.length;
        updateModalContent();
    }

    function toggleLightboxFullscreen() {
        if (!document.fullscreenElement) {
            modal.requestFullscreen().catch(err => console.log(err));
        } else {
            document.exitFullscreen().catch(err => console.log(err));
        }
    }

    // Keyboard Arrow Keys Navigation
    window.addEventListener('keydown', (e) => {
        if (modal.classList.contains('hidden')) return;

        if (e.key === 'ArrowRight' || e.key === 'Right') {
            nextGalleryImage();
        } else if (e.key === 'ArrowLeft' || e.key === 'Left') {
            prevGalleryImage();
        } else if (e.key === 'Escape') {
            closeGalleryModal();
        }
    });

    // Touch swipe support for mobile devices
    let touchStartX = 0;
    let touchEndX = 0;

    modal.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    }, false);

    modal.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipeGesture();
    }, false);

    function handleSwipeGesture() {
        const diffX = touchEndX - touchStartX;
        if (Math.abs(diffX) > 50) {
            if (diffX < 0) {
                nextGalleryImage(); // Swipe Left -> Next
            } else {
                prevGalleryImage(); // Swipe Right -> Prev
            }
        }
    }
</script>
@endsection
