<div class="bg-gradient-to-br from-amber-50 to-orange-50 border-2 border-amber-300 rounded-xl p-6 shadow-md mb-4">
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0">
            <div class="w-12 h-12 bg-amber-500 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </div>
        </div>
        <div class="flex-1">
            <h4 class="text-lg font-bold text-amber-900 mb-2">Awaiting Payment Confirmation</h4>
            <p class="text-sm text-amber-800 leading-relaxed">
                Please verify that the payment has been received from the buyer before proceeding with file preparation.
            </p>
        </div>
    </div>
</div>

{{-- update payment status, if updated turn status to processing --}}
<button id="confirm-payment-btn" data-adoption-id="{{ $adoption->adoption_id }}"
    class="group relative w-full px-6 py-3 rounded-xl border-2 border-purple-600 bg-purple-600 text-white font-bold shadow-lg hover:shadow-xl hover:bg-purple-700 hover:border-purple-700 hover:-translate-y-1 transform transition-all duration-300 ease-out">
    <div class="flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
            </path>
        </svg>
        Confirm Payment
    </div>
    <div class="absolute inset-0 rounded-xl bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300">
    </div>
</button>
