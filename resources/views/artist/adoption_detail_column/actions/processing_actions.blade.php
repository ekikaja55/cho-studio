{{-- file upload section --}}
<style>
    /* change placeholder color for inputs on this partial */
    #download_link::placeholder,
    #delivery_notes::placeholder {
        color: #6b7280;
        /* gray-500 */
        opacity: 1;
    }

    /* vendor prefixes for broader support */
    #download_link::-webkit-input-placeholder,
    #delivery_notes::-webkit-input-placeholder {
        color: #6b7280;
        opacity: 1;
    }

    #download_link:-ms-input-placeholder,
    #delivery_notes:-ms-input-placeholder {
        color: #6b7280;
        opacity: 1;
    }

    #download_link::-ms-input-placeholder,
    #delivery_notes::-ms-input-placeholder {
        color: #6b7280;
        opacity: 1;
    }

    #download_link::-moz-placeholder,
    #delivery_notes::-moz-placeholder {
        color: #6b7280;
        opacity: 1;
    }

    #download_link:-webkit-autofill,
    #download_link:-webkit-autofill:hover,
    #download_link:-webkit-autofill:focus,
    #download_link:-webkit-autofill:active {
        -webkit-box-shadow: 0 0 0 30px white inset !important;
        -webkit-text-fill-color: #000 !important;
    }

    #download_link::autofill {
        background-color: white !important;
    }
</style>

<div class="overflow-hidden">

    <div class="space-y-4">
        <!-- Delivery Method Selection -->
        <div class="bg-linear-to-br from-indigo-50 to-indigo-100 p-5 rounded-xl border-2 border-indigo-200 shadow-md">
            <label class="text-sm font-bold text-indigo-700 mb-3 block">Choose Delivery Method:</label>
            <div class="grid grid-cols-1 gap-2 lg:grid-cols-2">
                <label
                    class="flex items-center gap-2 p-3 bg-white rounded-lg border-2 border-indigo-200 cursor-pointer hover:bg-indigo-50 transition-colors duration-200">
                    <input type="radio" name="delivery_method" value="upload" id="delivery_method_upload"
                        class="w-5 h-5 text-purple-600 focus:ring-purple-500" checked>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                            </path>
                        </svg>
                        <span class="text-sm font-semibold text-gray-800">Upload Files Directly</span>
                    </div>
                </label>

                <label
                    class="flex items-center gap-2 p-3 bg-white rounded-lg border-2 border-indigo-200 cursor-pointer hover:bg-indigo-50 transition-colors duration-200">
                    <input type="radio" name="delivery_method" value="link" id="delivery_method_link"
                        class="w-5 h-5 text-blue-600 focus:ring-blue-500">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                            </path>
                        </svg>
                        <span class="text-sm font-semibold text-gray-800">Provide Download Link</span>
                    </div>
                </label>
            </div>
        </div>

        <!-- Upload Files Card -->
        <div id="upload-section"
            class="bg-linear-to-br from-purple-50 to-purple-100 p-5 rounded-xl border-2 border-purple-200 shadow-md">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <label class="text-sm font-bold text-purple-700">Upload Files</label>
            </div>

            <div class="flex flex-col gap-3">
                <div class="relative group">
                    <input type="file" id="delivery_file" name="delivery_file"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                        accept="image/*,.pdf,.zip,.rar,.psd,.ai,.eps" />
                    <div
                        class="flex items-center justify-center gap-3 p-4 border-2 border-dashed border-purple-300 rounded-xl bg-white hover:bg-purple-50 hover:border-purple-400 transition-all duration-200 cursor-pointer group-hover:shadow-md">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                            </path>
                        </svg>
                        <div class="text-center">
                            <span class="text-purple-700 font-semibold">Click to upload</span>
                            <span class="text-purple-500"> or drag and drop</span>
                        </div>
                    </div>
                    <div id="file-name"
                        class="hidden mt-2 text-sm text-gray-600 bg-purple-50 px-3 py-2 rounded-lg border border-purple-200">
                    </div>
                </div>
            </div>
            <p class="text-xs text-purple-600 mt-2 font-medium">Supported formats: JPG, PNG, PDF, ZIP, PSD, AI (Single
                file, Max 100MB)</p>
        </div>

        <!-- Download Link Card -->
        <div id="link-section"
            class="bg-linear-to-br from-blue-50 to-blue-100 p-5 rounded-xl border-2 border-blue-200 shadow-md hidden">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                    </path>
                </svg>
                <label class="text-sm font-bold text-blue-700">Provide Download Link</label>
            </div>

            <input type="url" id="download_link" name="download_link" value="{{ $adoption->download_link ?? '' }}"
                class="w-full px-4 py-3 border-2 border-blue-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 font-[HammersmithOne-Regular] text-sm"
                placeholder="https://drive.google.com/... or https://dropbox.com/...">

            <p class="text-xs text-blue-600 mt-2 flex items-center gap-1">
                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Provide a link to Google Drive, Dropbox, WeTransfer, or any file hosting service</span>
            </p>
        </div>

        <!-- Delivery Notes Section -->
        <div class="overflow-hidden">

            <div class="bg-linear-to-br from-teal-50 to-cyan-50 p-5 rounded-xl border-2 border-teal-200 shadow-md">
                <label class="block text-sm font-bold text-teal-700 mb-3">
                    Add notes about file delivery
                    <span class="text-xs font-normal text-teal-600 ml-2">(Optional)</span>
                </label>
                <textarea id="delivery_notes" name="delivery_notes" rows="6"
                    class="w-full px-4 py-3 border-2 border-teal-300 rounded-lg bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 resize-none font-[HammersmithOne-Regular] text-sm"
                    placeholder="e.g., Files uploaded to Google Drive, Download link sent via email, Special instructions for the buyer...">{{ $adoption->delivery_notes }}</textarea>

                <div class="flex items-center justify-between">
                    <span class="text-xs text-teal-600">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        These notes are for your reference
                    </span>
                    <button id="save-notes-btn" data-adoption-id="{{ $adoption->adoption_id }}"
                        class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 text-sm">
                        Save Notes
                    </button>
                </div>
            </div>
        </div>


        <!-- Send Delivery Email Button -->
        <button type="button" id="send-delivery-email-btn" data-adoption-id="{{ $adoption->adoption_id }}"
            class="w-full px-6 py-4 rounded-xl border-2 border-emerald-600 bg-emerald-600 text-white font-bold shadow-lg hover:shadow-xl hover:bg-emerald-700 hover:border-emerald-700 hover:-translate-y-1 transform transition-all duration-300 ease-out">
            <div class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
                Send File Links to Buyer (via Email)
            </div>
        </button>
    </div>
</div>
