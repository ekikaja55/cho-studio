<div class="bg-gradient-to-br from-green-50 to-emerald-100 border-2 border-green-300 rounded-xl p-8 shadow-lg">
    <div class="text-center space-y-4">
        <div class="flex justify-center">
            <div
                class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center shadow-xl">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div>
            <h4 class="text-2xl font-bold text-green-900 mb-2">Commission Completed!
            </h4>
        </div>
        <div class="mt-4">
            <div class="flex items-center justify-center gap-2 text-sm text-green-700 mb-3 bg-white px-3 py-2 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                <span class="font-semibold">Completed on:
                    {{ $commission->completed_at->format('F j, Y \a\t g:i A') }}</span>
            </div>
            @if ($commission->fully_paid_at)
                <div class="flex items-center justify-center gap-2 text-sm text-green-700 bg-white px-3 py-2 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="font-semibold">Full Payment on:
                        {{ $commission->updated_at->format('F j, Y \a\t g:i A') }}</span>
                </div>
            @else
                <div
                    class="flex items-center justify-center gap-2 text-sm text-red-600 mt-2 bg-white px-3 py-2 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="font-semibold text-red-600">Full payment not yet received.</span>
                </div>
            @endif
        </div>
    </div>
</div>

@if (!$commission->fully_paid_at)
    @include('artist.commission_detail_column.actions.payment_status_update', [
        'commission' => $commission,
    ])
@endif
