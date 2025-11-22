<div id="preview-payment-proof-modal" class="fixed inset-0 z-50 flex items-center justify-center font-[HammersmithOne-Regular]"
    style="background-color: rgba(30,41,59,0.55); display: none;">
    <div class="modal-content bg-white rounded-xl shadow-2xl p-8 relative w-1/2">
        <button id="close-preview-payment-proof-modal"
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
        <h3 class="text-xl font-bold mb-4 text-blue-700">Preview Payment Proof</h3>
        <img src="{{ asset($adoption->payment_confirmation) }}" alt="Preview Full payment proof" id="previewPaymentProofFull"
            class="max-w-1/2 rounded-lg mx-auto border border-green-300 shadow">
    </div>
</div>
