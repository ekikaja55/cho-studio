@extends('template')

@section('content')
    {{-- Latar belakang utama --}}
    <div
        class="min-h-screen p-2 sm:p-4 mt-4 sm:mt-8 flex justify-center items-start bg-[url('{{ asset('assets/images/bg2.png') }}')] bg-cover bg-no-repeat">
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
                        class="font-[HammersmithOne-Regular] bg-[#a2e1db] h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-l-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap">
                        <button onclick="window.location.href='/'">Home</button>
                    </div>
                    <div
                        class="font-[HammersmithOne-Regular] bg-[#a2e1db] h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-l-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap">
                        <button onclick="window.location.href='/gallery'">Gallery</button>
                    </div>
                    <div
                        class="font-[HammersmithOne-Regular] bg-[#a2e1db] h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-l-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap">
                        <button>Shop</button>
                    </div>
                    {{-- Tombol Member dengan Shadow yang dimodifikasi --}}
                    <div class="relative inline-block">
                        <div class="absolute top-1.5 left-1.5 w-full bg-black rounded-t-2xl z-[-1]" style="bottom: -3vh;">
                        </div>
                        <div
                            class="relative font-[HammersmithOne-Regular] bg-pastel-turqoise h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-x-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap z-10">
                            <button>Member</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- GALERI ART TIDAK UNTUK DIJUAL --}}
            <div
                class="bg-[#f0ebe3] rounded-b-3xl w-full shadow-[3vh_3vh_0_black] p-4 sm:p-8 h-[70vh] sm:h-[75vh] z-10 border-r-4 border-black flex flex-col min-h-0">
                <ul
                    class="flex flex-col sm:flex-row font-[HammersmithOne-Regular] text-xs sm:text-sm lg:text-[1rem] gap-2 sm:gap-4 mx-2 sm:mx-4 flex-none">
                    <li>Illustrator / Artist</li>
                    <li>Graphic Designer</li>
                    <li>Original Fanmerch</li>
                </ul>
                <div class="sm:mt-4 flex-1 h-full">
                    @php
                        // use controller-provided variables:
                        // $mainAdopted  -> single adopted item (or null)
                        // $nonAdopted   -> collection of non-adopted gallery items
                    @endphp

                    {{-- bagian showcase: tambahkan data-format pada semua showcase-item --}}
                    @php
                        // $paidIds disediakan oleh controller: hanya gallery_id yang payment_status == 'paid' AND gallery.status == 'available'
                        $paidIds = $paidIds ?? [];
                    @endphp

                    <div id="galleryShowcaseCustom" class="flex w-full h-[340px] sm:h-[400px] gap-2 justify-center items-center my-12"> {{-- Left: single adopted item --}}
                        <div class="flex-shrink-0 w-[48%] h-full flex items-center justify-center"> {{-- kiri sedikit diperbesar --}}
                            @if(!empty($mainAdopted))
                                @php
                                    $img = preg_match('/^https?:\/\//', $mainAdopted->image_url) || str_starts_with($mainAdopted->image_url, '/storage')
                                        ? $mainAdopted->image_url
                                        : Storage::url($mainAdopted->image_url);

                                    $isSoldMain = ($mainAdopted->status === 'sold') || in_array($mainAdopted->gallery_id, $paidIds);
                                @endphp
                                <div
                                    class="rounded-2xl border-4 border-black shadow-lg w-full h-full overflow-hidden bg-white cursor-pointer relative hover:scale-[1.02] transition-transform duration-300 showcase-item"
                                    data-id="{{ $mainAdopted->gallery_id }}"
                                    data-title="{{ $mainAdopted->title }}"
                                    data-price="{{ $mainAdopted->price }}"
                                    data-format="{{ $mainAdopted->file_format }}"  
                                    data-image="{{ $img }}">
                                    <img src="{{ $img }}" data-original-src="{{ $img }}" alt="Adopted Artwork" class="object-cover w-full h-full" loading="lazy" />
                                    {{-- Sold badge --}}
                                    @if($isSoldMain)
                                        <div class="absolute top-2 left-2 bg-red-600 text-white px-3 py-1 rounded-xl text-xs font-bold border border-black">Sold</div>
                                    @endif
                                </div>
                            @else
                                <div class="rounded-2xl border-4 border-black shadow-lg w-full h-full overflow-hidden bg-white flex items-center justify-center text-gray-400">
                                    No adopted artwork yet
                                </div>
                            @endif
                        </div>

                        {{-- Right: all non-adopted items --}}
                        <div class="flex flex-col justify-between h-full w-[52%] gap-2"> {{-- kanan sedikit dikurangi lebar gap --}}
                            <div class="flex gap-2 h-1/2"> {{-- gap antar gambar kanan dikurangi --}}
                                @foreach($nonAdopted->take(2) as $art)
                                    @php
                                        $img = preg_match('/^https?:\/\//', $art->image_url) || str_starts_with($art->image_url, '/storage')
                                            ? $art->image_url
                                            : Storage::url($art->image_url);
                                        $isSold = ($art->status === 'sold') || in_array($art->gallery_id, $paidIds);
                                    @endphp
                                    <div
                                        class="rounded-xl border-4 border-black shadow w-[49%] h-full overflow-hidden bg-white hover:scale-[1.02] transition-transform duration-300 showcase-item" {{-- gunakan ~49% agar rapat --}}
                                        data-id="{{ $art->gallery_id }}"
                                        data-title="{{ $art->title }}"
                                        data-price="{{ $art->price }}"
                                        data-format="{{ $art->file_format }}"  {{-- <--- tambah data-format --}}
                                        data-image="{{ $img }}">
                                        <img src="{{ $img }}" data-original-src="{{ $img }}" alt="Gallery Artwork" class="object-cover w-full h-full" loading="lazy" />
                                        @if($isSold)
                                            <div class="absolute top-2 left-2 bg-red-600 text-white px-2 py-1 rounded-xl text-xs font-bold border border-black">Sold</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex gap-2 h-1/2"> {{-- gap dikurangi --}}
                                @foreach($nonAdopted->skip(2)->take(2) as $art)
                                    @php
                                        $img = preg_match('/^https?:\/\//', $art->image_url) || str_starts_with($art->image_url, '/storage')
                                            ? $art->image_url
                                            : Storage::url($art->image_url);
                                        $isSold = ($art->status === 'sold') || in_array($art->gallery_id, $paidIds);
                                    @endphp
                                    <div
                                        class="rounded-xl border-4 border-black shadow w-[49%] h-full overflow-hidden bg-white hover:scale-[1.02] transition-transform duration-300 showcase-item"
                                        data-id="{{ $art->gallery_id }}"
                                        data-title="{{ $art->title }}"
                                        data-price="{{ $art->price }}"
                                        data-format="{{ $art->file_format }}"  {{-- <--- tambah data-format --}}
                                        data-image="{{ $img }}">
                                        <img src="{{ $img }}" data-original-src="{{ $img }}" alt="Gallery Artwork" class="object-cover w-full h-full" loading="lazy" />
                                        @if($isSold)
                                            <div class="absolute top-2 left-2 bg-red-600 text-white px-2 py-1 rounded-xl text-xs font-bold border border-black">Sold</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- End custom showcase --}}

                    <div
                        class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2 sm:gap-4 auto-rows-fr h-full p-2 sm:p-4">
                        {{-- Bagian ini bisa Anda isi dengan galeri portofolio jika perlu --}}
                    </div>
                </div>
            </div>

            {{-- SECTION READY TO BUY --}}
            <section id="readyToBuy"
                class="mt-20 bg-[#f0ebe3] rounded-3xl border-4 border-black shadow-[3vh_3vh_0_black] p-6 sm:p-10"> {{-- mt-12 -> mt-20 --}}
                <h2 class="font-[HammersmithOne-Regular] text-2xl sm:text-3xl text-center mb-6">
                    READY-TO-BUY DESIGNS
                </h2>
                <div class="flex flex-col sm:flex-row gap-6"> {{-- allow content to grow so grid shows all items --}}
                    {{-- LEFT: PREVIEW - perbesar and center --}}
                    <div id="previewPanel"
                        class="flex-none bg-gradient-to-br from-[#f0ebe3] to-[#e6dfd5] border-4 border-black rounded-2xl shadow-[0.6vh_0.6vh_0_black] p-6 flex flex-col items-center justify-center w-full sm:w-[420px] md:w-[520px] mx-auto transition-all duration-300"> {{-- lebih besar & center --}}
                        <div class="w-full text-center">
                            <h3 class="font-[HammersmithOne-Regular] text-xl mb-1">Preview</h3>
                            <p id="previewTitle" class="text-sm text-gray-600 italic mb-3">Select a Design</p>
                        </div>
                        <div
                            class="w-full aspect-square bg-white rounded-xl overflow-hidden flex justify-center items-center border-4 border-black shadow-[0.4vh_0.4vh_0_#a2e1db] relative">
                            <img id="previewImage" src="" alt="Preview" class="w-full h-full object-cover hidden">
                            <div id="previewPlaceholder" class="absolute inset-0 flex flex-col items-center justify-center bg-[#dceef4] text-center p-4">
                                <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-gray-500 text-sm">Click an image<br>to preview</p>
                            </div>
                        </div>
                        <div class="w-full mt-4 bg-white border-2 border-black rounded-lg p-3">
                            <div class="flex items-center justify-between mb-2">
                                <span id="previewFormat"
                                    class="px-3 py-1 bg-[#a2e1db] border-2 border-black rounded-full text-xs font-bold shadow-[0.2vh_0.2vh_0_black]">-</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-bold">Price:</span>
                                <span id="previewPrice" class="text-lg font-bold text-[#4c9eff]">-</span>
                            </div>
                            <button id="buyButton" disabled
                                class="mt-3 w-full bg-[#4c9eff] border-3 border-black px-4 py-2 rounded-lg font-[HammersmithOne-Regular] text-white hover:bg-[#73b7ff] transition-all duration-300 shadow-[0.3vh_0.3vh_0_black] hover:shadow-[0.4vh_0.4vh_0_black] hover:-translate-y-[0.1vh] disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:shadow-[0.3vh_0.3vh_0_black] disabled:hover:translate-y-0">
                                Buy Now
                            </button>
                        </div>
                    </div>

                    {{-- RIGHT: GRID with horizontal scroll --}}
                    <div class="flex-1 overflow-hidden">
                        <div id="designGrid"
                            class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2 h-full overflow-y-auto pb-4 pr-2"> {{-- tampilkan semua, 4 kolom di lg, gap-x/gap-y sama --}}
                            @forelse ($designs as $design) {{-- tampilkan semua item --}}
                            @if(in_array($art->gallery_id, $paidIds))
                                <div class="absolute top-2 left-2 bg-red-600 text-white px-2 py-1 rounded-xl text-xs font-bold border border-black">Sold</div>
                            @endif
                                 @php
                                     $imageUrl = preg_match('/^https?:\/\//', $design->image_url) || str_starts_with($design->image_url, '/storage')
                                         ? $design->image_url
                                         : Storage::url($design->image_url);
                                     $isSoldDesign = ($design->status === 'sold') || in_array($design->gallery_id, $paidIds);
                                 @endphp
                                 <div class="design-item cursor-pointer bg-gradient-to-b from-yellow-100 to-orange-200 rounded-md shadow-[0.4vh_0.4vh_0_black] hover:shadow-[0.6vh_0.6vh_0_black] hover:-translate-y-[0.3vh] transition-all duration-200 aspect-square relative"
                                     data-id="{{ $design->gallery_id }}" data-title="{{ $design->title }}" data-price="Rp {{ number_format($design->price,0,',','.') }}" data-format="{{ $design->file_format }}" data-image="{{ $imageUrl }}">
                                     <div class="w-full h-full overflow-hidden rounded-sm border-2 border-black">
                                         <img src="{{ $imageUrl }}" alt="{{ $design->title }}" class="w-full h-full object-cover"
                                             onerror="handleBrokenImage(this)" data-original-src="{{ $imageUrl }}">
                                     </div>
                                     @if($isSoldDesign)
                                         <div class="absolute top-2 left-2 bg-red-600 text-white px-2 py-1 rounded-xl text-xs font-bold border border-black">Sold</div>
                                     @endif
                                 </div>
                            @empty
                                 <p class="col-span-full text-center text-gray-500">No designs available for adoption at the moment.</p>
                             @endforelse
                         </div>
                     </div>
                </div>
            </section>

            <!-- MODAL PEMBELIAN -->
            <div id="purchaseModal"
                class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50 p-4 font-[HammersmithOne-Regular]">
                <div class="bg-background rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border-4 border-black shadow-[1vh_1vh_0_#a2e1db]">
                    <!-- FORM VIEW -->
                    <div id="formView">
                        <div class="bg-linear-to-r from-pastel-turqoise to-turquoise p-6 text-center rounded-t-xl">
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Complete Your Purchase</h2>
                            <p class="text-gray-700">You are adopting: <strong id="modalItemTitle"
                                    class="text-gray-900"></strong></p>
                        </div>
                        <form id="purchaseForm" method="POST" action="{{ route('gallery.adopt') }}" enctype="multipart/form-data"
                            class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
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
                                    <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Your Email</label>
                                    <input type="email" id="email" name="email" required
                                        class="w-full px-4 py-2 border-2 border-black rounded-lg"
                                        placeholder="your.email@example.com">
                                </div>
                                <div class="mt-4">
                                    <label for="paymentProof" class="block text-sm font-bold text-gray-700 mb-1">Upload Payment
                                        Proof</label>
                                    <input type="file" id="paymentProof" name="paymentProof" required
                                        accept="image/png, image/jpeg, image/jpg"
                                        class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#a2e1db] file:text-gray-800 hover:file:bg-[#7dc8c1] border-2 border-black rounded-lg cursor-pointer">
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
                        <div class="bg-gradient-to-r from-[#a2e1db] to-[#7dc8c1] p-6 rounded-t-xl mb-6">
                            <h2 class="text-3xl font-bold text-gray-800">Thank You!</h2>
                        </div>
                        <p class="text-lg text-gray-800 mb-4">
                            Your submission has been received. Please wait for confirmation from the artist via the email you provided.
                        </p>
                        <p class="text-sm text-gray-600 mb-6">
                            Verification may take up to 24 hours. Once your payment is verified, the artwork files will be sent to you.
                        </p>
                        <button id="finishButton" class="bg-gray-800 text-white px-8 py-3 rounded-xl font-bold hover:bg-black transition duration-300">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // global handler for broken images — keep layout and show a subtle overlay "Image broken"
        window.handleBrokenImage = function(img) {
            try {
                if (!img) return;
                // prevent repeated onerror firing
                img.onerror = null;

                const container = img.parentElement;
                if (container) {
                    // ensure the container can host an absolute overlay
                    if (getComputedStyle(container).position === 'static') {
                        container.style.position = 'relative';
                    }

                    // don't create duplicate overlays
                    if (!container.querySelector('.broken-overlay')) {
                        const overlay = document.createElement('div');
                        overlay.className = 'broken-overlay';
                        overlay.textContent = 'Image broken';
                        container.appendChild(overlay);
                    }

                    // dim the broken image but keep its box (avoid changing DOM structure)
                    img.style.opacity = '0.25';
                    img.style.objectFit = 'contain';
                }

                console.warn('Broken image detected:', img.dataset?.originalSrc || img.src);
            } catch (e) {
                console.error('handleBrokenImage error', e);
            }
        };

        document.addEventListener('DOMContentLoaded', function() {
            // --- Utility functions ---
            function updatePreview({ id = '', title = '', price = '', image = '', format = '' } = {}) {
                if (title) document.getElementById('previewTitle').textContent = title;
                // price bisa berformat "Rp ..." atau angka
                if (price) {
                    if (String(price).trim().startsWith('Rp')) {
                        document.getElementById('previewPrice').textContent = price;
                    } else if (!isNaN(Number(price))) {
                        document.getElementById('previewPrice').textContent = 'Rp ' + Number(price).toLocaleString('id-ID');
                    } else {
                        document.getElementById('previewPrice').textContent = price;
                    }
                }
                // format: ambil param format atau dataset format
                const previewFormatEl = document.getElementById('previewFormat');
                if (format && format !== '') {
                    previewFormatEl.textContent = format;
                } else {
                    previewFormatEl.textContent = '-';
                }

                const previewImage = document.getElementById('previewImage');
                if (image) {
                    previewImage.src = image;
                    previewImage.classList.remove('hidden');
                    document.getElementById('previewPlaceholder').classList.add('hidden');
                }
                document.getElementById('buyButton').disabled = false;
                if (id !== '') document.getElementById('gallery_id').value = id;
            }

            // --- Main click handler for all items ---
            document.body.addEventListener('click', function (e) {
                const wrapper = e.target.closest('.showcase-item, .design-item');
                if (!wrapper) return;
                const id = wrapper.dataset.id || '';
                const title = wrapper.dataset.title || '';
                const price = wrapper.dataset.price || '';
                const image = wrapper.dataset.image || (wrapper.querySelector('img') ? wrapper.querySelector('img').src : '');
                const format = wrapper.dataset.format || wrapper.dataset.fileFormat || wrapper.dataset.file_format || '';
                updatePreview({ id, title, price, image, format });
                
                // Visual feedback
                wrapper.classList.add('scale-95');
                setTimeout(() => wrapper.classList.remove('scale-95'), 150);
            });

            // --- Gallery rotation ---
            let rotationTimer = null;
            function setupGalleryRotation() {
                const container = document.querySelector('#galleryShowcaseCustom');
                if (!container) return;

                const wrappers = Array.from(container.querySelectorAll('.showcase-item'));
                if (wrappers.length < 2) return;

                // Build rotation items array
                const items = wrappers.map(w => ({
                    id: w.dataset.id || '',
                    title: w.dataset.title || '',
                    price: w.dataset.price || '',
                    src: w.dataset.image || '',
                }));

                function rotateItems() {
                    items.unshift(items.pop());
                    wrappers.forEach((w, i) => {
                        const img = w.querySelector('img');
                        const item = items[i];
                        
                        // Update wrapper data
                        w.dataset.id = item.id;
                        w.dataset.title = item.title;
                        w.dataset.price = item.price;
                        w.dataset.image = item.src;
                        
                        // Animate image swap
                        img.style.opacity = '0';
                        setTimeout(() => {
                            img.src = item.src;
                            img.style.opacity = '1';
                        }, 300);
                    });
                }

                // Clear existing and start new interval
                if (rotationTimer) clearInterval(rotationTimer);
                rotationTimer = setInterval(rotateItems, 5000);
            }

            // --- Modal handling ---
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

            // Event listeners
            modalElements.buyButton.addEventListener('click', () => {
                if (!modalElements.buyButton.disabled) openModal();
            });
            modalElements.closeButton.addEventListener('click', closeModal);
            modalElements.finishButton.addEventListener('click', closeModal);

            // Start rotation
            setupGalleryRotation();
        });
    </script>

    <style>
        /* overlay shown when image fails to load */
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

        /* Kurangi jarak internal di showcase */
        #galleryShowcaseCustom { gap: .5rem; }
        /* pastikan gambar kanan sedikit lebih besar dan rapat */
        #galleryShowcaseCustom .rounded-xl { display: inline-block; }
        #galleryShowcaseCustom img { 
            transition: opacity 0.3s ease-in-out;
        }
        .showcase-item, .design-item {
            transition: transform 0.2s ease-in-out;
        }
    </style>

@endsection

@section('disableinspect')
    <script>
        (function() {
            // disable right-click
            document.addEventListener('contextmenu', e => e.preventDefault());

            // disable common DevTools shortcuts (best-effort)
            document.addEventListener('keydown', function(e) {
                const k = e.key || e.keyIdentifier || e.keyCode;
                const key = (typeof k === 'string') ? k.toUpperCase() : k;

                // F12
                if (key === 'F12' || key === 123) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                // Ctrl+U (view source), Ctrl+Shift+I/J/C/K (DevTools), Ctrl+Shift+C
                if (e.ctrlKey && (e.key && ['U'].includes(e.key.toUpperCase()))) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                if (e.ctrlKey && e.shiftKey && e.key && ['I', 'J', 'C', 'K'].includes(e.key.toUpperCase())) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            }, true);
        })();
    </script>
@endsection
