<div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 border-2 border-blue-200 shadow-sm">
    <label for="progress_status" class="block text-sm font-bold text-blue-800 mb-3">
        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
        </svg>
        Update Progress Status
    </label>
    <div class="flex gap-3">
        <select id="update-progress-select" name="progress_status"
            class="flex-1 px-4 py-3 border-2 border-blue-300 rounded-xl bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none font-semibold text-gray-700 shadow-md transition-all duration-200">
            <option value="in_progress_sketch"
                {{ $commission->progress_status === 'in_progress_sketch' ? 'selected' : '' }}>
                In Progress (Sketch)
            </option>
            <option value="in_progress_coloring"
                {{ $commission->progress_status === 'in_progress_coloring' ? 'selected' : '' }}>
                In Progress (Coloring)
            </option>
        </select>
        <button type="button" id="update-progress-btn" data-commission-id="{{ $commission->commission_id }}"
            class="group px-6 py-3 rounded-xl border-2 border-blue-500 bg-blue-500 text-white font-bold shadow-lg hover:shadow-xl hover:bg-blue-600 hover:-translate-y-1 transform transition-all duration-300 ease-out">
            <div class="flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Save
            </div>
        </button>
    </div>
</div>
