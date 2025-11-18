<div class="xl:col-span-5 space-y-6">
    <div class="overflow-hidden">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-2 pb-4">
                Commission Info
            </h2>
        </div>

        <div class="space-y-5">
            <!-- Progress Images Section -->
            <div class="space-y-3">
                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wide flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Progress Images
                </label>

                @if ($commission->progressImages && $commission->progressImages->count() > 0)
                    <!-- Image Selector -->
                    <select id="progress-image-selector"
                        class="w-full px-4 py-3 border-2 border-stone-300 rounded-xl bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none font-semibold text-gray-700 shadow-sm hover:border-blue-400 transition-all duration-200">
                        @foreach ($commission->progressImages as $index => $progress)
                            <option value="{{ $index }}" {{ $index === 0 ? 'selected' : '' }}>
                                {{ $progress->stage_label }} -
                                {{ $progress->created_at->format('M d, Y') }}
                                @if ($progress->revision_notes)
                                    - {{ Str::limit($progress->revision_notes, 30) }}
                                @endif
                            </option>
                        @endforeach
                    </select>

                    <!-- Image Display -->
                    <div
                        class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl p-5 border-2 border-stone-300 shadow-inner">
                        @foreach ($commission->progressImages as $index => $progress)
                            <div class="progress-image-container {{ $index === 0 ? '' : 'hidden' }}"
                                data-image-index="{{ $index }}">
                                <div class="bg-white rounded-lg p-2 shadow-lg">
                                    <img src="{{ asset($progress->image_link) }}" alt="{{ $progress->stage_label }}"
                                        class="max-w-full max-h-80 object-contain rounded-lg mx-auto"
                                        onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMDAgMTAwVjIwME0xNTAgMTUwSDI1MCIgc3Ryb2tlPSIjOUNBM0FGIiBzdHJva2Utd2lkdGg9IjIiLz4KPHRLEHT+'" />
                                </div>

                                <div class="mt-4 space-y-2">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span
                                            class="inline-block px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md">
                                            {{ $progress->stage_label }}
                                        </span>
                                        <span class="text-xs text-gray-600 font-semibold">
                                            {{ $progress->created_at->format('F j, Y \a\t g:i A') }}
                                        </span>
                                    </div>
                                    @if ($progress->revision_notes)
                                        <div class="bg-white p-3 rounded-xl border-2 border-blue-200 shadow-sm">
                                            <p class="text-xs font-bold text-blue-600 mb-1 uppercase tracking-wide">
                                                Revision Notes:</p>
                                            <p class="text-sm text-gray-800 leading-relaxed">
                                                {{ $progress->revision_notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        class="bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-300 rounded-xl p-8 text-center shadow-md">
                        <svg class="w-20 h-20 mx-auto text-yellow-500 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <p class="text-lg font-bold text-yellow-900 mb-2">No Images Yet</p>
                        <p class="text-sm text-yellow-700">Progress images will appear once uploaded.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Commission Details -->
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div
                        class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-xl border-2 border-purple-200 shadow-sm">
                        <label
                            class="block text-xs font-bold text-purple-700 mb-2 uppercase tracking-wide">Category</label>
                        <div class="text-lg font-bold text-purple-900">{{ $commission->category_text }}
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl border-2 border-blue-200 shadow-sm">
                        <label class="block text-xs font-bold text-blue-700 mb-2 uppercase tracking-wide">Background
                            Type</label>
                        <div class="text-lg font-bold text-blue-900">{{ $commission->background_type_text }}
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl border-2 border-green-200 shadow-sm">
                    <label class="block text-xs font-bold text-green-700 mb-2 uppercase tracking-wide">Price</label>

                    <!-- Display Mode -->
                    <div id="price-display-mode" class="flex items-center justify-between gap-2">
                        <div class="text-lg font-bold text-green-700 truncate">
                            Rp {{ number_format($commission->price, 0, ',', '.') }}
                        </div>
                        @if ($commission->payment_status === 'pending')
                            <button type="button" id="edit-price-btn"
                                class="shrink-0 px-2.5 py-2 rounded-lg border-2 border-green-500 bg-white text-green-600 font-bold shadow-md hover:shadow-lg hover:bg-green-50 hover:-translate-y-0.5 transform transition-all duration-200"
                                title="Edit Price">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </button>
                        @endif
                    </div>

                    <!-- Edit Mode (hidden by default) -->
                    <div id="price-edit-mode" class="hidden space-y-2">
                        <div class="flex items-center gap-2">
                            <label for="commission-price-input"
                                class="font-bold text-green-700 text-sm shrink-0">Rp</label>
                            <input type="text" id="commission-price-input"
                                value="{{ number_format($commission->price, 0, ',', '.') }}"
                                data-raw-value="{{ $commission->price }}"
                                class="flex-1 min-w-0 px-3 py-2 border-2 border-green-300 rounded-lg bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none font-bold text-green-700 text-sm transition-all duration-200"
                                placeholder="0" />
                        </div>
                        <div class="flex gap-2">
                            <button type="button" id="update-price-btn"
                                data-commission-id="{{ $commission->commission_id }}"
                                class="flex-1 px-3 py-2 rounded-lg border-2 border-green-500 bg-green-500 text-white font-bold text-sm shadow-md hover:shadow-lg hover:bg-green-600 hover:-translate-y-0.5 transform transition-all duration-200"
                                title="Save Price">
                                <div class="flex items-center justify-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Save</span>
                                </div>
                            </button>
                            <button type="button" id="cancel-price-edit-btn"
                                class="flex-1 px-3 py-2 rounded-lg border-2 border-gray-400 bg-white text-gray-600 font-bold text-sm shadow-md hover:shadow-lg hover:bg-gray-50 hover:-translate-y-0.5 transform transition-all duration-200"
                                title="Cancel">
                                <div class="flex items-center justify-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span>Cancel</span>
                                </div>
                            </button>
                        </div>
                        <p class="text-xs text-green-600">Adjust if needed before reaching an agreement</p>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl border-2 border-gray-200 shadow-sm">
                    <label
                        class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Description</label>
                    <div class="text-gray-800 leading-relaxed text-sm">{{ $commission->description }}
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div
                        class="bg-gradient-to-br from-orange-50 to-orange-100 p-4 rounded-xl border-2 border-orange-200 shadow-sm">
                        <label
                            class="block text-xs font-bold text-orange-700 mb-2 uppercase tracking-wide">Deadline</label>
                        <div id="deadline-display-mode" class="flex items-center justify-between gap-2">
                            <div>
                                <div class="text-sm font-bold text-orange-900">
                                    {{ date('F j, Y', strtotime($commission->deadline)) }}
                                </div>
                                @php
                                    $daysLeft = ceil((strtotime($commission->deadline) - time()) / (60 * 60 * 24));
                                @endphp
                                @if ($daysLeft > 0)
                                    <div class="text-xs font-semibold text-blue-600 mt-1">
                                        {{ $daysLeft }} days left</div>
                                @elseif($daysLeft == 0)
                                    <div class="text-xs font-semibold text-orange-600 mt-1">Due today</div>
                                @else
                                    <div class="text-xs font-semibold text-red-600 mt-1">
                                        {{ abs($daysLeft) }} days overdue</div>
                                @endif
                            </div>
                            @if ($commission->payment_status === 'pending')
                                <button type="button" id="edit-deadline-btn"
                                    class="flex-shrink-0 px-2.5 py-2 rounded-lg border-2 border-orange-500 bg-white text-orange-600 font-bold shadow-md hover:shadow-lg hover:bg-orange-50 hover:-translate-y-0.5 transform transition-all duration-200"
                                    title="Edit Deadline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </svg>
                                </button>
                            @endif
                        </div>
                        <!-- Edit Mode (hidden by default) -->
                        <div id="deadline-edit-mode" class="hidden space-y-2">
                            <div class="flex items-center gap-2">
                                <label for="commission-deadline-input"
                                    class="font-bold text-orange-700 text-sm flex-shrink-0">Date</label>
                                <input type="date" id="commission-deadline-input"
                                    value="{{ date('Y-m-d', strtotime($commission->deadline)) }}"
                                    data-raw-value="{{ $commission->deadline }}"
                                    class="flex-1 min-w-0 px-3 py-2 border-2 border-orange-300 rounded-lg bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none font-bold text-orange-700 text-sm transition-all duration-200"
                                    placeholder="YYYY-MM-DD" />
                            </div>
                            <div class="flex gap-2">
                                <button type="button" id="update-deadline-btn"
                                    data-commission-id="{{ $commission->commission_id }}"
                                    class="flex-1 px-3 py-2 rounded-lg border-2 border-orange-500 bg-orange-500 text-white font-bold text-sm shadow-md hover:shadow-lg hover:bg-orange-600 hover:-translate-y-0.5 transform transition-all duration-200"
                                    title="Save Deadline">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Save</span>
                                    </div>
                                </button>
                                <button type="button" id="cancel-deadline-edit-btn"
                                    class="flex-1 px-3 py-2 rounded-lg border-2 border-gray-400 bg-white text-gray-600 font-bold text-sm shadow-md hover:shadow-lg hover:bg-gray-50 hover:-translate-y-0.5 transform transition-all duration-200"
                                    title="Cancel">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <span>Cancel</span>
                                    </div>
                                </button>
                            </div>
                            <p class="text-xs text-orange-600">Adjust the deadline before agreement is reached</p>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl border-2 border-blue-200 shadow-sm">
                        <label class="block text-xs font-bold text-blue-700 mb-2 uppercase tracking-wide">Order
                            Date</label>
                        <div class="text-sm font-bold text-blue-900">
                            {{ date('M j, Y', strtotime($commission->created_at)) }}</div>
                        <div class="text-xs text-blue-700 mt-1">
                            {{ date('g:i A', strtotime($commission->created_at)) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
