{{-- section READY TO BUY --}}
<div id="readyToBuy"
    class="mt-16 bg-[#f0ebe3] rounded-3xl border-4 border-black shadow-[3vh_3vh_0_black] p-6 sm:p-10 flex flex-col h-[80vh]">
    <h2 class="text-2xl sm:text-3xl text-center mb-8 text-gray-800">
        READY-TO-BUY DESIGNS
    </h2>
    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 flex-1 min-h-0">
        <div id="previewPanel"
            class="flex-1 border-4 border-black rounded-3xl shadow-[0.8vh_0.8vh_0_black] p-6 sm:p-8 flex flex-col">
            <div class="flex flex-row items-center justify-between">
                <div class="flex flex-col">
                    <h3 class="text-2xl mb-2 text-gray-800">Preview</h3>
                    <p id="previewTitle" class="text-sm text-gray-600 italic mb-2">Select a Design</p>
                </div>
                <div class="flex items-center justify-center">
                    <button id="previewFullImageButton"
                        class="px-3 py-2 rounded-md border-2 border-black bg-white hover:bg-gray-100">
                        Preview Full Image
                    </button>
                </div>
            </div>
            <div
                class="w-full aspect-square bg-white rounded-2xl overflow-hidden flex justify-center items-center border-4 border-black relative mb-6">
                <img id="previewImage" src="" alt="Preview"
                    class="w-full h-full object-cover hidden transition-opacity duration-300">
                <div id="previewPlaceholder"
                    class="absolute inset-0 flex flex-col items-center justify-center bg-gradient-to-br from-[#dceef4] to-[#c6e3f0] text-center p-4">
                    <svg class="w-16 h-16 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            class="px-3 py-1 bg-[#a2e1db] border-2 border-black rounded-full text-xs font-bold shadow-[0.2vh_0.2vh_0_black]">-</span>
                    </div>
                    <div
                        class="flex items-center justify-between bg-gradient-to-r from-[#e3f2fd] to-[#f3e5f5] border-2 border-black rounded-lg p-3">
                        <span class="text-sm font-bold text-gray-800">Price:</span>
                        <span id="previewPrice" class="text-xl font-bold text-[#2563eb]">-</span>
                    </div>
                </div>
                <button id="buyButton"
                    class="w-full bg-[#4c9eff] border-3 border-black px-6 py-3 rounded-xl font-bold text-white text-lg hover:bg-[#73b7ff] transition-all duration-300 shadow-[0.4vh_0.4vh_0_black]">
                    Buy Now
                </button>
            </div>
        </div>
        <div id="designGrid"
            class="flex-1 min-h-0 overflow-y-auto pr-2 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-4 sm:gap-5 auto-rows-max content-start">
            @forelse ($allGallery as $design)
                @php
                    $imageUrl = asset($design->image_url);
                    $isReservedOrSold = in_array($design->status, ['reserved', 'sold']);
                    $imageStatus = $design->status;
                @endphp
                <div class="design-item cursor-pointer rounded-2xl border-4 border-black shadow-[0.5vh_0.5vh_0_black] aspect-square relative overflow-visible group z-0"
                    data-id="{{ $design->gallery_id }}">
                    <div class="w-full h-full overflow-hidden bg-white rounded-lg">
                        <img src="{{ $imageUrl }}" alt="{{ $design->title }}"
                            class="w-full h-full object-cover"
                            onerror="handleBrokenImage(this)" data-original-src="{{ $imageUrl }}">
                    </div>
                    @if ($isReservedOrSold)
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                            <div
                                class="{{ $imageStatus == 'sold' ? 'bg-red-500 text-white' : 'bg-yellow-400 text-black' }} px-4 py-2 rounded-full text-xs font-bold border-2 border-black">
                                {{ strtoupper($imageStatus) }}
                            </div>
                        </div>
                    @else
                        <div
                            class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-3 opacity-100">
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
