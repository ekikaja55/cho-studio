{{-- filepath: d:\hp\Documents\FILE KULIAH\Semester 5\sdp\chostudio-website\resources\views\artist\actions\payment_status_update.blade.php --}}
<div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4 border-2 border-green-200 shadow-sm">
    <label for="payment_status" class="block text-sm font-bold text-green-800 mb-3">
        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
            </path>
        </svg>
        Update Payment Status
    </label>
    <div class="flex gap-3">
        <select id="update-payment-select" name="payment_status"
            class="flex-1 px-4 py-3 border-2 border-green-300 rounded-xl bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none font-semibold text-gray-700 shadow-md transition-all duration-200">
            <option value="pending" {{ $commission->payment_status === 'pending' ? 'selected' : '' }}>
                Unpaid (Pending Payment)
            </option>
            <option value="dp" {{ $commission->payment_status === 'dp' ? 'selected' : '' }}>
                Down Payment (DP)
            </option>
            <option value="paid" {{ $commission->payment_status === 'paid' ? 'selected' : '' }}>
                Paid
            </option>
            <option value="refunded" {{ $commission->payment_status === 'refunded' ? 'selected' : '' }}>
                Refunded
            </option>
        </select>
        <button type="button" id="update-payment-btn" data-commission-id="{{ $commission->commission_id }}"
            class="group px-6 py-3 rounded-xl border-2 border-green-500 bg-green-500 text-white font-bold shadow-lg hover:shadow-xl hover:bg-green-600 hover:-translate-y-1 transform transition-all duration-300 ease-out">
            <div class="flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Save
            </div>
        </button>
    </div>
</div>
