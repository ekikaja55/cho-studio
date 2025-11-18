@extends('member.member_template')

@section('content')
    <div class="flex justify-center items-center font-[HammersmithOne-Regular] overflow-auto px-30 py-20 max-md:p-10 max-sm:p-5"
        style="height: calc(100vh - 80px)">

        {{-- The main wrapper now holds the data attributes for JavaScript --}}
        <div
            class="w-full h-full bg-[var(--color-background)] shadow-2xl border-3 border-stone-900 rounded-2xl p-6 relative overflow-hidden flex flex-col">

            {{-- header --}}
            <div class="flex flex-col gap-6 mb-4 md:flex-row md:items-center md:justify-between relative z-10 flex-none">
                <h1 class="text-4xl font-bold text-stone-900 flex items-center">History</h1>
                <div
                    class="flex flex-col gap-5 md:flex-row md:items-center bg-white/80 backdrop-blur-sm rounded-xl p-4 shadow-lg border border-stone-200">

                    {{-- (Search removed) --}}

                    {{-- Main Filter (Type) --}}
                    <div class="flex gap-2">
                        <label for="filterSelect" class="text-stone-900 font-semibold flex items-center"><i
                                class="fa-solid fa-filter mr-2 text-stone-600"></i>Filter By</label>
                        <select name="filter" id="filterSelect"
                            class="w-full md:w-auto px-3 py-3 border-2 border-stone-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-stone-300 focus:border-stone-300 bg-white transition-all duration-300 hover:shadow-md">
                            <option value="all" selected>All</option>
                            <option value="commission">Commission</option>
                            <option value="adoption">Adoption</option>
                        </select>
                    </div>


                    {{-- Commission Status Filter (Hidden by default) --}}
                    <div id="commissionStatusContainer" class="hidden flex gap-2">
                        <label for="commissionStatusFilter"
                            class="text-stone-900 font-semibold flex items-center">Commission Status</label>
                        <select name="commissionStatus" id="commissionStatusFilter"
                            class="w-full md:w-auto px-3 py-3 border-2 border-stone-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-stone-300 focus:border-stone-300 bg-white transition-all duration-300 hover:shadow-md">
                            <option value="all" selected>All</option>
                            <option value="pending">Pending</option>
                            <option value="accepted">Accepted</option>
                            <option value="declined">Declined</option>
                            <option value="in_progress">In Progress</option>
                            <option value="review">In Review</option>
                            <option value="revision">In Revision</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    {{-- Adoption Status Filter (Hidden by default) --}}
                    <div id="adoptionStatusContainer" class="hidden flex gap-2">
                        <label for="adoptionStatusFilter" class="text-stone-900 font-semibold flex items-center">Adoption
                            Status</label>
                        <select name="adoptionStatus" id="adoptionStatusFilter"
                            class="w-full md:w-auto px-3 py-3 border-2 border-stone-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-stone-300 focus:border-stone-300 bg-white transition-all duration-300 hover:shadow-md">
                            <option value="all" selected>All</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="processing">Processing</option>
                            <option value="delivered">Delivered</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- History Container and Loading/Error Messages --}}
            <div id="historyContainer"
                class="border-2 border-stone-300 bg-white/50 backdrop-blur-sm rounded-xl shadow-inner flex-1 min-h-0 overflow-y-auto p-2">

            </div>
        </div>
    </div>
@endsection


@section('scripts')
    @vite(['resources/js/member/history.js'])
@endsection
