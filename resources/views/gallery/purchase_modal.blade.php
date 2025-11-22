<!-- MODAL PEMBELIAN -->
<div id="purchaseModal" class="fixed inset-0 z-50 flex items-center justify-center font-[HammersmithOne-Regular]"
    style="background-color: rgba(30,41,59,0.55); display: none;">
    <div
        class="bg-background rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border-4 border-black shadow-[1vh_1vh_0_black]">
        <!-- FORM VIEW -->
        <div id="formView">
            <div class="bg-linear-to-r from-pastel-turqoise to-turquoise p-6 text-center rounded-t-xl">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Complete Your Purchase</h2>
                <p class="text-gray-700">You are adopting: <strong id="modalItemTitle" class="text-gray-900"></strong></p>
            </div>
            <form id="purchaseForm" method="POST" action="{{ route('gallery.adopt') }}" enctype="multipart/form-data"
                class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                @csrf
                <input type="hidden" name="gallery_id" id="gallery_id">

                <!-- Kolom Kiri: QRIS -->
                <div class="flex flex-col items-center">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Scan to Pay</h3>
                    <div class="w-full max-w-[250px]">
                        <img src="{{ asset('assets/images/payment/qris_cho_lazey_fanmerch.png') }}" alt="QRIS Code"
                            class="w-full rounded-lg shadow-md border-2 border-white">
                    </div>
                    <p class="text-center text-2xl font-bold text-red-600 mt-4" id="modalItemPrice"></p>
                    <p class="text-xs text-gray-600 mt-2 text-center">Please transfer the exact amount.</p>
                </div>

                <!-- Kolom Kanan: Input Form -->
                <div class="flex flex-col justify-center">
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Your
                            Email</label>
                        <input type="email" id="email" name="email" required
                            class="w-full px-4 py-2 border-2 border-black rounded-lg"
                            placeholder="your.email@example.com">
                    </div>
                    <div class="mt-4">
                        <label for="paymentProof" class="block text-sm font-bold text-gray-700 mb-1">Upload
                            Payment
                            Proof</label>
                        <input type="file" id="paymentProof" name="paymentProof" required
                            accept="image/png, image/jpeg, image/jpg"
                            class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#a2e1db] file:text-gray-800 hover:file:bg-[#7dc8c1] border-2 border-black rounded-lg cursor-pointer">
                    </div>
                    <div class="mt-8 flex items-center gap-4">
                        <button type="submit" id="submitButton"
                            class="w-full bg-[#4c9eff] border-4 border-black px-6 py-3 rounded-xl font-bold hover:bg-[#73b7ff] transition duration-300">
                            Submit
                        </button>
                        <button type="button" id="closeModalButton"
                            class="w-1/2 bg-gray-300 border-4 border-black px-6 py-3 rounded-xl font-bold hover:bg-gray-400 transition duration-300">
                            Cancel
                        </button>
                    </div>
                    <div id="formErrors" class="text-red-500 text-sm mt-2"></div>
                </div>
            </form>
        </div>

        <!-- THANK YOU VIEW -->
        <div id="thankYouView" class="hidden p-8 md:p-12 text-center">
            <div class="bg-gradient-to-r from-[#a2e1db] to-[#7dc8c1] p-6 rounded-t-xl mb-6">
                <h2 class="text-3xl font-bold text-gray-800">Thank You!</h2>
            </div>
            <p class="text-lg text-gray-800 mb-4">
                Your submission has been received. Please wait for confirmation from the artist via the email
                you provided.
            </p>
            <p class="text-sm text-gray-600 mb-6">
                Verification may take up to 24 hours. Once your payment is verified, the artwork files will be
                sent to you.
            </p>
            <button id="finishButton"
                class="bg-gray-800 text-white px-8 py-3 rounded-xl font-bold hover:bg-black transition duration-300">
                Close
            </button>
        </div>
    </div>
</div>
</div>
