<div
    class="bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-300 rounded-xl p-6 shadow-md">
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0">
            <div class="w-14 h-14 bg-gray-500 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </div>
        </div>
        <div class="flex-1">
            <h4 class="text-lg font-bold text-gray-900 mb-2">Order Cancelled</h4>
            <p class="text-sm text-gray-800 leading-relaxed mb-3">This adoption order has been cancelled.</p>
            
            @if($adoption->cancelled_at)
                <div class="flex items-center gap-2 text-sm text-gray-700 bg-white px-3 py-2 rounded-lg">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="font-semibold">Cancelled on:</span>
                    <span>{{ $adoption->cancelled_at->format('F j, Y \a\t g:i A') }}</span>
                </div>
            @endif
        </div>
    </div>
</div>
