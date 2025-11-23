@extends('template')

@section('content')
    {{-- Latar belakang utama --}}
    <div class="min-h-screen p-2 sm:p-4 mt-4 sm:mt-8 flex justify-center items-start font-[HammersmithOne-Regular]">
        <div class="container w-full sm:w-[95%] lg:w-[80%]">
            {{-- Header & Navigasi --}}
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 sm:gap-0">
                <div
                    class="bg-[#f0ebe3] rounded-t-3xl h-full py-4 sm:py-6 px-8 sm:px-20 shadow-black sm-h-full order-2 sm:order-1">
                    <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-5xl text-bold font-[HammersmithOne-Regular]">Cho's
                        Studio</h1>
                </div>
                <div class="flex h-full order-1 sm:order-2 overflow-visible max-sm:gap-3 max-sm:justify-center">
                    {{-- Tombol Navigasi --}}
                    <div
                        class="font-[HammersmithOne-Regular] bg-pastel-turqoise h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-l-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap">
                        <button onclick="window.location.href='/'">Home</button>
                    </div>
                    <div
                        class="font-[HammersmithOne-Regular] bg-pastel-turqoise h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-l-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap">
                        <button onclick="window.location.href='/gallery'">Gallery</button>
                    </div>
                    <div
                        class="font-[HammersmithOne-Regular] bg-pastel-turqoise h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-l-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap">
                        <button>Shop</button>
                    </div>
                    {{-- Tombol Member --}}
                    <div class="relative inline-block">
                        <div class="absolute top-1.5 left-1.5 w-full bg-black rounded-t-2xl z-[-1]" style="bottom: -3vh;">
                        </div>
                        <div
                            class="relative font-[HammersmithOne-Regular] bg-pastel-turqoise h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-x-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap z-10">
                            <button onclick="window.location.href='/login'">Member</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- GALERI ART TIDAK UNTUK DIJUAL --}}
            <div
                class="bg-[#f0ebe3] rounded-b-3xl w-full shadow-[3vh_3vh_0_black] p-4 sm:p-8 min-h-[70vh] sm:min-h-[75vh] z-10 border-r-4 border-black flex flex-col">
                <ul
                    class="flex flex-col sm:flex-row font-[HammersmithOne-Regular] text-xs sm:text-sm lg:text-[1rem] gap-2 sm:gap-4 mx-2 sm:mx-4 flex-none">
                    <li>Illustrator / Artist</li>
                    <li>Graphic Designer</li>
                    <li>Original Fanmerch</li>
                </ul>
                <div class="sm:mt-3 py-3 flex-1 h-full flex flex-col gap-6">
                    @php
                        $paidIds = $paidIds ?? [];
                    @endphp

                    {{-- SHOWCASE SECTION --}}
                    <div id="galleryShowcaseCustom"
                        class="flex w-full h-full gap-3 sm:gap-4 justify-center items-center pb-4">
                        {{-- Left: single adopted item --}}
                        <div class="shrink-0 w-[45%] sm:w-[48%] h-full flex items-center justify-center">
                            @if (!empty($mainAdopted))
                                @php
                                    $img = asset($mainAdopted->image_url);
                                    $isSoldMain = in_array($mainAdopted->gallery_id, $paidIds);
                                @endphp
                                <div class="rounded-3xl border-4 border-black shadow-[0.6vh_0.6vh_0_black] w-full h-full overflow-hidden bg-white cursor-pointer relative hover:scale-[1.03] transition-all duration-300 showcase-item group"
                                    data-id="{{ $mainAdopted->gallery_id }}" data-title="{{ $mainAdopted->title }}"
                                    data-price="{{ $mainAdopted->price }}" data-format="{{ $mainAdopted->file_format }}"
                                    data-image="{{ $img }}">
                                    <img src="{{ $img }}" data-original-src="{{ $img }}"
                                        alt="Adopted Artwork"
                                        class="object-cover w-full h-full group-hover:brightness-110 transition-all duration-300"
                                        loading="lazy" />
                                    @if ($isSoldMain)
                                        <div
                                            class="absolute top-3 left-3 bg-red-600 text-white px-4 py-2 rounded-full text-xs font-bold border-2 border-black shadow-[0.2vh_0.2vh_0_black]">
                                            SOLD OUT</div>
                                    @endif
                                    <div
                                        class="absolute bottom-0 left-0 right-0 bg-linear-to-t from-black/80 to-transparent p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <p class="text-white font-bold text-sm truncate">Featured Artwork</p>
                                    </div>
                                </div>
                            @else
                                <div
                                    class="rounded-3xl border-4 border-black shadow-[0.6vh_0.6vh_0_black] w-full h-full overflow-hidden bg-linear-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-400 flex-col gap-2">
                                    <p class="text-sm font-medium">No featured artwork yet</p>
                                </div>
                            @endif
                        </div>

                        {{-- Right: gallery items grid --}}
                        <div class="flex flex-col justify-between h-full w-[55%] sm:w-[52%] gap-3 sm:gap-4">
                            {{-- Top row --}}
                            <div class="flex gap-3 sm:gap-4 h-1/2">
                                @foreach ($nonAdopted->take(2) as $art)
                                    @php
                                        $img = asset($art->image_url);
                                        $isSold = $art->status === 'sold' || in_array($art->gallery_id, $paidIds);
                                    @endphp
                                    <div class="rounded-2xl border-4 border-black shadow-[0.4vh_0.4vh_0_black] w-[49%] h-full overflow-hidden bg-white hover:scale-[1.02] transition-all duration-300 showcase-item group cursor-pointer"
                                        data-id="{{ $art->gallery_id }}" data-title="{{ $art->title }}"
                                        data-price="{{ $art->price }}" data-format="{{ $art->file_format }}"
                                        data-image="{{ $img }}">
                                        <img src="{{ $img }}" data-original-src="{{ $img }}"
                                            alt="Gallery Artwork"
                                            class="object-cover w-full h-full group-hover:brightness-110 transition-all duration-300"
                                            loading="lazy" />
                                        @if ($isSold)
                                            <div
                                                class="absolute top-2 left-2 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold border border-black shadow-[0.2vh_0.2vh_0_black]">
                                                Sold</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            {{-- Bottom row --}}
                            <div class="flex gap-3 sm:gap-4 h-1/2">
                                @foreach ($nonAdopted->skip(2)->take(2) as $art)
                                    @php
                                        $img = asset($art->image_url);
                                        $isSold = $art->status === 'sold' || in_array($art->gallery_id, $paidIds);
                                    @endphp
                                    <div class="rounded-2xl border-4 border-black shadow-[0.4vh_0.4vh_0_black] w-[49%] h-full overflow-hidden bg-white hover:scale-[1.02] transition-all duration-300 showcase-item group cursor-pointer"
                                        data-id="{{ $art->gallery_id }}" data-title="{{ $art->title }}"
                                        data-price="{{ $art->price }}" data-format="{{ $art->file_format }}"
                                        data-image="{{ $img }}">
                                        <img src="{{ $img }}" data-original-src="{{ $img }}"
                                            alt="Gallery Artwork"
                                            class="object-cover w-full h-full group-hover:brightness-110 transition-all duration-300"
                                            loading="lazy" />
                                        @if ($isSold)
                                            <div
                                                class="absolute top-2 left-2 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold border border-black shadow-[0.2vh_0.2vh_0_black]">
                                                Sold</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ======================================================================= --}}
            {{-- SECTION READY TO BUY (Target Scroll untuk Pop Up) --}}
            {{-- ======================================================================= --}}
            <section id="readyToBuy"
                class="mt-16 bg-[#f0ebe3] rounded-3xl border-4 border-black shadow-[3vh_3vh_0_black] p-6 sm:p-10 flex flex-col min-h-0 relative">
                
                 <div class="flex items-center gap-3">
                    <h2 class="font-[HammersmithOne-Regular] text-2xl sm:text-3xl text-gray-800">
                        READY-TO-BUY DESIGNS
                    </h2>
                    {{-- Tombol Info (Manual Trigger) --}}
                    <button id="manualInfoBtn" 
                            class="w-8 h-8 rounded-full border-2 border-black bg-pastel-turqoise text-black font-bold flex items-center justify-center hover:bg-[#b4a6d5] hover:scale-110 transition-all shadow-[2px_2px_0_black]"
                            title="Read Buying Guide">
                        i
                    </button>
                </div>

                <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 flex-1 min-h-0">
                    {{-- LEFT: PREVIEW PANEL --}}
                    <div id="previewPanel"
                        class="flex-none bg-linear-to-br from-[#f0ebe3] to-[#e6dfd5] border-4 border-black rounded-3xl shadow-[0.8vh_0.8vh_0_black] p-6 sm:p-8 flex flex-col items-center justify-center w-full lg:w-[380px] lg:h-fit transition-all duration-300">
                        <div class="w-full text-center mb-4">
                            <h3 class="font-[HammersmithOne-Regular] text-2xl mb-2 text-gray-800">Preview</h3>
                            <p id="previewTitle" class="text-sm text-gray-600 italic mb-2 line-clamp-2">Select a Design</p>
                        </div>
                        <div
                            class="w-full aspect-square bg-white rounded-2xl overflow-hidden flex justify-center items-center border-4 border-black relative mb-6">
                            <img id="previewImage" src="" alt="Preview"
                                class="w-full h-full object-cover hidden transition-opacity duration-300">
                            <div id="previewPlaceholder"
                                class="absolute inset-0 flex flex-col items-center justify-center bg-linear-to-br from-[#dceef4] to-[#c6e3f0] text-center p-4">
                                <svg class="w-16 h-16 text-gray-400 mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-gray-600 text-sm font-medium">Click an image<br>to preview</p>
                            </div>
                        </div>
                        <div class="w-full space-y-3">
                            <div class="bg-white border-3 border-black rounded-2xl p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-bold text-gray-700">FILE FORMAT:</span>
                                    <span id="previewFormat"
                                        class="px-3 py-1 bg-pastel-turqoise border-2 border-black rounded-full text-xs font-bold shadow-[0.2vh_0.2vh_0_black]">-</span>
                                </div>
                                <div
                                    class="flex items-center justify-between bg-linear-to-r from-[#e3f2fd] to-[#f3e5f5] border-2 border-black rounded-lg p-3">
                                    <span class="text-sm font-bold text-gray-800">Price:</span>
                                    <span id="previewPrice" class="text-xl font-bold text-[#2563eb]">-</span>
                                </div>
                            </div>
                            <button id="buyButton" disabled
                                class="w-full bg-[#4c9eff] border-3 border-black px-6 py-3 rounded-xl font-[HammersmithOne-Regular] font-bold text-white text-lg hover:bg-[#73b7ff] transition-all duration-300 shadow-[0.4vh_0.4vh_0_black] disabled:opacity-50 disabled:cursor-not-allowed">
                                Buy Now
                            </button>
                        </div>
                    </div>

                    {{-- RIGHT: DESIGN GRID --}}
                    <div class="flex-1 lg:flex-initial min-h-0 flex flex-col">
                        <div id="designGrid"
                            class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-4 sm:gap-5 overflow-y-auto pr-2 h-full auto-rows-max content-start">
                            @forelse ($designs as $design)
                                @php
                                    $imageUrl = asset($design->image_url);
                                    $isPaidOrSold = ($design->status === 'sold') || in_array($design->gallery_id, $paidIds);
                                    $isReserved = $design->status === 'reserved';
                                @endphp
                                <div class="design-item cursor-pointer rounded-2xl border-4 border-black shadow-[0.5vh_0.5vh_0_black] aspect-square relative overflow-visible group hover:scale-[1.02] transition-all duration-300 z-0"
                                    data-id="{{ $design->gallery_id }}" data-title="{{ $design->title }}"
                                    data-price="Rp {{ number_format($design->price, 0, ',', '.') }}"
                                    data-format="{{ $design->file_format }}" data-image="{{ $imageUrl }}">
                                    <div class="w-full h-full overflow-hidden bg-white rounded-lg">
                                        <img src="{{ $imageUrl }}" alt="{{ $design->title }}"
                                            class="w-full h-full object-cover group-hover:brightness-110 transition-all duration-300"
                                            onerror="handleBrokenImage(this)" data-original-src="{{ $imageUrl }}">
                                    </div>
                                    @if ($isPaidOrSold)
                                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                            <div
                                                class="bg-red-600 text-white px-4 py-2 rounded-full text-xs font-bold border-2 border-black">
                                                SOLD OUT</div>
                                        </div>
                                    @elseif ($isReserved)
                                        <div class="absolute inset-0 bg-black/30 flex items-start justify-start p-3">
                                            <div
                                                class="bg-yellow-500 text-black px-3 py-1 rounded-full text-xs font-bold border-2 border-black">
                                                RESERVED</div>
                                        </div>
                                    @else
                                        <div
                                            class="absolute bottom-0 left-0 right-0 bg-linear-to-t from-black/80 to-transparent p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <p class="text-white text-xs font-bold truncate">{{ $design->title }}</p>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <p class="col-span-full text-center text-gray-600 py-8 font-medium">No designs available
                                    yet</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>

            {{-- ======================================================================= --}}
            {{-- NEW: WELCOME POP UP DIALOG (HIDDEN BY DEFAULT) --}}
            {{-- ======================================================================= --}}
            <div id="welcomePopup" class="fixed inset-0 z-60 hidden items-center justify-center bg-black/60 p-4 font-[HammersmithOne-Regular]">
                <div class="bg-[#f0ebe3] w-full max-w-lg rounded-3xl border-4 border-black shadow-[1vh_1vh_0_#b4a6d5] overflow-hidden transform scale-95 opacity-0 transition-all duration-500" id="welcomePopupCard">
                    {{-- Header PopUp --}}
                    <div class="bg-pastel-turqoise border-b-4 border-black p-5 flex items-center gap-4">
                        <div class="w-12 h-12 bg-white rounded-full border-2 border-black flex items-center justify-center shadow-sm">
                            <span class="text-2xl">👋</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold leading-tight">Welcome to My Special Design!</h3>
                            <p class="text-xs text-gray-700 font-bold">Available for adoption</p>
                        </div>
                    </div>
                    
                    {{-- Body Content --}}
                    <div class="p-6 text-gray-800 space-y-4">
                        <p class="text-lg font-bold">Hi there! ✨</p>
                        <p class="text-sm leading-relaxed">
                            Here are some special designs that you can adopt directly. Follow these simple steps:
                        </p>
                        
                        <ul class="space-y-3 mt-2">
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-black text-white flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">1</div>
                                <p class="text-sm"><span class="font-bold">Pick a design</span> on the right panel.</p>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-black text-white flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">2</div>
                                <p class="text-sm">Wait for the <span class="font-bold">Preview</span> to appear. (Sold items 🔴 cannot be bought).</p>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-black text-white flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">3</div>
                                <p class="text-sm">Click <span class="bg-[#4c9eff] text-white px-2 py-0.5 rounded text-xs border border-black">Buy Now</span>, scan the QR code, and upload your proof.</p>
                            </li>
                        </ul>

                        <div class="bg-white/50 p-3 rounded-xl border-2 border-black/20 italic text-sm text-center mt-4">
                            "I'm waiting for you to adopt one of my creations! Don't forget to use your active email." 🎨
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="p-4 bg-[#f0ebe3] border-t-4 border-black flex justify-center">
                        <button id="closeWelcomePopup" class="bg-[#b4a6d5] hover:bg-[#9b8bc4] text-black border-2 border-black px-8 py-2 rounded-xl font-bold shadow-[0.3vh_0.3vh_0_black] active:translate-y-1 active:shadow-none transition-all">
                            Okay, Let's Shop! 🛍️
                        </button>
                    </div>
                </div>
            </div>


            <!-- MODAL PEMBELIAN (EXISTING) -->
            <div id="purchaseModal"
                class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50 p-4 font-[HammersmithOne-Regular]">
                <div
                    class="bg-background rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border-4 border-black shadow-[1vh_1vh_0_#a2e1db]">
                    <!-- FORM VIEW -->
                    <div id="formView">
                        <div class="bg-linear-to-r from-pastel-turqoise to-turquoise p-6 text-center rounded-t-xl">
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Complete Your Purchase</h2>
                            <p class="text-gray-700">You are adopting: <strong id="modalItemTitle"
                                    class="text-gray-900"></strong></p>
                        </div>
                        <form id="purchaseForm" method="POST" action="{{ route('gallery.adopt') }}"
                            enctype="multipart/form-data" class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                            @csrf
                            <input type="hidden" name="gallery_id" id="gallery_id">

                            <!-- Kolom Kiri: QRIS -->
                            <div class="flex flex-col items-center">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Scan to Pay</h3>
                                <div class="w-full max-w-[250px]">
                                    <img src="{{ asset('assets/images/payment/qris_cho_lazey_fanmerch.png') }}"
                                        alt="QRIS Code" class="w-full rounded-lg shadow-md border-2 border-white">
                                </div>
                                <p class="text-center text-2xl font-bold text-red-600 mt-4" id="modalItemPrice"></p>
                                <p class="text-xs text-gray-600 mt-2 text-center">Please transfer the exact amount.</p>
                            </div>

                            <!-- Kolom Kanan: Input Form -->
                            <div class="flex flex-col justify-center">
                                <div>
                                    <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Your
                                        Email</label>
                                    <input type="email" id="email" name="email" required
                                        class="w-full px-4 py-2 border-2 border-black rounded-lg"
                                        placeholder="your.email@example.com">
                                </div>
                                <div class="mt-4">
                                    <label for="paymentProof" class="block text-sm font-bold text-gray-700 mb-1">Upload
                                        Payment
                                        Proof</label>
                                    <input type="file" id="paymentProof" name="paymentProof" required
                                        accept="image/png, image/jpeg, image/jpg"
                                        class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pastel-turqoise file:text-gray-800 hover:file:bg-turquoise border-2 border-black rounded-lg cursor-pointer">
                                </div>
                                <div class="mt-8 flex items-center gap-4">
                                    <button type="submit" id="submitButton"
                                        class="w-full bg-[#4c9eff] border-4 border-black px-6 py-3 rounded-xl font-bold hover:bg-[#73b7ff] transition duration-300">
                                        Submit
                                    </button>
                                    <button type="button" id="closeModalButton"
                                        class="w-1/2 bg-gray-300 border-4 border-black px-6 py-3 rounded-xl font-bold hover:bg-gray-400 transition duration-300">
                                        Cancel
                                    </button>
                                </div>
                                <div id="formErrors" class="text-red-500 text-sm mt-2"></div>
                            </div>
                        </form>
                    </div>

                    <!-- THANK YOU VIEW -->
                    <div id="thankYouView" class="hidden p-8 md:p-12 text-center">
                        <div class="bg-linear-to-r from-pastel-turqoise to-turquoise p-6 rounded-t-xl mb-6">
                            <h2 class="text-3xl font-bold text-gray-800">Thank You!</h2>
                        </div>
                        <p class="text-lg text-gray-800 mb-4">
                            Your submission has been received. Please wait for confirmation from the artist via the email
                            you provided.
                        </p>
                        <p class="text-sm text-gray-600 mb-6">
                            Verification may take up to 24 hours. Once your payment is verified, the artwork files will be
                            sent to you.
                        </p>
                        <button id="finishButton"
                            class="bg-gray-800 text-white px-8 py-3 rounded-xl font-bold hover:bg-black transition duration-300">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Global handler untuk gambar rusak (tetap dipertahankan)
    window.handleBrokenImage = function(img) {
        try {
            if (!img) return;
            img.onerror = null;
            const container = img.parentElement;
            if (container) {
                if (getComputedStyle(container).position === 'static') {
                    container.style.position = 'relative';
                }
                if (!container.querySelector('.broken-overlay')) {
                    const overlay = document.createElement('div');
                    overlay.className = 'broken-overlay';
                    overlay.textContent = 'Image broken';
                    container.appendChild(overlay);
                }
                img.style.opacity = '0.25';
                img.style.objectFit = 'contain';
            }
        } catch (e) {
            console.error('handleBrokenImage error', e);
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        console.log("System Ready: Script Loaded."); // Debugging 1

        // ==========================================
        // 1. LOGIKA POP UP & INFO BUTTON
        // ==========================================
        const readyToBuySection = document.getElementById('readyToBuy');
        const welcomePopup = document.getElementById('welcomePopup');
        const welcomeCard = document.getElementById('welcomePopupCard');
        const closeWelcomeBtn = document.getElementById('closeWelcomePopup');
        const manualInfoBtn = document.getElementById('manualInfoBtn');

        // Fungsi Tampilkan Popup
        function showWelcomePopup() {
            console.log("Action: Membuka Pop Up..."); 
            if(!welcomePopup) return;
            
            welcomePopup.classList.remove('hidden');
            welcomePopup.classList.add('flex');
            
            // Animasi masuk
            setTimeout(() => {
                welcomeCard.classList.remove('scale-95', 'opacity-0');
                welcomeCard.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        // Fungsi Sembunyikan Popup
        function hideWelcomePopup() {
            welcomeCard.classList.remove('scale-100', 'opacity-100');
            welcomeCard.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                welcomePopup.classList.add('hidden');
                welcomePopup.classList.remove('flex');
            }, 500);
        }

        // Event Listener: Tombol Info (Manual Trigger)
        if(manualInfoBtn) {
            manualInfoBtn.addEventListener('click', (e) => {
                e.stopPropagation(); // Mencegah klik tembus
                showWelcomePopup();
            });
        }

        // Event Listener: Scroll Trigger (Intersection Observer)
        if (readyToBuySection && welcomePopup) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        console.log("Scroll Detected: Masuk area Ready to Buy");
                        
                        // Cek apakah user sudah pernah melihat popup di sesi ini?
                        const hasSeen = sessionStorage.getItem('hasSeenShopPopup');
                        
                        if (!hasSeen) {
                            showWelcomePopup();
                            sessionStorage.setItem('hasSeenShopPopup', 'true');
                            console.log("Status: Pop Up dimunculkan otomatis (Pertama kali).");
                        } else {
                            console.log("Status: Pop Up ditahan (User sudah melihat sebelumnya). Klik 'i' untuk melihat lagi.");
                        }
                    }
                });
            }, { threshold: 0.25 }); // 25% elemen terlihat baru muncul

            observer.observe(readyToBuySection);
        }

        // Event Listener: Tutup Pop Up
        if(closeWelcomeBtn) closeWelcomeBtn.addEventListener('click', hideWelcomePopup);
        if(welcomePopup) {
            welcomePopup.addEventListener('click', (e) => {
                if(e.target === welcomePopup) hideWelcomePopup();
            });
        }

        // ==========================================
        // 2. LOGIKA PREVIEW & GRID (SAMA SEPERTI SEBELUMNYA)
        // ==========================================
        function updatePreview({ id = '', title = '', price = '', image = '', format = '' } = {}) {
            if (title) document.getElementById('previewTitle').textContent = title;
            if (price) {
                if (String(price).trim().startsWith('Rp')) {
                    document.getElementById('previewPrice').textContent = price;
                } else if (!isNaN(Number(price))) {
                    document.getElementById('previewPrice').textContent = 'Rp ' + Number(price).toLocaleString('id-ID');
                } else {
                    document.getElementById('previewPrice').textContent = price;
                }
            }
            const previewFormatEl = document.getElementById('previewFormat');
            previewFormatEl.textContent = (format && format !== '') ? format : '-';

            const previewImage = document.getElementById('previewImage');
            if (image) {
                previewImage.src = image;
                previewImage.classList.remove('hidden');
                document.getElementById('previewPlaceholder').classList.add('hidden');
            }
            document.getElementById('buyButton').disabled = false;
            if (id !== '') document.getElementById('gallery_id').value = id;
        }

        document.body.addEventListener('click', function(e) {
            const wrapper = e.target.closest('.showcase-item, .design-item');
            if (!wrapper) return;
            
            if(wrapper.classList.contains('showcase-item') && readyToBuySection) {
                readyToBuySection.scrollIntoView({behavior: 'smooth'});
            }

            const d = wrapper.dataset;
            updatePreview({
                id: d.id,
                title: d.title,
                price: d.price,
                image: d.image || (wrapper.querySelector('img') ? wrapper.querySelector('img').src : ''),
                format: d.format || d.fileFormat || d.file_format
            });

            wrapper.classList.add('scale-95');
            setTimeout(() => wrapper.classList.remove('scale-95'), 150);
        });

        // ==========================================
        // 3. LOGIKA MODAL PEMBELIAN
        // ==========================================
        const modalElements = {
            modal: document.getElementById('purchaseModal'),
            buyButton: document.getElementById('buyButton'),
            closeButton: document.getElementById('closeModalButton'),
            finishButton: document.getElementById('finishButton'),
            form: document.getElementById('purchaseForm'),
            formView: document.getElementById('formView'),
            thankYouView: document.getElementById('thankYouView'),
            submitButton: document.getElementById('submitButton'),
            errors: document.getElementById('formErrors'),
            title: document.getElementById('modalItemTitle'),
            price: document.getElementById('modalItemPrice'),
        };

        function openModal() {
            modalElements.title.textContent = document.getElementById('previewTitle').textContent;
            modalElements.price.textContent = document.getElementById('previewPrice').textContent;
            modalElements.modal.classList.remove('hidden');
            modalElements.modal.classList.add('flex');
            modalElements.formView.classList.remove('hidden');
            modalElements.thankYouView.classList.add('hidden');
            modalElements.errors.innerHTML = '';
            modalElements.submitButton.disabled = false;
            modalElements.form.reset();
        }

        function closeModal() {
            modalElements.modal.classList.add('hidden');
            modalElements.modal.classList.remove('flex');
        }

        if(modalElements.buyButton) {
            modalElements.buyButton.addEventListener('click', () => {
                if (!modalElements.buyButton.disabled) openModal();
            });
        }
        if(modalElements.closeButton) modalElements.closeButton.addEventListener('click', closeModal);
        if(modalElements.finishButton) modalElements.finishButton.addEventListener('click', closeModal);

        // ==========================================
        // 4. GALLERY ROTATION
        // ==========================================
        let rotationTimer = null;
        function setupGalleryRotation() {
            const container = document.querySelector('#galleryShowcaseCustom');
            if (!container) return;
            const wrappers = Array.from(container.querySelectorAll('.showcase-item'));
            if (wrappers.length < 2) return;
            
            // Simpan data awal
            const items = wrappers.map(w => ({
                id: w.dataset.id || '',
                title: w.dataset.title || '',
                price: w.dataset.price || '',
                src: w.dataset.image || '',
            }));

            function rotateItems() {
                items.unshift(items.pop()); // Rotasi array logic
                wrappers.forEach((w, i) => {
                    const img = w.querySelector('img');
                    const item = items[i];
                    
                    // Update dataset wrapper
                    w.dataset.id = item.id;
                    w.dataset.title = item.title;
                    w.dataset.price = item.price;
                    w.dataset.image = item.src;
                    
                    // Update visual
                    img.style.opacity = '0';
                    setTimeout(() => {
                        img.src = item.src;
                        img.style.opacity = '1';
                    }, 300);
                });
            }
            if (rotationTimer) clearInterval(rotationTimer);
            rotationTimer = setInterval(rotateItems, 5000);
        }
        setupGalleryRotation();
    });
