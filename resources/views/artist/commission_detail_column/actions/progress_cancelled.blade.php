<!-- Cancelled Commission Info -->
<div class="bg-gradient-to-br from-red-50 to-rose-100 border-2 border-red-300 rounded-xl p-6 shadow-md">
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0">
            <div class="w-14 h-14 bg-red-500 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
        </div>
        <div class="flex-1">
            <h4 class="text-lg font-bold text-red-900 mb-2">
                Commission {{ $commission->progress_status === 'declined' ? 'Declined' : 'Cancelled' }}
            </h4>
            <p class="text-red-800 text-sm leading-relaxed mb-4">
                @if ($commission->progress_status === 'declined')
                    This commission has been declined and will not be worked on.
                @else
                    This commission has been cancelled and no further work is required.
                @endif
            </p>
        </div>
    </div>
    <div>
        <!-- Cancellation Details -->
        <div class="bg-white rounded-lg p-4 border border-red-200 mb-4">
            <div class="grid grid-cols-1 gap-3">
                @if ($commission->progress_status !== 'declined')
                    <div>
                        <label class="text-xs font-semibold text-red-900 uppercase tracking-wide">
                            {{ $commission->progress_status === 'declined' ? 'Declined By' : 'Cancelled By' }}
                        </label>
                        <p class="text-sm text-gray-700 mt-1">
                            {{ $commission->cancelled_by === 'artist' ? 'You (Artist)' : 'Customer' }}
                        </p>
                    </div>
                @endif
                @if ($commission->cancelled_at)
                    <div>
                        <label class="text-xs font-semibold text-red-900 uppercase tracking-wide">
                            {{ $commission->progress_status === 'declined' ? 'Declined On' : 'Cancelled On' }}
                        </label>
                        <p class="text-sm text-gray-700 mt-1">
                            {{ \Carbon\Carbon::parse($commission->cancelled_at)->format('M d, Y - h:i A') }}
                        </p>
                    </div>
                @endif
                @if ($commission->cancellation_reason)
                    <div>
                        <label class="text-xs font-semibold text-red-900 uppercase tracking-wide">Reason</label>
                        <p class="text-sm text-gray-700 mt-1 bg-red-50 p-3 rounded border border-red-100">
                            {{ $commission->cancellation_reason }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Refund Reminder -->
        @if (in_array($commission->payment_status, ['dp', 'paid']))
            <div class="bg-amber-50 border-2 border-amber-400 rounded-lg p-4 mb-4">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    <div class="flex-1">
                        <h5 class="font-bold text-amber-900 mb-1">⚠️ Refund Reminder</h5>
                        <p class="text-sm text-amber-800 leading-relaxed">
                            The customer has already made a
                            <span class="font-semibold">
                                {{ $commission->payment_status === 'paid' ? 'full payment' : 'down payment' }}
                            </span>.
                            Please remember to process the refund and update the payment status to
                            <span class="font-semibold">"Refunded"</span> once completed.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Payment Status Update -->
            @include('artist.commission_detail_column.actions.payment_status_update', [
                'commission' => $commission,
            ])
        @elseif($commission->payment_status === 'refunded')
            <div class="w-full bg-green-50 border-2 border-green-400 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <h5 class="font-bold text-green-900 mb-1">✓ Refund Completed</h5>
                        <p class="text-sm text-green-800">
                            The refund has been processed. This commission is fully closed.
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-gray-50 border border-gray-300 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-gray-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <h5 class="font-bold text-gray-900 mb-1">No Payment Received</h5>
                        <p class="text-sm text-gray-700">
                            This commission was cancelled before any payment was made. No refund is necessary.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
