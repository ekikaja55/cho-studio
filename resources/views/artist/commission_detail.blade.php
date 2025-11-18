@extends('artist.artist_template')

@section('content')
    <style>
        .custom-swal-popup {
            font-family: 'HammersmithOne-Regular', sans-serif;
        }

        .custom-swal-title {
            font-size: 24px;
            font-weight: bold;
            font-family: 'HammersmithOne-Regular', sans-serif;
        }

        .custom-swal-text {
            font-size: 16px;
            font-family: 'HammersmithOne-Regular', sans-serif;
        }

        .custom-swal-success-button {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'HammersmithOne-Regular', sans-serif;
        }

        .custom-swal-danger-button {
            background-color: #d33;
            color: white;
            font-size: 16px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'HammersmithOne-Regular', sans-serif;
        }

        .custom-swal-cancel-button {
            background-color: #6c757d;
            color: white;
            font-size: 16px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'HammersmithOne-Regular', sans-serif;
        }
    </style>

    <div class="my-8 max-xl:mt-3 p-4 xl:w-[90%] mx-auto lg:w-full">
        <div class="shadow-2xl font-[HammersmithOne-Regular] overflow-hidden">
            <!-- Header Section -->
            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between items-center gap-3 p-6 border-t-4 border-x-4 border-stone-900 bg-(--color-pastel-turqoise)">
                <a href="{{ route('artist.commissions') }}"
                    class="group px-5 py-2.5 rounded-xl border-2 border-stone-600 bg-white text-stone-800 font-bold shadow-lg hover:shadow-xl hover:scale-105 hover:bg-stone-50 transition-all duration-300 text-center flex items-center gap-2">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Commissions
                </a>
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-bold text-stone-900 drop-shadow-sm">Commission Details</div>
                    <div class="text-sm text-stone-700 mt-1">Order #{{ $commission->commission_id }}</div>
                </div>
                <div class="flex flex-wrap gap-2 items-center justify-center sm:justify-end">
                    <span
                        class="inline-block px-4 py-2 rounded-full text-sm font-bold shadow-md {{ $commission->progress_status_color }} text-white">
                        {{ $commission->progress_status_text }}
                    </span>
                    <span
                        class="inline-block px-4 py-2 rounded-full text-sm font-bold shadow-md {{ $commission->payment_status_color }} text-white">
                        {{ $commission->payment_status_text }}
                    </span>
                </div>
            </div>

            <div class="bg-(--color-background) p-6 min-h-fit border-4 border-stone-900">
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

                    <!-- Left Column: Commission Details (40%) -->
                    @include('artist.commission_detail_column.commission_info', [
                        'commission' => $commission,
                    ])

                    <!-- Middle Column: Client Information (30%) -->
                    @include('artist.commission_detail_column.client_info', [
                        'commission' => $commission,
                    ])

                    <!-- Right Column: Actions (30%) -->
                    <div class="xl:col-span-4 space-y-6">
                        <div class="overflow-hidden">
                            <h2 class="text-2xl font-bold flex items-center gap-2 pb-4">
                                Actions
                            </h2>

                            <div class="flex flex-col gap-4">
                                @if ($commission->progress_status === 'pending')
                                    @include('artist.commission_detail_column.actions.pending_actions', [
                                        'commission' => $commission,
                                    ])
                                @elseif($commission->progress_status === 'accepted')
                                    @include(
                                        'artist.commission_detail_column.actions.progress_status_update',
                                        [
                                            'commission' => $commission,
                                        ]
                                    )
                                    @include(
                                        'artist.commission_detail_column.actions.payment_status_update',
                                        [
                                            'commission' => $commission,
                                        ]
                                    )
                                @elseif($commission->progress_status === 'in_progress_sketch' || $commission->progress_status === 'in_progress_coloring')
                                    @include(
                                        'artist.commission_detail_column.actions.progress_status_update',
                                        [
                                            'commission' => $commission,
                                        ]
                                    )
                                    @include(
                                        'artist.commission_detail_column.actions.payment_status_update',
                                        [
                                            'commission' => $commission,
                                        ]
                                    )
                                    @include('artist.commission_detail_column.actions.file_upload', [
                                        'commission' => $commission,
                                    ])
                                @elseif($commission->progress_status === 'review')
                                    <div
                                        class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-300 rounded-xl p-6 shadow-md">
                                        <div class="flex items-start gap-4">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-14 h-14 bg-blue-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="text-lg font-bold text-blue-900 mb-2">Under Review</h4>
                                                <p class="text-sm text-blue-800 leading-relaxed">The customer is
                                                    currently reviewing your artwork. Please wait for their feedback or
                                                    follow up if needed.</p>
                                            </div>
                                        </div>
                                    </div>
                                    @include(
                                        'artist.commission_detail_column.actions.payment_status_update',
                                        [
                                            'commission' => $commission,
                                        ]
                                    )
                                @elseif($commission->progress_status === 'revision')
                                    @include('artist.commission_detail_column.actions.revision_upload', [
                                        'commission' => $commission,
                                    ])
                                    @include(
                                        'artist.commission_detail_column.actions.payment_status_update',
                                        [
                                            'commission' => $commission,
                                        ]
                                    )
                                @elseif($commission->progress_status === 'completed')
                                    @include('artist.commission_detail_column.actions.progress_complete', [
                                        'commission' => $commission,
                                    ])
                                @elseif($commission->progress_status === 'cancelled' || $commission->progress_status === 'declined')
                                    @include(
                                        'artist.commission_detail_column.actions.progress_cancelled',
                                        [
                                            'commission' => $commission,
                                        ]
                                    )
                                @endif

                                @if (
                                    $commission->progress_status !== 'completed' &&
                                        $commission->progress_status !== 'cancelled' &&
                                        $commission->progress_status !== 'declined' &&
                                        $commission->progress_status !== 'pending')
                                    @include('artist.commission_detail_column.actions.cancel_button', [
                                        'commission' => $commission,
                                    ])
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="ref-image-modal" class="fixed inset-0 z-50 flex items-center justify-center font-[HammersmithOne-Regular]"
        style="background-color: rgba(30,41,59,0.55); display: none;">
    <div class="modal-content bg-white rounded-xl shadow-2xl p-8 max-w-1/2 w-full relative">
            <button id="close-ref-image-modal"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
            <h3 class="text-xl font-bold mb-4 text-blue-700">Reference Image</h3>
            @php
                $isNetworkImage = filter_var($commission->reference_image, FILTER_VALIDATE_URL);
            @endphp
            @if($isNetworkImage)
                <img src="{{ $commission->reference_image }}" alt="Reference Image (Network)"
                    class="w-full rounded-lg mx-auto border border-green-300 shadow">
                <div class="text-xs text-green-700 text-center mt-2">Source: Network Link</div>
            @else
                <img src="{{ asset($commission->reference_image) }}" alt="Reference Image (Uploaded)"
                    class="w-full rounded-lg mx-auto border border-blue-200 shadow">
                <div class="text-xs text-blue-700 text-center mt-2">Source: Uploaded File</div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    @vite(['resources/js/artist/commissions_detail.js'])
@endsection
