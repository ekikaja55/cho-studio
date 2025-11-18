<div class="flex flex-col gap-3">
    <div class="bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-300 rounded-xl p-6 shadow-md">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <div class="w-14 h-14 bg-green-500 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <h4 class="text-lg font-bold text-green-900 mb-2">Order Completed</h4>
                <p class="text-sm text-green-800 leading-relaxed mb-4">This adoption order has been completed
                    successfully.
                </p>
            </div>
        </div>
        <!-- Timeline of dates -->
        <div class="space-y-2">
            @if ($adoption->paid_at)
                <div class="flex items-center gap-2 text-sm text-green-700 bg-white px-3 py-2 rounded-lg">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    <span class="font-semibold">Paid on:</span>
                    <span>{{ $adoption->paid_at->format('F j, Y \a\t g:i A') }}</span>
                </div>
            @endif

            @if ($adoption->delivered_at)
                <div class="flex items-center gap-2 text-sm text-green-700 bg-white px-3 py-2 rounded-lg">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                        </path>
                    </svg>
                    <span class="font-semibold">Delivered on:</span>
                    <span>{{ $adoption->delivered_at->format('F j, Y \a\t g:i A') }}</span>
                </div>
            @endif

            @if ($adoption->completed_at)
                <div class="flex items-center gap-2 text-sm text-green-700 bg-white px-3 py-2 rounded-lg">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    <span class="font-semibold">Completed on:</span>
                    <span>{{ $adoption->completed_at->format('F j, Y \a\t g:i A') }}</span>
                </div>
            @endif
        </div>
    </div>

    @if (!$adoption->completed_at)
        {{-- button mark as complete --}}
        <button id="mark-complete-btn" data-adoption-id="{{ $adoption->adoption_id }}"
            class="group relative w-full px-6 py-3 rounded-xl border-2 border-green-600 bg-green-600 text-white font-bold shadow-lg hover:shadow-xl hover:bg-green-700 hover:border-green-700 hover:-translate-y-1 transform transition-all duration-300 ease-out">
            <div class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                    </path>
                </svg>
                Mark as Complete
            </div>
            <div
                class="absolute inset-0 rounded-xl bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300">
            </div>
        </button>
    @endif

</div>
