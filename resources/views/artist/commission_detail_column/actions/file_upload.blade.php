<!-- File Upload Section -->
<div class="bg-linear-to-r from-purple-50 to-pink-50 rounded-xl p-4 border-2 border-purple-200 shadow-sm">
    <label for="progress-file-input" class="block text-sm font-bold text-purple-800 mb-3">
        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
            </path>
        </svg>
        Upload Progress Image
    </label>
    <div class="flex flex-col gap-3">
        <div class="relative group">
            <input type="file" name="progress_image" id="progress-file-input"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept=".jpg,.jpeg,.png,.gif" />
            <div
                class="flex items-center justify-center gap-3 p-4 border-2 border-dashed border-purple-300 rounded-xl bg-white hover:bg-purple-25 hover:border-purple-400 transition-all duration-200 cursor-pointer group-hover:shadow-md">
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
        <button type="button" id="progress-upload-btn" data-commission-id="{{ $commission->commission_id }}"
            class="w-full group px-6 py-3 rounded-xl border-2 border-purple-500 bg-purple-500 text-white font-bold shadow-lg hover:shadow-xl hover:bg-purple-600 hover:-translate-y-1 transform transition-all duration-300 ease-out">
            <div class="flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Upload
            </div>
        </button>
    </div>
    <p class="text-xs text-purple-600 mt-2 font-medium">Supported formats: JPG, PNG, GIF
        (Max 10MB)</p>
</div>
