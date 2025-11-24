{{-- 1. CDN DRIVER.JS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css"/>
<script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>

{{-- 2. CUSTOM CSS --}}
<style>
    /* Tema Driver.js */
    .driver-popover.driverjs-theme {
        background-color: #f0ebe3;
        color: #000;
        border: 4px solid #000;
        border-radius: 1.5rem;
        box-shadow: 0.5vh 0.5vh 0 #000;
        font-family: 'HammersmithOne-Regular', sans-serif;
        padding: 1rem;
    }
    .driver-popover.driverjs-theme .driver-popover-title {
        font-size: 1.25rem; font-weight: bold; color: #000; margin-bottom: 0.5rem;
    }
    .driver-popover.driverjs-theme .driver-popover-description {
        font-size: 0.9rem; line-height: 1.5; color: #333; margin-bottom: 1rem;
    }
    .driver-popover.driverjs-theme button {
        background-color: #a2e1db; color: #000; border: 2px solid #000;
        border-radius: 0.5rem; padding: 0.5rem 1rem; font-weight: bold;
        text-shadow: none; transition: all 0.2s; margin: 0.2rem;
    }
    .driver-popover.driverjs-theme button:hover {
        background-color: #b4a6d5; transform: translateY(-2px); box-shadow: 2px 2px 0 #000;
    }
    .driver-popover-close-btn { color: #000 !important; font-weight: bold; background-color: transparent!important;  margin: 1rem !important;; padding: 0.1rem 0.1rem !important; }
</style>

{{-- 3. SECTION UTAMA: READY TO BUY --}}
<div id="readyToBuy" class="my-16 bg-[#f0ebe3] rounded-3xl border-4 border-black shadow-[3vh_3vh_0_black] p-6 sm:p-10 flex flex-col h-[100vh] relative z-10">
    
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-center md:justify-center items-center mb-8 gap-4 relative z-20">
        <div class="flex items-center gap-3 justify-center w-full md:w-auto relative">
            <h2 id="tourTitle" class="text-2xl sm:text-3xl text-center text-gray-800 font-[HammersmithOne-Regular]">
                READY-TO-BUY DESIGNS
            </h2>
            {{-- Tombol Info (Trigger Tour Manual) --}}
            <button id="manualInfoBtn" type="button"
                class="md:absolute md:right-[-50px] w-10 h-10 rounded-full border-2 border-black bg-[#a2e1db] text-black font-bold flex items-center justify-center hover:bg-[#b4a6d5] hover:scale-110 transition-all shadow-[2px_2px_0_black] z-30 cursor-pointer"
                title="Start Tutorial">
                <span class="text-lg italic font-serif">i</span>
            </button>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 flex-1 min-h-0 relative z-10">
        
        {{-- KIRI: PREVIEW PANEL --}}
        <div id="previewPanel" class="flex-1 border-4 border-black rounded-3xl shadow-[0.8vh_0.8vh_0_black] p-6 flex flex-col bg-[#f0ebe3] transition-all duration-300">
            <div class="flex flex-row items-center justify-between">
                <div class="flex flex-col">
                    <h3 class="text-2xl mb-2 text-gray-800 font-[HammersmithOne-Regular]">Preview</h3>
                    <p id="previewTitle" class="text-sm text-gray-600 italic mb-2 font-[HammersmithOne-Regular] line-clamp-1">Select a Design</p>
                </div>
                <div class="flex items-center justify-center">
                    <button id="previewFullImageButton" disabled
                        class="px-3 py-2 rounded-md border-2 border-black bg-white hover:bg-gray-100 font-[HammersmithOne-Regular] text-sm font-bold shadow-[2px_2px_0_black] active:shadow-none active:translate-y-[2px] transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        View Full
                    </button>
                </div>
            </div>

            {{-- Kotak Gambar Preview --}}
            <div class="w-full aspect-square bg-white rounded-2xl overflow-hidden flex justify-center items-center border-4 border-black relative mb-6">
                <img id="previewImage" src="" alt="Preview" class="w-full h-full object-cover hidden transition-opacity duration-300">
                <div id="previewPlaceholder" class="absolute inset-0 flex flex-col items-center justify-center bg-gradient-to-br from-[#dceef4] to-[#c6e3f0] text-center p-4">
                    <svg class="w-16 h-16 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <p class="text-gray-600 text-sm font-medium font-[HammersmithOne-Regular]">Click an image<br>to preview</p>
                </div>
            </div>

            {{-- Detail & Tombol Buy --}}
            <div class="w-full space-y-3 mt-auto">
                <div id="priceInfoBox" class="bg-white border-3 border-black rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-3 font-[HammersmithOne-Regular]">
                        <span class="text-xs font-bold text-gray-700">FILE FORMAT:</span>
                        <span id="previewFormat" class="px-3 py-1 bg-[#a2e1db] border-2 border-black rounded-full text-xs font-bold shadow-[0.2vh_0.2vh_0_black]">-</span>
                    </div>
                    <div class="flex items-center justify-between bg-gradient-to-r from-[#e3f2fd] to-[#f3e5f5] border-2 border-black rounded-lg p-3 font-[HammersmithOne-Regular]">
                        <span class="text-sm font-bold text-gray-800">Price:</span>
                        <span id="previewPrice" class="text-xl font-bold text-[#2563eb]">-</span>
                    </div>
                </div>
                <button id="buyButton" disabled
                    class="w-full bg-[#4c9eff] border-3 border-black px-6 py-3 rounded-xl font-bold text-white text-lg hover:bg-[#73b7ff] transition-all duration-300 shadow-[0.4vh_0.4vh_0_black] font-[HammersmithOne-Regular] active:shadow-none active:translate-y-[2px] disabled:opacity-50 disabled:cursor-not-allowed">
                    Buy Now
                </button>
            </div>
        </div>

        {{-- KANAN: DESIGN GRID --}}
        <div id="designGrid" class="flex-1 min-h-0 overflow-y-auto pr-2 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-4 sm:gap-5 auto-rows-max content-start pb-10">
            @forelse ($allGalleryExceptNotSold as $design)
                @php
                    $imageUrl = asset($design->image_url);
                    $isReservedOrSold = in_array($design->status, ['reserved', 'sold']);
                    $imageStatus = $design->status;
                @endphp
                {{-- Item Grid --}}
                <div class="design-item cursor-pointer rounded-2xl border-4 border-black shadow-[0.5vh_0.5vh_0_black] aspect-square relative overflow-visible group z-0 transition-transform active:scale-95 bg-white"
                    data-id="{{ $design->gallery_id }}"
                    data-title="{{ $design->title }}"
                    data-price="{{ $design->price }}" 
                    data-format="{{ $design->file_format ?? 'JPG/PNG' }}"
                    data-image="{{ $imageUrl }}"
                    data-status="{{ $imageStatus }}">
                    
                    <div class="w-full h-full overflow-hidden bg-white rounded-lg">
                        <img src="{{ $imageUrl }}" alt="{{ $design->title }}"
                            class="w-full h-full object-cover group-hover:brightness-110 transition-all"
                            loading="lazy"
                            onerror="handleBrokenImage(this)">
                    </div>
                    @if ($isReservedOrSold)
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center rounded-lg pointer-events-none">
                            <div class="{{ $imageStatus == 'sold' ? 'bg-red-500 text-white' : 'bg-yellow-400 text-black' }} px-4 py-2 rounded-full text-xs font-bold border-2 border-black font-[HammersmithOne-Regular] transform -rotate-12 shadow-lg">
                                {{ strtoupper($imageStatus) }}
                            </div>
                        </div>
                    @else
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-lg pointer-events-none">
                            <p class="text-white text-xs font-bold truncate font-[HammersmithOne-Regular]">{{ $design->title }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <p class="col-span-full text-center text-gray-600 py-8 font-medium font-[HammersmithOne-Regular]">No designs available yet</p>
            @endforelse
        </div>
    </div>
</div>

{{-- 4. SCROLL POP-UP (WELCOME DIALOG) --}}
<div id="scrollWelcomePopup" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/60 p-4 font-[HammersmithOne-Regular] backdrop-blur-sm">
    <div class="bg-[#f0ebe3] w-full max-w-md rounded-3xl border-4 border-black shadow-[1vh_1vh_0_#b4a6d5] overflow-hidden transform scale-95 opacity-0 transition-all duration-300 relative" id="scrollWelcomeCard">
        {{-- Header PopUp --}}
        <div class="bg-[#a2e1db] border-b-4 border-black p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-white rounded-full border-2 border-black flex items-center justify-center shadow-[2px_2px_0_black]">
                <span class="text-2xl">👋</span>
            </div>
            <div>
                <h3 class="text-xl font-bold leading-tight text-gray-900">Welcome to Shop!</h3>
                <p class="text-xs text-gray-700 font-bold">Adopt your favorite art</p>
            </div>
            {{-- Tombol Close X --}}
            <button id="closeScrollPopupX" class="absolute right-4 top-4 text-black font-bold hover:text-red-600">✕</button>
        </div>
        
        {{-- Body Content --}}
        <div class="p-6 text-gray-800 space-y-3">
            <p class="text-lg font-bold">Hi there! ✨</p>
            <p class="text-sm leading-relaxed">
                You can buy my exclusive designs directly here. The process is simple: <strong>Pick, Preview, and Buy!</strong>
            </p>
            <div class="bg-yellow-100 border-2 border-black p-3 rounded-xl text-xs flex gap-2 items-start">
                <span class="text-lg">💡</span>
                <p>Need a guide? Click the button below or the <strong>'i'</strong> icon anytime.</p>
            </div>
        </div>

        {{-- Footer Buttons --}}
        <div class="p-4 bg-[#f0ebe3] border-t-4 border-black flex flex-col sm:flex-row gap-3">
            <button id="startTourBtnFromPopup" class="flex-1 bg-[#4c9eff] text-white border-2 border-black px-4 py-3 rounded-xl font-bold shadow-[2px_2px_0_black] active:translate-y-1 active:shadow-none transition-all hover:bg-[#3b82f6]">
                Start Tutorial 🚀
            </button>
            <button id="closeScrollPopup" class="flex-1 bg-gray-200 text-gray-800 border-2 border-black px-4 py-3 rounded-xl font-bold hover:bg-gray-300 transition-all">
                Just Browsing
            </button>
        </div>
    </div>
</div>

{{-- 5. SCRIPT UTAMA (GABUNGAN SEMUA LOGIC) --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log("=== ALL-IN-ONE SCRIPT LOADED (FIXED BACK BUTTON) ===");

        // --- DEFINISI ELEMENT ---
        const grid = document.getElementById('designGrid');
        const buyButton = document.getElementById('buyButton');
        const fullImgBtn = document.getElementById('previewFullImageButton');
        const previewTitle = document.getElementById('previewTitle');
        const previewPrice = document.getElementById('previewPrice');
        const previewFormat = document.getElementById('previewFormat');
        const previewImage = document.getElementById('previewImage');
        const previewPlaceholder = document.getElementById('previewPlaceholder');

        // Modal Elements
        const modal = document.getElementById('purchaseModal'); 
        const closeModalBtn = document.getElementById('closeModalButton');
        const modalTitle = document.getElementById('modalItemTitle');
        const modalPrice = document.getElementById('modalItemPrice');
        const modalImage = document.getElementById('modalItemImage'); 
        const modalFormat = document.getElementById('modalItemFormat'); 
        const modalStatus = document.getElementById('modalItemStatus'); 
        const modalIdInput = document.getElementById('gallery_id');
        const fileInput = document.getElementById('paymentProof');
        const fileLabel = document.getElementById('paymentProofName');

        // Scroll Popup Elements
        const scrollPopup = document.getElementById('scrollWelcomePopup');
        const scrollCard = document.getElementById('scrollWelcomeCard');
        const btnStartTour = document.getElementById('startTourBtnFromPopup');
        const btnCloseScroll = document.getElementById('closeScrollPopup');
        const btnCloseScrollX = document.getElementById('closeScrollPopupX');
        const sectionReady = document.getElementById('readyToBuy');

        // State Data
        let selectedDesign = null;

        const formatRupiah = (num) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(num);

        // ==========================================
        // A. INPUT FILE CUSTOM LOGIC
        // ==========================================
        if(fileInput && fileLabel) {
            fileInput.addEventListener('change', function(e) {
                fileLabel.textContent = (this.files && this.files.length > 0) ? this.files[0].name : "No file chosen";
            });
        }

        // ==========================================
        // B. LOGIKA PREVIEW GAMBAR
        // ==========================================
        if(grid) {
            grid.addEventListener('click', function(e) {
                const item = e.target.closest('.design-item');
                if(!item) return;

                const d = item.dataset;
                const status = d.status || 'available';
                
                selectedDesign = {
                    id: d.id, title: d.title, priceRaw: d.price, 
                    priceFormatted: String(d.price).includes('Rp') ? d.price : formatRupiah(d.price),
                    image: d.image, format: d.format, status: status
                };

                // UI Update
                if(previewTitle) previewTitle.textContent = selectedDesign.title;
                if(previewFormat) previewFormat.textContent = selectedDesign.format;
                if(previewPrice) previewPrice.textContent = selectedDesign.priceFormatted;
                
                if(previewImage && selectedDesign.image) {
                    previewImage.src = selectedDesign.image;
                    previewImage.classList.remove('hidden');
                    if(previewPlaceholder) previewPlaceholder.classList.add('hidden');
                }

                // Button State
                if(status === 'sold' || status === 'reserved') {
                    if(buyButton) {
                        buyButton.disabled = true;
                        buyButton.textContent = status === 'sold' ? 'Sold Out' : 'Reserved';
                        buyButton.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                } else {
                    if(buyButton) {
                        buyButton.disabled = false;
                        buyButton.textContent = 'Buy Now';
                        buyButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                }
                if(fullImgBtn) fullImgBtn.disabled = false;
            });
        }

        // ==========================================
        // C. LOGIKA MODAL PEMBELIAN (Fixed)
        // ==========================================
        const openPurchaseModal = () => {
            if(!modal) return console.error("Modal not found");
            if(!selectedDesign) return console.warn("No design selected");

            if(modalTitle) modalTitle.textContent = selectedDesign.title;
            if(modalPrice) modalPrice.textContent = selectedDesign.priceFormatted;
            if(modalImage) modalImage.src = selectedDesign.image;
            if(modalFormat) modalFormat.textContent = selectedDesign.format;
            
            if(modalStatus) {
                modalStatus.textContent = selectedDesign.status.toUpperCase();
                modalStatus.className = selectedDesign.status === 'sold' 
                    ? "text-xs font-semibold px-3 py-1 rounded-full bg-red-200 text-red-800"
                    : "text-xs font-semibold px-3 py-1 rounded-full bg-green-200 text-green-800";
            }
            if(modalIdInput) modalIdInput.value = selectedDesign.id;

            modal.style.display = 'flex'; // Paksa display flex
        };

        const closePurchaseModal = () => { if(modal) modal.style.display = 'none'; };

        if(buyButton) {
            buyButton.addEventListener('click', (e) => { e.preventDefault(); if(!buyButton.disabled) openPurchaseModal(); });
        }
        if(closeModalBtn) closeModalBtn.addEventListener('click', closePurchaseModal);
        if(modal) modal.addEventListener('click', (e) => { if(e.target === modal) closePurchaseModal(); });


        // ==========================================
        // D. DRIVER.JS TUTORIAL (FIXED BACK BUTTON)
        // ==========================================
        const driver = window.driver.js.driver;
        const btnOpenInfo = document.getElementById('manualInfoBtn');
        
        const driverObj = driver({
            showProgress: true, animate: true, allowClose: true,
            popoverClass: 'driverjs-theme',
            steps: [
                { element: '#readyToBuy h2', popover: { title: 'Welcome!', description: 'Let me show you how to adopt an art.' } },
                { 
                    element: '#designGrid', 
                    popover: { title: '1. Select Design', description: 'Click an available image here.' },
                    onHighlightStarted: () => {
                        const item = document.querySelector('.design-item[data-status="available"]');
                        if(item) item.click();
                    }
                },
                { element: '#previewPanel', popover: { title: '2. Check Details', description: 'Preview, price, and format appear here.' } },
                
                // --- STEP 3 (BUY BUTTON) ---
                { 
                    element: '#buyButton', 
                    popover: { title: '3. Click Buy', description: 'Press this to open the form.' },
                    // PERBAIKAN DISINI:
                    // Saat tutorial masuk ke step ini (baik dari Next maupun Back dari step 4),
                    // Kita paksa TUTUP modalnya. Jadi kalau user klik Back dari form, formnya hilang.
                    onHighlightStarted: () => {
                        closePurchaseModal();
                    }
                },

                // --- STEP 4 (MODAL FORM) ---
                { 
                    element: '#purchaseModal', 
                    popover: { title: '4. Fill The Form', description: 'Double check the item details.' },
                    onHighlightStarted: () => {
                        // Setup Data Dummy jika user belum klik apa-apa
                        if(!selectedDesign) {
                            selectedDesign = { id: '0', title: 'Tutorial Artwork', priceFormatted: 'Rp 100.000', image: 'https://via.placeholder.com/300', format: 'PNG', status: 'available' };
                        }
                        // Paksa BUKA Modal saat masuk step ini
                        openPurchaseModal();
                    }
                },
                { element: '#email', popover: { title: '5. Your Email', description: 'Files will be sent here.' } },
                { element: '#paymentProofLabel', popover: { title: '6. Payment Proof', description: 'Scan QRIS and upload screenshot here.' } },
                { 
                    element: '#submitButton', 
                    popover: { title: 'All Set!', description: 'Click submit and wait for verification.' },
                    // Tutup modal saat selesai
                    onDeselected: () => { closePurchaseModal(); } 
                }
            ],
            // Jaga-jaga jika user close paksa di tengah jalan
            onDestroyed: () => { closePurchaseModal(); }
        });

        const startTutorial = () => {
            if(!document.querySelector('.design-item[data-status="available"]')) {
                alert("No items available for tutorial currently.");
                return;
            }
            driverObj.drive();
        };

        if(btnOpenInfo) {
            btnOpenInfo.addEventListener('click', (e) => { e.preventDefault(); e.stopPropagation(); startTutorial(); });
        }


        // ==========================================
        // E. SCROLL POP-UP LOGIC
        // ==========================================
        const openScrollPopup = () => {
            if(!scrollPopup) return;
            scrollPopup.classList.remove('hidden');
            scrollPopup.classList.add('flex');
            setTimeout(() => {
                scrollCard.classList.remove('scale-95', 'opacity-0');
                scrollCard.classList.add('scale-100', 'opacity-100');
            }, 50);
        };

        const closeScrollPopup = () => {
            if(!scrollPopup) return;
            scrollCard.classList.remove('scale-100', 'opacity-100');
            scrollCard.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                scrollPopup.classList.add('hidden');
                scrollPopup.classList.remove('flex');
            }, 300);
        };

        if(btnCloseScroll) btnCloseScroll.addEventListener('click', closeScrollPopup);
        if(btnCloseScrollX) btnCloseScrollX.addEventListener('click', closeScrollPopup);
        
        if(btnStartTour) {
            btnStartTour.addEventListener('click', () => {
                closeScrollPopup();
                setTimeout(() => {
                    startTutorial();
                }, 400);
            });
        }

        if(sectionReady && scrollPopup) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if(entry.isIntersecting) {
                        if(!sessionStorage.getItem('hasSeenScrollPopup')) {
                            openScrollPopup();
                            sessionStorage.setItem('hasSeenScrollPopup', 'true');
                        }
                    }
                });
            }, { threshold: 0.3 });
            
            observer.observe(sectionReady);
        }
    });
</script>