<!-- Middle Column: Buyer Info & Message -->
<div class="space-y-6">
    <div class="overflow-hidden">
        <h2 class="text-2xl font-bold flex items-center gap-2 pb-4">
            Buyer Information
        </h2>

        <div class="space-y-4">
            <!-- Buyer Profile Card -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-5 rounded-xl border-2 border-blue-200 shadow-md">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                        {{ strtoupper(substr($adoption->buyer_name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="text-xl font-bold text-stone-900 mb-1">{{ $adoption->buyer_name }}
                        </div>
                        <div class="text-sm text-blue-600 font-semibold">Buyer</div>
                    </div>
                </div>

                <div class="space-y-2">
                    <div
                        class="flex items-center gap-3 p-3 bg-white rounded-lg hover:bg-blue-50 transition-colors duration-200">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <a href="mailto:{{ $adoption->buyer_email }}"
                            class="text-sm text-blue-600 hover:underline font-medium break-all">{{ $adoption->buyer_email }}</a>
                    </div>

                    @if ($adoption->buyer_phone)
                        <div
                            class="flex items-center gap-3 p-3 bg-white rounded-lg hover:bg-blue-50 transition-colors duration-200">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <span class="text-sm text-gray-800 font-medium">{{ $adoption->buyer_phone }}</span>
                        </div>
                    @endif

                    <div
                        class="flex items-center gap-3 p-3 bg-white rounded-lg hover:bg-blue-50 transition-colors duration-200">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="text-sm text-gray-800 font-medium">
                            {{ $adoption->created_at->format('F j, Y \a\t g:i A') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Buyer Message -->
            @if ($adoption->buyer_message)
                <div
                    class="bg-gradient-to-br from-amber-50 to-orange-50 p-5 rounded-xl border-2 border-amber-200 shadow-md">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                            </path>
                        </svg>
                        <label class="text-xs font-bold text-amber-700 uppercase tracking-wide">Buyer's
                            Message</label>
                    </div>
                    <div class="text-sm text-amber-900 leading-relaxed bg-white p-4 rounded-lg italic">
                        "{{ $adoption->buyer_message }}"
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
