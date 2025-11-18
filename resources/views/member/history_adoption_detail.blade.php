@extends('member.member_template')

@section('content')
    {{-- Main Container: Centered and full-height adaptive --}}
    <div class="flex justify-center items-start font-[HammersmithOne-Regular] overflow-auto py-12 px-6 sm:px-10 lg:px-20"
        style="min-height: calc(100vh - 80px)">

        {{-- Detail Card Container --}}
        <div
            class="w-full bg-[var(--color-background)] shadow-2xl border-3 border-stone-900 rounded-2xl p-6 lg:p-10 relative">

            {{-- Main Content Card (Artwork Details and Image) --}}
            <div class="w-full rounded-xl p-4 sm:p-6 md:p-8 border-4 border-amber-500 bg-amber-100 shadow-inner">

                {{-- Header/Back Button and Title (Consistent Layout) --}}
                <div class="relative mb-8 text-center border-b border-amber-200 pb-4">
                    <a href="{{ route('member.history') }}"
                        class="md:absolute md:top-1/2 md:-translate-y-1/2 md:left-0 inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-cyan-700 bg-cyan-100 rounded-full shadow-md hover:bg-cyan-200 transition-all duration-200">
                        <i class="fa-solid fa-arrow-left"></i>
                        Back to History
                    </a>
                    <h1 class="text-3xl font-extrabold text-gray-800 tracking-wide">Adoption Details</h1>
                    <p class="text-lg text-gray-600 mt-1">"{{ $adoption->gallery->title }}"</p>
                </div>

                <div class="flex flex-col lg:flex-row justify-between gap-8">

                    {{-- Left Column: Artwork Image & Status (Consistent Width: lg:w-2/5) --}}
                    <div class="w-full lg:w-2/5 flex flex-col items-center space-y-6">

                        <div
                            class="bg-white rounded-xl p-3 sm:p-5 border-2 border-amber-300 shadow-inner relative">
                            <div class="rounded-lg shadow-lg">
                                <img src="{{ asset($adoption->gallery->image_url) }}" alt="{{ $adoption->gallery->title }}"
                                    class="w-full h-auto max-h-60 sm:max-h-80 object-contain rounded-lg mx-auto"
                                    onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMDAgMTAwVjIwME0xNTAgMTUwSDI1MCIgc3Ryb2tlPSIjOUNBM0FGIiBzdHJva2Utd2lkdGg9IjIiLz4KPHRLEHT+'" />
                            </div>
                            <!-- Gallery ID Badge -->
                            <div class="absolute top-2 left-2 sm:top-5 sm:left-5 flex items-center justify-center">
                                <div
                                    class="inline-flex items-center gap-1.5 sm:gap-2 px-2 sm:px-4 py-1.5 sm:py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg shadow-lg">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                        </path>
                                    </svg>
                                    <span class="text-xs sm:text-sm font-bold">Gallery ID:
                                        #{{ $adoption->gallery_id }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Status Box (Consistent Styling) --}}
                        <div class="w-full p-4 bg-white rounded-xl shadow-lg border-2 border-amber-300 text-gray-800">
                            <h3 class="text-lg font-extrabold text-center mb-3 border-b border-amber-100 pb-2">Status
                            </h3>

                            {{-- Payment Status --}}
                            <div class="flex justify-between items-center py-2">
                                <span class="font-bold">Payment:</span>
                                <div
                                    class="px-3 py-1 rounded-full text-white {{ $adoption->payment_status_color }} text-sm font-medium shadow-md">
                                    {{ $adoption->payment_status_text }}
                                </div>
                            </div>

                            {{-- Order Status --}}
                            <div class="flex justify-between items-center py-2 border-t border-amber-100 mt-1">
                                <span class="font-bold">Order:</span>
                                <div
                                    class="px-3 py-1 rounded-full text-white {{ $adoption->order_status_color }} text-sm font-medium shadow-md">
                                    {{ $adoption->order_status_text }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Details and Description (Consistent Width: lg:w-3/5) --}}
                    <div class="w-full lg:w-3/5 flex flex-col space-y-3 text-gray-700">

                        {{-- Core Details Grid (Consistent Grid and Box Styling) --}}
                        <div class="grid grid-cols-3 gap-4 text-sm">

                            {{-- Order Date (Blue/Indigo Scheme for Dates/Order Info) --}}
                            <div class="p-4 rounded-xl border-2 border-blue-300 bg-blue-100 shadow-inner">
                                <label class="block text-xs font-bold text-blue-700 mb-1 uppercase">Order Date</label>
                                <div class="text-sm font-bold text-blue-900">
                                    {{ $adoption->created_at->format('M j, Y \a\t g:i A') }}
                                </div>
                            </div>

                            {{-- File Format (Indigo Scheme) --}}
                            <div class="p-4 rounded-xl border-2 border-indigo-300 bg-indigo-100 shadow-inner">
                                <label class="block text-xs font-bold text-indigo-700 mb-1 uppercase">File
                                    Format</label>
                                <div class="text-lg font-bold text-indigo-900">
                                    {{ $adoption->gallery->file_format }}
                                </div>
                            </div>

                            {{-- Price (Green Scheme) --}}
                            <div class="p-4 rounded-xl border-2 border-green-300 bg-green-100 shadow-inner">
                                <label class="block text-xs font-bold text-green-700 mb-1 uppercase">Price</label>
                                <div class="text-xl font-bold text-green-700">
                                    <i class="fa-solid fa-money-bill-wave mr-2"></i>
                                    Rp {{ number_format($adoption->gallery->price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        {{-- Artwork Description (Red/Themed Scheme) --}}
                        <div class="bg-red-50 p-4 rounded-xl border-2 border-red-300 shadow-sm">
                            <p class="font-bold text-lg mb-2 border-b border-red-200 pb-1 flex items-center gap-2">
                                Artwork Description
                            </p>
                            <div class="text-red-800 leading-relaxed text-sm">
                                <p>{{ $adoption->gallery->description }}</p>
                            </div>
                        </div>

                        {{-- Buyer Message (General Gray/White Scheme) --}}
                        <div class="bg-white p-4 rounded-xl border-2 border-gray-300 shadow-sm">
                            <p class="font-bold text-lg mb-2 border-b border-gray-200 pb-1 flex items-center gap-2">
                                Buyer's Message
                            </p>
                            <div class="text-gray-800 leading-relaxed text-sm">
                                <p>{{ $adoption->buyer_message }}</p>
                            </div>
                        </div>

                        <div
                            class="w-full p-5 bg-linear-to-br from-white to-amber-50 rounded-2xl shadow-xl border-2 border-amber-300">
                            <p
                                class="font-bold text-lg mb-3 border-b border-amber-200 pb-2 flex items-center gap-2 text-amber-700">
                                Transaction Timeline
                            </p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm mt-2">
                                <div class="flex items-center gap-2 p-2 rounded-lg bg-amber-100 border border-amber-200">
                                    <i class="fa-solid fa-calendar-check text-amber-600"></i>
                                    <span class="font-semibold">Confirmed At:</span>
                                    <span
                                        class="ml-auto">{{ optional($adoption->confirmed_at)->format('M j, Y \a\t H:i') ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center gap-2 p-2 rounded-lg bg-amber-100 border border-amber-200">
                                    <i class="fa-solid fa-sack-dollar text-amber-600"></i>
                                    <span class="font-semibold">Paid At:</span>
                                    <span
                                        class="ml-auto">{{ optional($adoption->paid_at)->format('M j, Y \a\t H:i') ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center gap-2 p-2 rounded-lg bg-amber-100 border border-amber-200">
                                    <i class="fa-solid fa-box text-amber-600"></i>
                                    <span class="font-semibold">Delivered At:</span>
                                    <span
                                        class="ml-auto">{{ optional($adoption->delivered_at)->format('M j, Y \a\t H:i') ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center gap-2 p-2 rounded-lg bg-amber-100 border border-amber-200">
                                    <i class="fa-solid fa-star text-amber-600"></i>
                                    <span class="font-semibold">Completed At:</span>
                                    <span
                                        class="ml-auto">{{ optional($adoption->completed_at)->format('M j, Y \a\t H:i') ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
