@extends('artist.artist_template')

@section('content')
    <div class="my-6 max-xl:mt-3 p-4 xl:w-[80%] mx-auto lg:w-full">
        <div class="shadow font-[HammersmithOne-Regular] overflow-x-auto">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 p-4 border-2 border-stone-900"
                style="background-color: var(--color-pastel-gray-turquoise);">
                <div class="text-2xl sm:text-4xl">Adoptions</div>
                <div class="flex flex-wrap gap-2 sm:gap-4 items-center">
                    <div id="status-pending"
                        class="text-lg max-lg:text-base max-sm:text-sm rounded-full px-3 sm:px-4 py-1 sm:py-2 border-2 border bg-red-500">
                        0 Pending</div>
                        <div id="status-confirmed"
                        class="text-lg max-lg:text-base max-sm:text-sm rounded-full px-3 sm:px-4 py-1 sm:py-2 border-2 border bg-blue-500">
                        0 Confirmed</div>
                    <div id="status-processing"
                        class="text-lg max-lg:text-base max-sm:text-sm rounded-full px-3 sm:px-4 py-1 sm:py-2 border-2 border bg-amber-500">
                        0 Processing</div>
                    <div id="status-delivered"
                        class="text-lg max-lg:text-base max-sm:text-sm rounded-full px-3 sm:px-4 py-1 sm:py-2 border-2 border bg-purple-400">
                        0 Delivered</div>
                </div>
            </div>

            <!-- Filters and Search Section -->
            <div class="p-4 border-2 border-t-0 border-stone-900 bg-[var(--color-background)]">
                <div class="flex flex-col gap-3">
                    <!-- Search -->
                    <div class="w-full">
                        <input type="text" id="search-input" placeholder="Search by buyer, email, artwork title..."
                            class="w-full px-4 py-3 border-2 border-stone-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-stone-600 bg-white">
                    </div>

                    <!-- Filters Row -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label for="status-filter" class="sr-only">Order Status</label>
                            <select id="status-filter"
                                class="w-full px-3 py-3 border-2 border-stone-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-stone-600 bg-white">
                                <option value="">All Order Status</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="processing">Processing</option>
                                <option value="delivered">Delivered</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div>
                            <label for="payment-filter" class="sr-only">Payment Status</label>
                            <select id="payment-filter"
                                class="w-full px-3 py-3 border-2 border-stone-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-stone-600 bg-white">
                                <option value="">All Payment Status</option>
                                <option value="unpaid">Unpaid</option>
                                <option value="paid">Paid</option>
                                <option value="refunded">Refunded</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>

                        <div>
                            <label for="sort-order" class="sr-only">Sort Order</label>
                            <select id="sort-order"
                                class="w-full px-3 py-3 border-2 border-stone-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-stone-600 bg-white">
                                <option value="desc">Order Date: Newest First</option>
                                <option value="asc">Order Date: Oldest First</option>
                            </select>
                        </div>
                    </div>

                    <!-- Controls Row -->
                    <div class="flex flex-col sm:flex-row gap-3 sm:justify-between sm:items-center">
                        <select id="per-page"
                            class="w-full sm:w-auto px-3 py-3 border-2 border-stone-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-stone-600 bg-white">
                            <option value="10">10 / page</option>
                            <option value="25">25 / page</option>
                            <option value="50">50 / page</option>
                        </select>

                        <button id="clear-filters"
                            class="w-full sm:w-auto px-4 py-3 bg-stone-900 text-white rounded-lg hover:bg-stone-700 transition-colors">
                            Clear Filters
                        </button>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto border-2 border-t-0 border-stone-900">
                <div class="max-h-[55vh] max-xl:h-[60vh] bg-[var(--color-background)] overflow-y-auto">
                    <table class="w-full border-collapse border-spacing-0"
                        style="border-collapse: separate; border-spacing: 0;">
                        <thead class="sticky top-0 bg-stone-900 text-white" style="z-index: 10;">
                            <tr class="text-left bg-stone-900">
                                <th
                                    class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 bg-stone-900">
                                    Buyer</th>
                                <th
                                    class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 bg-stone-900">
                                    Art Title</th>
                                <th
                                    class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 bg-stone-900 hidden sm:table-cell">
                                    Art Description</th>
                                <th
                                    class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 bg-stone-900 hidden sm:table-cell">
                                    Order Date</th>
                                <th
                                    class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 bg-stone-900 text-center">
                                    Status</th>
                                <th
                                    class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 bg-stone-900 text-center">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody id="adoptions-tbody" class="h-full">
                            <!-- Data will be loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div id="adoptionsPager"
                class="bg-[var(--color-background)] w-full flex flex-col sm:flex-row items-center justify-between gap-2 p-4 mt-2 border-2 border-stone-900">
                <div class="text-sm text-stone-900">Showing <span id="pagerRange">0</span> of <span id="pagerTotal">0</span>
                </div>
                <nav class="flex items-center gap-2" aria-label="Pagination">
                    <button id="pagerPrev"
                        class="px-3 py-1 rounded bg-white border-2 border-stone-900 text-sm disabled:opacity-50"
                        disabled>Previous</button>
                    <div id="pagerNumbers" class="flex items-center gap-1"></div>
                    <button id="pagerNext"
                        class="px-3 py-1 rounded bg-white border-2 border-stone-900 text-sm disabled:opacity-50"
                        disabled>Next</button>
                </nav>
            </div>
        </div>
    @endsection

    @section('scripts')
        @vite(['resources/js/artist/adoptions.js'])
    @endsection
