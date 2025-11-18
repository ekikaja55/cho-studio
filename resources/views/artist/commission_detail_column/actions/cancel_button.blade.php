<button id="cancel-commission-btn" data-commission-id="{{ $commission->commission_id }}"
    class="group relative px-6 py-3 rounded-xl border-2 border-red-500 bg-red-50 text-red-700 font-bold shadow-lg hover:shadow-xl hover:bg-red-100 hover:-translate-y-1 transform transition-all duration-300 ease-out">
    <div class="flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
        Cancel Commission
    </div>
    <div
        class="absolute inset-0 rounded-xl bg-red-200 opacity-0 group-hover:opacity-20 transition-opacity duration-300">
    </div>
</button>

{{-- Enhanced cancellation reason section --}}
<div class="hidden mt-6 p-6 border-2 border-red-300 rounded-2xl bg-gradient-to-br from-red-50 to-red-100 shadow-lg transform transition-all duration-300 ease-out"
    id="cancellation-reason-section">
    <div class="mb-4">
        <h3 class="text-lg font-bold text-red-900 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                </path>
            </svg>
            Cancellation Reason
        </h3>
        <p class="text-sm text-red-700 mt-1">Please provide a detailed reason for cancelling this commission.</p>
    </div>

    <textarea id="cancellation-reason-textarea" rows="4" placeholder="Enter cancellation reason (required)..."
        class="w-full px-4 py-3 border-2 border-red-200 rounded-xl focus:border-red-400 focus:ring-2 focus:ring-red-200 transition-all duration-200 resize-none bg-white shadow-sm placeholder-red-300 text-gray-800"
        required></textarea>

    <div class="flex gap-3 mt-4">
        <button id="submit-cancellation-btn"
            class="group relative flex-1 px-6 py-3 rounded-xl border-2 border-red-600 bg-red-600 text-white font-bold shadow-lg hover:shadow-xl hover:bg-red-700 hover:border-red-700 hover:-translate-y-1 transform transition-all duration-300 ease-out disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0">
            <div class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Confirm Cancellation
            </div>
        </button>

        <button id="cancel-cancellation-btn"
            class="group relative px-6 py-3 rounded-xl border-2 border-gray-300 bg-white text-gray-700 font-bold shadow-lg hover:shadow-xl hover:bg-gray-50 hover:border-gray-400 hover:-translate-y-1 transform transition-all duration-300 ease-out">
            <div class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
                Cancel
            </div>
        </button>
    </div>
</div>