</script>

    <style>
        .broken-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            background: rgba(243, 244, 246, 0.75);
            font-weight: 600;
            font-size: 0.9rem;
            pointer-events: none;
            border-radius: inherit;
            text-transform: none;
        }
        #galleryShowcaseCustom {
            animation: fadeInUp 0.6s ease-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        #galleryShowcaseCustom img {
            transition: opacity 0.3s ease-in-out, brightness 0.3s ease-in-out;
        }
        .showcase-item, .design-item {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        #designGrid {
            scrollbar-width: thin;
            scrollbar-color: rgba(162, 225, 219, 0.6) rgba(0, 0, 0, 0.05);
            perspective: 1000px;
            will-change: scroll-position;
        }
        #designGrid::-webkit-scrollbar { width: 6px; }
        #designGrid::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.05); border-radius: 10px; }
        #designGrid::-webkit-scrollbar-thumb { background: rgba(162, 225, 219, 0.6); border-radius: 10px; }
        #designGrid::-webkit-scrollbar-thumb:hover { background: rgba(162, 225, 219, 0.9); }
        .design-item { transform-origin: center; backface-visibility: hidden; }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        @media (max-width: 1024px) {
            #previewPanel { width: 100%; }
        }
        @media (max-width: 640px) {
            #designGrid { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
            .showcase-item { border-radius: 0.75rem; }
        }
    </style>
@endsection

@section('disableinspect')
    <script>
        (function() {
            document.addEventListener('contextmenu', e => e.preventDefault());
            document.addEventListener('keydown', function(e) {
                const k = e.key || e.keyIdentifier || e.keyCode;
                const key = (typeof k === 'string') ? k.toUpperCase() : k;
                if (key === 'F12' || key === 123) { e.preventDefault(); e.stopPropagation(); }
                if (e.ctrlKey && (e.key && ['U'].includes(e.key.toUpperCase()))) { e.preventDefault(); e.stopPropagation(); }
                if (e.ctrlKey && e.shiftKey && e.key && ['I', 'J', 'C', 'K'].includes(e.key.toUpperCase())) { e.preventDefault(); e.stopPropagation(); }
            }, true);
        })();
    </script>
@endsection