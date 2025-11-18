@extends('member.member_template')

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

    {{-- Main Container: Centered and full-height adaptive --}}
    <div class="flex justify-center items-start font-[HammersmithOne-Regular] overflow-auto py-12 px-6 sm:px-10 lg:px-20"
        style="min-height: calc(100vh - 80px)">

        {{-- Detail Card Container --}}
        <div
            class="w-full bg-[var(--color-background)] shadow-2xl border-3 border-stone-900 rounded-2xl p-6 lg:p-10 relative">

            {{-- Main Content Card (Commission Details) --}}
            <div class="w-full rounded-xl p-4 sm:p-6 md:p-8 border-4 border-purple-500 bg-purple-200 shadow-inner">

                {{-- Header/Back Button and Title --}}
                <div class="relative mb-8 text-center border-b border-purple-400 pb-4">
                    <a href="{{ route('member.history') }}"
                        class="md:absolute md:top-1/2 md:-translate-y-1/2 md:left-0 inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-cyan-700 bg-cyan-100 rounded-full shadow-md hover:bg-cyan-200 transition-all duration-200">
                        <i class="fa-solid fa-arrow-left"></i>
                        Back to History
                    </a>
                    <h1 class="text-3xl font-extrabold text-gray-800 tracking-wide">Commission Details</h1>
                    <p class="text-lg text-gray-600 mt-1">{{ $commission->category_text }} -
                        {{ $commission->background_type_text }} Background</p>
                </div>

                <div class="flex flex-col lg:flex-row justify-between gap-8">

                    {{-- Left Column: Progress Images & Status (1/3 width) --}}
                    <div class="w-full lg:w-1/3 flex flex-col items-center space-y-6">

                        {{-- Progress Image Viewer --}}
                        <div class="w-full">
                            <h2
                                class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-paintbrush text-purple-600"></i> Progress Images
                            </h2>

                            @if ($commission->progressImages && $commission->progressImages->count() > 0)
                                <select id="progress-image-selector"
                                    class="w-full px-4 py-3 border-2 border-purple-300 rounded-xl bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-100 focus:outline-none font-semibold text-gray-700 shadow-sm transition-all duration-200 mb-4">
                                    @foreach ($commission->progressImages as $index => $progress)
                                        {{-- NOTE: Assuming stage_label is a property or accessor on CommissionProgress --}}
                                        <option value="{{ $index }}" {{ $index === 0 ? 'selected' : '' }}>
                                            {{ $progress->stage_label ?? $progress->stage }} -
                                            {{ $progress->created_at->format('M d, Y') }}
                                            @if ($progress->revision_notes)
                                                - Revision ({{ Str::limit($progress->revision_notes, 20) }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>

                                <div
                                    class="bg-linear-to-br from-gray-100 to-gray-200 rounded-xl p-3 border-2 border-gray-300 shadow-xl">
                                    @foreach ($commission->progressImages as $index => $progress)
                                        <div class="progress-image-container {{ $index === 0 ? '' : 'hidden' }}"
                                            data-image-index="{{ $index }}">
                                            <div class="bg-white rounded-lg shadow-inner">
                                                <img src="{{ asset($progress->image_link) }}"
                                                    alt="{{ $progress->stage_label ?? 'Progress' }}"
                                                    class="max-w-full max-h-80 object-contain rounded-lg mx-auto"
                                                    style="max-height: 300px; width: 100%;"
                                                    onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMDAgMTAwVjIwME0xNTAgMTUwSDI1MCIgc3Ryb2tlPSIjOUNBM0FGIiBzdHJva2Utd2lkdGg9IjIiLz4KPC9zdmc+'" />
                                            </div>

                                            @if ($progress->revision_notes)
                                                <div
                                                    class="mt-4 bg-blue-100 p-3 rounded-lg border border-blue-300 shadow-sm">
                                                    <p class="text-xs font-bold text-blue-700 uppercase tracking-wide mb-1">
                                                        Revision Note:</p>
                                                    <p class="text-sm text-gray-800 leading-snug">
                                                        {{ $progress->revision_notes }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div
                                    class="bg-linear-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-300 rounded-xl p-8 text-center shadow-md">
                                    <i class="fa-solid fa-camera fa-2xl text-yellow-500 mb-4"></i>
                                    <p class="text-lg font-bold text-yellow-900 mb-2">No Images Yet</p>
                                    <p class="text-sm text-yellow-700">Progress images will appear once the artist starts
                                        the work.</p>
                                </div>
                            @endif
                        </div>

                        {{-- Status Box --}}
                        <div class="w-full p-4 bg-white rounded-xl shadow-lg border-2 border-purple-300 text-gray-800">
                            <h3 class="text-lg font-extrabold text-center mb-3 border-b border-purple-100 pb-2">Order Status
                            </h3>

                            {{-- Payment Status --}}
                            <div class="flex justify-between items-center py-2">
                                <span class="font-bold">Payment:</span>
                                <div
                                    class="px-3 py-1 rounded-full text-white {{ $commission->payment_status_color }} text-sm font-medium shadow-md">
                                    {{ $commission->payment_status_text }}
                                </div>
                            </div>

                            {{-- Progress Status --}}
                            <div class="flex justify-between items-center py-2 border-t border-purple-100 mt-1">
                                <span class="font-bold">Progress:</span>
                                <div
                                    class="px-3 py-1 rounded-full text-white {{ $commission->progress_status_color }} text-sm font-medium shadow-md">
                                    {{ $commission->progress_status_text }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Details, Timeline, and Review/Action (2/3 width) --}}
                    <div class="w-full lg:w-2/3 flex flex-col space-y-6 text-gray-700">

                        {{-- Core Details Grid --}}
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="p-4 rounded-xl border-2 border-purple-300 bg-purple-100 shadow-inner">
                                <label class="block text-xs font-bold text-purple-700 mb-1 uppercase">Category</label>
                                <div class="text-lg font-bold text-purple-900">{{ $commission->category_text }}</div>
                            </div>
                            <div class="p-4 rounded-xl border-2 border-pink-300 bg-pink-100 shadow-inner">
                                <label class="block text-xs font-bold text-pink-700 mb-1 uppercase">Background
                                    Type</label>
                                <div class="text-lg font-bold text-pink-900">{{ $commission->background_type_text }}
                                </div>
                            </div>
                            <div class="p-4 rounded-xl col-span-2 border-2 border-green-300 bg-green-100 shadow-inner">
                                <label class="block text-xs font-bold text-green-700 mb-1 uppercase">Price</label>
                                <div class="text-lg font-bold text-green-700">
                                    Rp {{ number_format($commission->price, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="p-4 rounded-xl border-2 border-orange-300 bg-orange-100 shadow-inner">
                                <label class="block text-xs font-bold text-orange-700 mb-1 uppercase">Deadline</label>
                                <div class="text-sm font-bold text-orange-900">
                                    {{ date('F j, Y', strtotime($commission->deadline)) }}
                                </div>
                                @php
                                    $daysLeft = ceil((strtotime($commission->deadline) - time()) / (60 * 60 * 24));
                                @endphp
                                @if ($daysLeft > 0)
                                    <div class="text-xs font-semibold text-blue-600 mt-1">{{ $daysLeft }} days left
                                    </div>
                                @elseif($daysLeft == 0)
                                    <div class="text-xs font-semibold text-orange-600 mt-1">Due today</div>
                                @else
                                    <div class="text-xs font-semibold text-red-600 mt-1>{{ abs($daysLeft) }} days overdue
                                    </div>
@endif
                            </div>
                            <div class="p-4
                                        rounded-xl border-2 border-blue-300 bg-blue-100 shadow-inner">
                                        <label class="block text-xs font-bold text-blue-700 mb-1 uppercase">Order
                                            Date</label>
                                        <div class="text-sm font-bold text-blue-900">
                                            {{ date('M j, Y \a\t g:i A', strtotime($commission->created_at)) }}
                                        </div>
                                    </div>
                            </div>

                            {{-- Description --}}
                            <div
                                class="bg-white p-4 rounded-xl leading-relaxed border border-red-300 shadow-md min-h-[100px] text-sm">
                                <p class="font-bold text-lg mb-2 border-b border-red-200 pb-1">Commission Description:</p>
                                <p>{{ $commission->description }}</p>
                            </div>

                            {{-- Client Action Area (Accept/Revision) --}}
                            @if ($commission->progress_status === 'review')
                                <div class="p-4 rounded-xl border-2 border-cyan-500 bg-cyan-50 shadow-2xl">
                                    <h3 class="text-xl font-extrabold text-cyan-700 mb-2 border-b border-cyan-200 pb-1">
                                        Review Artist Work
                                    </h3>
                                    <p class="text-gray-700 text-sm mb-3">The artist has submitted a progress update. Please
                                        choose
                                        to <strong>Accept</strong> the current work or request a <strong>Revision</strong>.
                                    </p>

                                    {{-- Action Buttons (Simplified for illustration, requires form/JS submission) --}}
                                    <div class="flex flex-col sm:flex-row gap-4">
                                        {{-- ACCEPT Button --}}
                                        <button type="button" id="accept-work-btn"
                                            data-commission-id="{{ $commission->commission_id }}"
                                            class="flex-1 px-6 py-2 rounded-full bg-green-500 text-white font-bold shadow-lg hover:bg-green-600 transition-all duration-200">
                                            <i class="fa-solid fa-check-circle mr-2"></i> Accept Work
                                        </button>

                                        {{-- REVISION Button (Toggles form) --}}
                                        <button type="button" id="revision-toggle-btn"
                                            data-commission-id="{{ $commission->commission_id }}"
                                            class="flex-1 px-6 py-2 rounded-full bg-orange-500 text-white font-bold shadow-lg hover:bg-orange-600 transition-all duration-200">
                                            <i class="fa-solid fa-pencil-ruler mr-2"></i> Request Revision
                                        </button>
                                    </div>

                                    {{-- Revision Form Area (Hidden by default) --}}
                                    <div id="revision-form-area"
                                        class="hidden mt-4 pt-4 border-t border-cyan-300 space-y-3">
                                        <h4 class="text-lg font-bold text-orange-700">Revision Details</h4>
                                        <textarea name="revision_notes" rows="4" id="revision-notes-textarea"
                                            placeholder="Please clearly explain the specific changes needed (e.g., 'Change the hair color to a darker shade of blue', 'Adjust the pose of the left character')."
                                            class="w-full p-4 border-2 border-orange-300 rounded-lg focus:border-orange-500 focus:ring-3 focus:ring-orange-500 transition-all duration-200 text-sm shadow-inner"></textarea>

                                        <button type="submit" id="submit-revision-btn"
                                            data-commission-id="{{ $commission->commission_id }}"
                                            class="w-full mt-3 px-6 py-3 rounded-lg bg-orange-600 text-white font-extrabold shadow-md hover:bg-orange-700 transition-all duration-200">
                                            Submit Revision Request
                                        </button>
                                    </div>
                                </div>
                            @endif

                            {{-- Timeline --}}
                            <div class="p-4 bg-gray-100 rounded-xl border-2 border-gray-300 shadow-sm">
                                <p class="font-bold text-lg mb-2 border-b border-gray-300 pb-2 flex items-center gap-2">
                                    Commission Timeline
                                </p>
                                <div class="grid grid-cols-2 gap-4 text-sm mt-2">
                                    <p><strong><i class="fa-solid fa-calendar-check mr-2"></i>Started At:</strong>
                                        {{ optional($commission->started_at)->format('M j, Y') ?? 'N/A' }}</p>
                                    <p><strong><i class="fa-solid fa-sack-dollar mr-2"></i>Fully Paid At:</strong>
                                        {{ optional($commission->fully_paid_at)->format('M j, Y') ?? 'N/A' }}</p>
                                    <p><strong><i class="fa-solid fa-medal mr-2"></i>Completed At:</strong>
                                        {{ optional($commission->completed_at)->format('M j, Y') ?? 'N/A' }}</p>
                                    @if ($commission->cancellation_reason)
                                        <p class="col-span-2 text-red-600"><strong><i
                                                    class="fa-solid fa-ban mr-2"></i>Cancelled
                                                At:</strong>
                                            {{ optional($commission->cancelled_at)->format('M j, Y') ?? 'N/A' }} (Reason:
                                            {{ $commission->cancellation_reason }})</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        @vite(['resources/js/member/history_commission_detail.js'])
    @endsection
