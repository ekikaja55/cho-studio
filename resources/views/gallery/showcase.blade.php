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
                <button onclick="window.location.href='/home'">Home</button>
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
                    <button onclick="window.location.href='/login'">Member</button>
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
        <div class="sm:mt-3 py-3 flex-1 h-full flex flex-col gap-6">
            @php
                // Controller provides:
                // - $available: items with status == 'available'
                // - $not_sold: items with status == 'not_sold'
                // - $allGallery: all items
                $available = $available ?? collect();
                $not_sold = $not_sold ?? collect();
                $allGallery = $allGallery ?? collect();
            @endphp

            {{-- SHOWCASE SECTION --}}
            <div id="galleryShowcaseCustom" class="flex w-full h-full gap-3 sm:gap-4 justify-center items-center pb-4">
                {{-- Left: featured available artwork (use first available if present) --}}
                <div class="flex-shrink-0 w-[45%] sm:w-[48%] h-full flex items-center justify-center">
                    @if ($available->isNotEmpty())
                        @php
                            $featured = $available->first();
                            $img = asset($featured->image_url);
                        @endphp
                        <div class="rounded-3xl border-4 border-black shadow-[0.6vh_0.6vh_0_black] w-full h-full overflow-hidden bg-white cursor-pointer relative hover:scale-[1.03] transition-all duration-300 showcase-item group protected-image-container watermark-tiled"
                            data-id="{{ $featured->gallery_id }}">
                            <img src="{{ $img }}" data-original-src="{{ $img }}" alt="Featured Artwork"
                                class="object-cover w-full h-full group-hover:brightness-110 transition-all duration-300"
                                loading="lazy" />
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <p class="text-white font-bold text-sm truncate">Featured Artwork</p>
                            </div>
                        </div>
                    @else
                        <div
                            class="rounded-3xl border-4 border-black shadow-[0.6vh_0.6vh_0_black] w-full h-full overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-400 flex-col gap-2">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm font-medium">No featured artwork yet</p>
                        </div>
                    @endif
                </div>

                {{-- Right: gallery items grid --}}
                <div class="flex flex-col justify-between h-full w-[55%] sm:w-[52%] gap-3 sm:gap-4">
                    {{-- Top row --}}
                    <div class="flex gap-3 sm:gap-4 h-1/2">
                        @foreach ($not_sold->take(2) as $art)
                            @php
                                $img = asset($art->image_url);
                                $isSold = $art->status === 'sold';
                            @endphp
                            <div class="rounded-2xl border-4 border-black shadow-[0.4vh_0.4vh_0_black] w-[49%] h-full overflow-hidden bg-white hover:scale-[1.02] transition-all duration-300 showcase-item group cursor-pointer protected-image-container watermark-tiled"
                                data-id="{{ $art->gallery_id }}">
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
                        @foreach ($not_sold->skip(2)->take(2) as $art)
                            @php
                                $img = asset($art->image_url);
                                $isSold = $art->status === 'sold';
                            @endphp
                            <div class="rounded-2xl border-4 border-black shadow-[0.4vh_0.4vh_0_black] w-full h-full overflow-hidden bg-white hover:scale-[1.02] transition-all duration-300 showcase-item group cursor-pointer protected-image-container watermark-tiled"
                                data-id="{{ $art->gallery_id }}">
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
