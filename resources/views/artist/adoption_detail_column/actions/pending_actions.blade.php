<div class="grid grid-cols-1 gap-3">
    <button
        id="confirm-order-btn" data-adoption-id="{{ $adoption->adoption_id }}"
        class="group relative px-6 py-3 rounded-xl border-2 border-green-500 bg-green-50 text-green-700 font-bold shadow-lg hover:shadow-xl hover:bg-green-100 hover:-translate-y-1 transform transition-all duration-300 ease-out">
        <div class="flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Confirm Order
        </div>
        <div
            class="absolute inset-0 rounded-xl bg-green-200 opacity-0 group-hover:opacity-20 transition-opacity duration-300">
        </div>
    </button>
    <button
        id="cancel-order-btn" data-adoption-id="{{ $adoption->adoption_id }}"
        class="group relative px-6 py-3 rounded-xl border-2 border-red-500 bg-red-50 text-red-700 font-bold shadow-lg hover:shadow-xl hover:bg-red-100 hover:-translate-y-1 transform transition-all duration-300 ease-out">
        <div class="flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            Cancel Order
        </div>
        <div
            class="absolute inset-0 rounded-xl bg-red-200 opacity-0 group-hover:opacity-20 transition-opacity duration-300">
        </div>
    </button>
</div>