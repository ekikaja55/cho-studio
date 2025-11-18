<!-- Left Column: Artwork Image & Gallery Info -->
<div class="space-y-6">
    <div class="overflow-hidden">
        <h2 class="text-2xl font-bold flex items-center gap-2 pb-4">
            Artwork Preview
        </h2>

        <div class="space-y-4">
            <!-- Artwork Image -->
            <div
                class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl p-3 sm:p-5 border-2 border-stone-300 shadow-inner relative">
                <div class="rounded-lg shadow-lg">
                    <img src="{{ asset($adoption->gallery->image_url) }}" alt="{{ $adoption->gallery->title }}"
                        class="w-full h-auto max-h-60 sm:max-h-80 object-contain rounded-lg mx-auto"
                        onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMDAgMTAwVjIwME0xNTAgMTUwSDI1MCIgc3Ryb2tlPSIjOUNBM0FGIiBzdHJva2Utd2lkdGg9IjIiLz4KPHRLEHT+'" />
                </div>
                <!-- Gallery ID Badge -->
                <div class="absolute top-2 left-2 sm:top-5 sm:left-5 flex items-center justify-center">
                    <div
                        class="inline-flex items-center gap-1.5 sm:gap-2 px-2 sm:px-4 py-1.5 sm:py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg shadow-lg">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                        <span class="text-xs sm:text-sm font-bold">Gallery ID: #{{ $adoption->gallery_id }}</span>
                    </div>
                </div>
            </div>

            <!-- Artwork Details Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div
                    class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-xl border-2 border-purple-200 shadow-sm">
                    <label class="block text-xs font-bold text-purple-700 mb-1 uppercase tracking-wide">Title</label>
                    <div class="text-sm sm:text-base font-bold text-purple-900 break-words">
                        {{ $adoption->gallery->title }}
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-4 rounded-xl border-2 border-indigo-200 shadow-sm">
                    <label class="block text-xs font-bold text-indigo-700 mb-1 uppercase tracking-wide">File
                        Format</label>
                    <div class="text-sm sm:text-base font-bold text-indigo-900">
                        {{ $adoption->gallery->file_format }}
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl border-2 border-green-200 shadow-sm">
                    <label class="block text-xs font-bold text-green-700 mb-1 uppercase tracking-wide">Price</label>
                    <div class="text-sm sm:text-base font-bold text-green-700">Rp
                        {{ number_format($adoption->price, 0, ',', '.') }}</div>
                </div>
            </div>
            <!-- Artwork Description -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-5 rounded-xl border-2 border-gray-200 shadow-md">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Description</label>
                </div>
                <div class="text-sm text-gray-800 leading-relaxed">
                    {{ $adoption->gallery->description }}
                </div>
            </div>
        </div>
    </div>
</div>
