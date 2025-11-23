<!-- MODAL PEMBELIAN -->
<div id="purchaseModal" class="fixed inset-0 z-50 flex items-center justify-center font-[HammersmithOne-Regular]"
    style="background-color: rgba(30,41,59,0.55); display: none;">
    <div
        class="bg-background rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto border-4 border-black shadow-[1vh_1vh_0_black]">

        <!-- FORM VIEW -->
        <div id="formView">
            <div
                class="flex items-center justify-between p-4 md:p-6 bg-linear-to-r from-pastel-turqoise to-turquoise rounded-t-xl">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">Complete Your Purchase</h2>
                    <p class="text-sm text-gray-700">You are adopting: <strong id="modalItemTitle"
                            class="text-gray-900"></strong></p>
                </div>
                <div class="flex items-center gap-2">
                    <span id="modalItemFormat"
                        class="text-xs font-semibold px-3 py-1 rounded-full bg-white/80 text-gray-800"></span>
                    <span id="modalItemStatus"
                        class="text-xs font-semibold px-3 py-1 rounded-full bg-gray-200 text-gray-800"></span>
                </div>
            </div>

            <form id="purchaseForm" method="POST" enctype="multipart/form-data"
                class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch">
                @csrf
                <input type="hidden" name="gallery_id" id="gallery_id">

                <!-- Left: Artwork preview + QRIS -->
                <div class="flex flex-col items-center gap-4 h-full justify-between">
                    <div
                        class="w-full bg-white rounded-lg p-2 border-2 border-black shadow-sm min-h-0 flex-1 flex items-center justify-center">
                        <img id="modalItemImage" src="" alt="Artwork preview"
                            class="w-full h-full object-contain rounded-md bg-gray-100">
                    </div>

                    <div class="w-full text-center">
                        <p id="modalItemPrice" class="text-2xl font-extrabold text-red-600"></p>
                        <p class="text-xs text-gray-600 mt-2">Please transfer the exact amount shown above.</p>
                    </div>


                </div>

                <!-- Right: Input Form -->
                <div class="flex flex-col justify-start h-full">
                    <div class="w-full max-w-[260px] mb-4 mx-auto">
                        <h3 class="text-base font-bold text-gray-800 mb-2 text-center">Scan to Pay</h3>
                        <div class="w-full">
                            <img src="{{ asset('assets/images/payment/qris_cho_lazey_fanmerch.png') }}" alt="QRIS Code"
                                class="w-full rounded-lg shadow-md border-2 border-white">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Your Email</label>
                        <div class="relative">
                            <input type="email" id="email" name="email"
                                class="w-full px-4 py-2 border-2 border-black rounded-lg mb-1 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                placeholder="your.email@example.com" aria-describedby="emailHelp">
                        </div>
                        <p id="emailHelp" class="text-xs text-gray-500 mt-1">We'll use this email to send confirmation and downloadable files after verification.</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-1" for="paymentProof">Upload Payment Proof</label>
                        <div class="flex items-center gap-3">
                            <label for="paymentProof" id="paymentProofLabel" class="inline-flex items-center gap-2 px-4 py-2 bg-[#a2e1db] hover:bg-[#7dc8c1] text-gray-800 rounded-full cursor-pointer border-2 border-black">
                                <span>Choose file</span>
                            </label>
                            <span id="paymentProofName" class="text-sm text-gray-600 truncate max-w-[160px]">No file chosen</span>
                        </div>
                        <input type="file" id="paymentProof" name="paymentProof"
                            accept="image/png, image/jpeg, image/jpg" class="hidden">
                        <p class="text-xs text-gray-500 mt-1">Accepted: PNG, JPG. Please keep file under 5MB.</p>
                    </div>

                    <div id="formErrors" class="text-red-500 text-sm mb-4"></div>

                    <div class="mt-auto flex flex-col sm:flex-row gap-3">
                        <button type="submit" id="submitButton"
                            class="flex-1 bg-[#4c9eff] border-4 border-black px-6 py-3 rounded-xl font-bold hover:bg-[#73b7ff] transition duration-300 text-center">
                            Submit Payment
                        </button>
                        <button type="button" id="closeModalButton"
                            class="flex-1 bg-gray-300 border-4 border-black px-6 py-3 rounded-xl font-bold hover:bg-gray-400 transition duration-300">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
