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
    </style>

    <div class="flex justify-center min-h-screen py-8 px-4 font-[HammersmithOne-Regular]">
        <div class="flex justify-center bg-[#f0ebe3] border-4 border-black w-[95%] xl:w-[85%] rounded-2xl shadow-md">
            <div class="flex flex-col w-full p-6 md:p-10 gap-8">
                <form method="post" enctype="multipart/form-data" id="commissionForm">
                    @csrf
                    @php
                        $imgPath = match ($category ?? '') {
                            'headshot' => asset('assets/comm_sample/HeadShot_Sample.png'),
                            'halfbody' => asset('assets/comm_sample/HalfBody_Sample.png'),
                            'fullbody' => asset('assets/comm_sample/FullBody_Sample.png'),
                            'bustup' => asset('assets/comm_sample/Custom_Sample.jpg'),
                            default => asset('assets/comm_sample/Custom_Sample.jpg'),
                        };
                        $text = match ($category ?? '') {
                            'headshot' => 'Head Shot',
                            'halfbody' => 'Half Body',
                            'fullbody' => 'Full Body',
                            'bustup' => 'Bust Up',
                            default => 'No selection',
                        };
                    @endphp

                    <input type="hidden" name="category_temp" id="category-temp" value="{{ $category ?? '' }}">
                    <input type="hidden" name="category" id="category-value" value="{{ $category ?? '' }}">

                    <div class="flex flex-col lg:flex-row gap-8 mb-8">
                        <!-- Sample Image Section -->
                        <div
                            class="lg:w-[40%] flex flex-col justify-start items-center bg-white rounded-2xl border-4 border-black p-6 shadow-lg h-fit">
                            <h3 class="mb-6 text-2xl font-bold text-center">{{ $text }} Example</h3>
                            <div class="w-full bg-gray-100 rounded-xl border-2 border-black overflow-hidden">
                                <img src="{{ $imgPath }}" alt="{{ $category ?? 'Sample' }}"
                                    class="object-contain w-full h-auto" />
                            </div>
                        </div>

                        <!-- Form Section -->
                        <div class="lg:w-[60%] flex flex-col bg-white rounded-2xl border-4 border-black p-8 shadow-lg">
                            <h3 class="text-2xl mb-4 font-bold text-center">Commission Options
                            </h3>

                            <!-- Style Selection -->
                            <div class="mb-3 p-4 bg-gray-50 rounded-lg border-2 border-gray-200">
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                                    <label class="font-semibold">Style:</label>
                                    @if ($category === 'headshot')
                                        <input type="hidden" name="style" value="headshot">
                                        <span
                                            class="px-4 py-2 bg-blue-100 border-2 border-blue-500 rounded-lg text-blue-700 font-semibold">Normal</span>
                                    @else
                                        <div class="flex gap-6">
                                            <label
                                                class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 px-3 py-2 rounded-lg transition">
                                                <input type="radio" name="style" value="normal" id="styleNormal"
                                                    class="w-4 h-4" checked>
                                                <span class="text-base">Normal</span>
                                            </label>
                                            <label
                                                class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 px-3 py-2 rounded-lg transition">
                                                <input type="radio" name="style" value="cartoon" id="styleCartoon"
                                                    class="w-4 h-4">
                                                <span class="text-base">Cartoon</span>
                                            </label>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Background Selection -->
                            <div class="mb-3 p-4 bg-gray-50 rounded-lg border-2 border-gray-200">
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                                    <label class="font-semibold">Background:</label>
                                    <div class="flex flex-wrap gap-4">
                                        <label
                                            class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 px-3 py-2 rounded-lg transition">
                                            <input type="radio" name="background" value="none" id="bgNone"
                                                class="w-4 h-4" checked>
                                            <span class="text-base">None</span>
                                        </label>
                                        <label
                                            class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 px-3 py-2 rounded-lg transition">
                                            <input type="radio" name="background" value="simple" id="bgSimple"
                                                class="w-4 h-4">
                                            <span class="text-base">Simple</span>
                                        </label>
                                        <label
                                            class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 px-3 py-2 rounded-lg transition">
                                            <input type="radio" name="background" value="detailed" id="bgDetailed"
                                                class="w-4 h-4">
                                            <span class="text-base">Detailed</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Commercial Use -->
                            <div class="mb-3 p-4 bg-gray-50 rounded-lg border-2 border-gray-200">
                                <label class="flex justify-between items-center cursor-pointer group">
                                    <span class=" font-semibold group-hover:text-blue-600 transition">Commercial Use:
                                        <span class="text-sm font-normal text-gray-600">(+150%)</span></span>
                                    <input type="checkbox" id="commercialUse" name="commercial_use" value="1"
                                        class="w-5 h-5 cursor-pointer">
                                </label>
                            </div>

                            <!-- Additional Characters -->
                            <div class="mb-3 p-4 bg-gray-50 rounded-lg border-2 border-gray-200">
                                <label class="flex justify-between items-center">
                                    <span class=" font-semibold">Additional Characters: <span
                                            class="text-sm font-normal text-gray-600">(+75% each)</span></span>
                                    <input type="number" id="additionalChars" name="additional_characters" value="0"
                                        min="0" max="10"
                                        class="w-20 px-3 py-2 text-center border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none">
                                </label>
                            </div>

                            <!-- Price Breakdown -->
                            <div
                                class="mt-3 p-6 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border-3 border-black shadow-inner">
                                <h3 class="text-xl font-bold mb-4 text-center">Price Breakdown</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2 border-b border-gray-300">
                                        <span class="text-gray-700">Base Price</span>
                                        <span id="basePrice" class="font-semibold ">IDR 0</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-300">
                                        <span class="text-gray-700">Background</span>
                                        <span id="bgPrice" class="font-semibold ">IDR 0</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-300">
                                        <span class="text-gray-700">Commercial Use</span>
                                        <span id="commercialPrice" class="font-semibold ">IDR 0</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b-2 border-gray-400">
                                        <span class="text-gray-700">Additional Characters</span>
                                        <span id="additionalCharsPrice" class="font-semibold ">IDR 0</span>
                                    </div>
                                    <div
                                        class="flex justify-between items-center py-3 bg-black text-white px-4 rounded-lg mt-4">
                                        <span class="font-bold text-xl">Total Price</span>
                                        <span id="totalPrice" class="font-bold text-2xl">IDR 0</span>
                                    </div>
                                </div>
                                <input type="hidden" name="final_price" id="finalPrice" value="0">
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex flex-col gap-6 bg-white rounded-2xl border-4 border-black p-6 md:p-8 text-gray-700 shadow-lg">
                        <h2 class="text-2xl mb-4 font-bold text-black border-b-2 border-gray-200 pb-4">Commission Details
                        </h2>

                        {{-- Deadline Input --}}
                        <div class="flex flex-col md:flex-row gap-4 md:gap-6">
                            <label class="font-semibold text-lg text-gray-800 md:w-[25%] md:pt-2">Deadline</label>
                            <div class="bg-gray-50 p-4 rounded-lg border-2 border-gray-200 md:w-[75%]">
                                <input type="date" name="deadline" id="deadline"
                                    min="{{ Carbon\Carbon::now()->addWeeks(2)->format('Y-m-d') }}"
                                    class="w-full bg-white border-2 border-gray-300 text-gray-700 rounded-lg px-4 py-2.5 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                                <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Minimum 2 weeks from today
                                </p>
                            </div>
                        </div>

                        {{-- Reference Image Upload --}}
                        <div class="flex flex-col md:flex-row gap-4 md:gap-6">
                            <label class="font-semibold text-lg text-gray-800 md:w-[25%] md:pt-2">Reference Image</label>
                            <div class="bg-gray-50 p-4 rounded-lg border-2 border-gray-200 md:w-[75%]">
                                <div class="flex flex-col gap-3">
                                    <div class="relative">
                                        <input type="file" name="image" id="imageInput" accept="image/*"
                                            class="bg-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-2 file:border-blue-500 file:font-semibold file:bg-blue-500 file:text-white hover:file:bg-blue-600 file:cursor-pointer file:transition-all text-sm text-gray-700 rounded-lg border-2 border-dashed border-gray-300 w-full p-2 hover:border-blue-500 transition-all cursor-pointer">
                                    </div>
                                    <p class="text-xs text-gray-500 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Optional. Maximum 2MB (JPG, PNG)
                                    </p>
                                    <div id="imagePreview"
                                        class="hidden mt-3 p-3 bg-white rounded-lg border-2 border-gray-300">
                                        <p class="text-xs text-gray-600 mb-2 font-semibold">Preview:</p>
                                        <img src="#" alt="Preview"
                                            class="max-w-full max-h-[250px] rounded-lg shadow-md mx-auto">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Commission Details --}}
                        <div class="flex flex-col md:flex-row gap-4 md:gap-6">
                            <label class="font-semibold text-lg text-gray-800 md:w-[25%] md:pt-2">Description</label>
                            <div class="bg-gray-50 p-4 rounded-lg border-2 border-gray-200 md:w-[75%]">
                                <textarea name="description" id="description" rows="5"
                                    placeholder="Describe your commission request in detail... Include character features, pose preferences, color schemes, mood, or any specific requirements."
                                    class="bg-white w-full border-2 border-gray-300 text-gray-700 rounded-lg px-4 py-3 resize-none focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all placeholder:text-gray-400"
                                    maxlength="1000"></textarea>
                                <div class="flex justify-between items-center mt-2">
                                    <p class="text-xs text-gray-500">Be as detailed as possible for better results</p>
                                    <p class="text-xs font-semibold" id="charCountDisplay">
                                        <span id="charCount" class="text-gray-700">0</span>
                                        <span class="text-gray-400">/1000</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex justify-end pt-6 border-t-2 border-gray-200">
                            <button type="submit"
                                class="bg-gradient-to-r from-[#f3a77e] to-[#e48d5f] border-3 border-black rounded-xl px-10 py-3.5 font-bold text-lg hover:from-[#e48d5f] hover:to-[#d67a4d] transition-all duration-200 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-[#f3a77e]/50 active:transform active:scale-95 text-black shadow-md">
                                Submit Commission Request
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite(['resources/js/member/commission_form.js'])
@endsection
