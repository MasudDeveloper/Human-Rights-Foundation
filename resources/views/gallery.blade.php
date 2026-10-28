@extends('layouts.app')

@section('title', 'ফটো গ্যালারি')

@section('content')
<div class="bg-slate-50 min-h-screen py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Simple Clean Header -->
        <div class="text-center max-w-xl mx-auto mb-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                ফটো গ্যালারি
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1.5">
                সংস্থার কেন্দ্রীয় ও মাঠপর্যায়ের বিভিন্ন কার্যক্রম ও কর্মসূচির আলোকচিত্র
            </p>
        </div>

        <!-- Category Filters -->
        @if(isset($categories) && $categories->count() > 0)
            <div class="flex flex-wrap items-center justify-center gap-2 mb-7">
                <a href="{{ route('gallery') }}" 
                   class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $currentCategory === 'all' ? 'bg-slate-900 text-amber-400 shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                    সকল ছবি
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('gallery', ['category' => $cat]) }}" 
                       class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $currentCategory === $cat ? 'bg-slate-900 text-amber-400 shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Photo Grid -->
        @if($photos->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-5">
                @foreach($photos as $index => $photo)
                    <div class="group bg-white rounded-xl sm:rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col cursor-pointer"
                         onclick="openGalleryModal({{ $index }})">
                        
                        <!-- Photo Image -->
                        <div class="relative aspect-[4/3] bg-slate-100 overflow-hidden">
                            <img src="{{ $photo->image_url }}" 
                                 alt="{{ $photo->title }}" 
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            
                            @if($photo->category)
                                <span class="absolute top-2 left-2 bg-slate-950/75 text-amber-300 text-[10px] font-bold px-2 py-0.5 rounded-md backdrop-blur-xs">
                                    {{ $photo->category }}
                                </span>
                            @endif
                        </div>

                        <!-- Simple Photo Caption -->
                        <div class="p-3 flex-grow flex flex-col justify-between">
                            <h3 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-amber-600 transition line-clamp-2 leading-snug">
                                {{ $photo->title }}
                            </h3>

                            @if($photo->formatted_date)
                                <p class="text-[11px] text-slate-400 mt-2 flex items-center">
                                    <i class="fa-regular fa-calendar mr-1.5 text-amber-500"></i>
                                    {{ $photo->formatted_date }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $photos->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl p-10 text-center max-w-sm mx-auto border border-slate-200 shadow-sm">
                <i class="fa-regular fa-images text-4xl text-slate-300 mb-2 block"></i>
                <h3 class="text-sm font-bold text-slate-800">কোনো ছবি পাওয়া যায়নি</h3>
                <p class="text-xs text-slate-500 mt-1">নির্বাচিত ক্যাটাগরিতে এখনো কোনো ছবি নেই।</p>
                @if($currentCategory !== 'all')
                    <a href="{{ route('gallery') }}" class="inline-block mt-3 px-3.5 py-1.5 rounded-lg text-xs font-bold bg-slate-900 text-amber-400">
                        সকল ছবি দেখুন
                    </a>
                @endif
            </div>
        @endif

    </div>
</div>

<!-- ================= Simple Lightbox Modal ================= -->
<div id="galleryLightboxModal" class="fixed inset-0 z-50 bg-black/95 backdrop-blur-sm hidden flex-col justify-between select-none" onclick="handleBackdropClick(event)">
    
    <!-- Top Header: Counter & Close -->
    <div class="flex items-center justify-between px-4 sm:px-6 py-3 text-white z-10">
        <span class="text-xs font-mono font-bold text-slate-300" id="modalCounter">
            ১ / ৩
        </span>
        <button type="button" onclick="closeGalleryModal()" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer" title="বন্ধ করুন (Esc)">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>
    </div>

    <!-- Center Stage: Prev + Image + Next -->
    <div class="relative flex-grow flex items-center justify-center px-2 sm:px-16 overflow-hidden">
        
        <!-- Prev Button -->
        <button type="button" 
                onclick="prevGalleryImage(event)" 
                class="absolute left-2 sm:left-4 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/60 hover:bg-amber-500 text-white hover:text-slate-950 flex items-center justify-center text-lg sm:text-xl transition cursor-pointer"
                title="পূর্ববর্তী ছবি">
            <i class="fa-solid fa-chevron-left"></i>
        </button>

        <!-- Main Image -->
        <img id="modalMainImage" 
             src="" 
             alt="Gallery Image" 
             class="max-w-full max-h-[75vh] object-contain rounded-lg shadow-2xl transition-opacity duration-200">

        <!-- Next Button -->
        <button type="button" 
                onclick="nextGalleryImage(event)" 
                class="absolute right-2 sm:right-4 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/60 hover:bg-amber-500 text-white hover:text-slate-950 flex items-center justify-center text-lg sm:text-xl transition cursor-pointer"
                title="পরবর্তী ছবি">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>

    <!-- Bottom Caption -->
    <div class="px-4 py-3 text-center text-white bg-black/60 border-t border-white/10">
        <h2 class="text-xs sm:text-sm font-bold text-amber-300" id="modalTitle"></h2>
        <p class="text-[11px] text-slate-400 mt-0.5" id="modalSubtext"></p>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const galleryItems = [
        @foreach($photos as $photo)
            {
                id: {{ $photo->id }},
                title: @json($photo->title),
                category: @json($photo->category ?? ''),
                date: @json($photo->formatted_date ?? ''),
                imageUrl: @json($photo->image_url),
            },
        @endforeach
    ];

    let currentPhotoIndex = 0;
    const modal = document.getElementById('galleryLightboxModal');
    const modalImage = document.getElementById('modalMainImage');
    const modalTitle = document.getElementById('modalTitle');
    const modalSubtext = document.getElementById('modalSubtext');
    const modalCounter = document.getElementById('modalCounter');

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

    function handleBackdropClick(e) {
        if (e.target === modal || e.target.id === 'galleryLightboxModal') {
            closeGalleryModal();
        }
    }

    function updateModalContent() {
        const item = galleryItems[currentPhotoIndex];
        if (!item) return;

        modalImage.src = item.imageUrl;
        modalTitle.textContent = item.title;
        
        let sub = [];
        if (item.category) sub.push(item.category);
        if (item.date) sub.push('তারিখ: ' + item.date);
        modalSubtext.textContent = sub.join(' • ');
        
        modalCounter.textContent = (currentPhotoIndex + 1) + ' / ' + galleryItems.length;
    }

    function nextGalleryImage(e) {
        if (e) e.stopPropagation();
        if (galleryItems.length === 0) return;
        currentPhotoIndex = (currentPhotoIndex + 1) % galleryItems.length;
        updateModalContent();
    }

    function prevGalleryImage(e) {
        if (e) e.stopPropagation();
        if (galleryItems.length === 0) return;
        currentPhotoIndex = (currentPhotoIndex - 1 + galleryItems.length) % galleryItems.length;
        updateModalContent();
    }

    // Keyboard Navigation
    window.addEventListener('keydown', (e) => {
        if (modal.classList.contains('hidden')) return;

        if (e.key === 'ArrowRight') {
            nextGalleryImage();
        } else if (e.key === 'ArrowLeft') {
            prevGalleryImage();
        } else if (e.key === 'Escape') {
            closeGalleryModal();
        }
    });

    // Mobile Swipe Gesture
    let touchStartX = 0;
    let touchEndX = 0;

    modal.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    }, false);

    modal.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        const diffX = touchEndX - touchStartX;
        if (Math.abs(diffX) > 40) {
            if (diffX < 0) nextGalleryImage();
            else prevGalleryImage();
        }
    }, false);
</script>
@endsection
