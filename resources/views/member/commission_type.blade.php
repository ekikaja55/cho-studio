@extends('member.member_template')

@section('content')
    <div class="flex justify-center items-center min-h-screen py-8 px-4 font-[HammersmithOne-Regular]">
        <div
            class="flex flex-col items-center bg-[#f0ebe3] border-4 border-black w-[95%] xl:w-[85%] rounded-2xl shadow-xl p-8 md:p-12">
            <!-- Title Section -->
            <div class="text-center mb-6">
                <h1 class="text-4xl md:text-3xl font-bold text-black">Choose Your Artwork Type</h1>
                <p class="text-gray-700">Select the commission style that best fits your vision</p>
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 w-full max-w-6xl">
                <!-- Head Shot -->
                <a href="{{ route('member.commission_form', ['type' => 'headshot']) }}"
                    class="group block transform transition-all duration-300 hover:scale-105">
                    <div
                        class="flex flex-col items-center rounded-2xl overflow-hidden bg-white border-4 border-black shadow-lg hover:shadow-2xl transition-all duration-300 relative">
                        <div class="w-full h-[280px] overflow-hidden bg-gradient-to-b from-gray-50 to-gray-100">
                            <img src="{{ asset('assets/comm_sample/HeadShot_Sample.png') }}" alt="Commission Head Shot"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>
                        <div
                            class="w-full py-4 px-4 bg-gradient-to-r from-blue-500 to-blue-600 group-hover:from-blue-600 group-hover:to-blue-700 transition-all duration-300">
                            <p class="font-bold text-lg text-white text-center">Head Shot</p>
                            <p class="text-xs text-blue-100 text-center mt-1">Starting from IDR 40,000</p>
                        </div>
                        <div
                            class="absolute top-3 right-3 bg-black text-white text-xs px-3 py-1 rounded-full font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            Select →
                        </div>
                    </div>
                </a>

                <!-- Bust Up -->
                <a href="{{ route('member.commission_form', ['type' => 'bustup']) }}"
                    class="group block transform transition-all duration-300 hover:scale-105">
                    <div
                        class="flex flex-col items-center rounded-2xl overflow-hidden bg-white border-4 border-black shadow-lg hover:shadow-2xl transition-all duration-300 relative">
                        <div class="w-full h-[280px] overflow-hidden bg-gradient-to-b from-gray-50 to-gray-100">
                            <img src="{{ asset('assets/comm_sample/Custom_Sample.jpg') }}" alt="Commission Bust Up"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>
                        <div
                            class="w-full py-4 px-4 bg-gradient-to-r from-purple-500 to-purple-600 group-hover:from-purple-600 group-hover:to-purple-700 transition-all duration-300">
                            <p class="font-bold text-lg text-white text-center">Bust Up</p>
                            <p class="text-xs text-purple-100 text-center mt-1">Starting from IDR 50,000</p>
                        </div>
                        <div
                            class="absolute top-3 right-3 bg-black text-white text-xs px-3 py-1 rounded-full font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            Select →
                        </div>
                    </div>
                </a>

                <!-- Half Body -->
                <a href="{{ route('member.commission_form', ['type' => 'halfbody']) }}"
                    class="group block transform transition-all duration-300 hover:scale-105">
                    <div
                        class="flex flex-col items-center rounded-2xl overflow-hidden bg-white border-4 border-black shadow-lg hover:shadow-2xl transition-all duration-300 relative">
                        <div class="w-full h-[280px] overflow-hidden bg-gradient-to-b from-gray-50 to-gray-100">
                            <img src="{{ asset('assets/comm_sample/HalfBody_Sample.png') }}" alt="Commission Half Body"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>
                        <div
                            class="w-full py-4 px-4 bg-gradient-to-r from-pink-500 to-pink-600 group-hover:from-pink-600 group-hover:to-pink-700 transition-all duration-300">
                            <p class="font-bold text-lg text-white text-center">Half Body</p>
                            <p class="text-xs text-pink-100 text-center mt-1">Starting from IDR 65,000</p>
                        </div>
                        <div
                            class="absolute top-3 right-3 bg-black text-white text-xs px-3 py-1 rounded-full font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            Select →
                        </div>
                    </div>
                </a>

                <!-- Full Body -->
                <a href="{{ route('member.commission_form', ['type' => 'fullbody']) }}"
                    class="group block transform transition-all duration-300 hover:scale-105">
                    <div
                        class="flex flex-col items-center rounded-2xl overflow-hidden bg-white border-4 border-black shadow-lg hover:shadow-2xl transition-all duration-300 relative">
                        <div class="w-full h-[280px] overflow-hidden bg-gradient-to-b from-gray-50 to-gray-100">
                            <img src="{{ asset('assets/comm_sample/FullBody_Sample.png') }}" alt="Commission Full Body"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>
                        <div
                            class="w-full py-4 px-4 bg-gradient-to-r from-orange-500 to-orange-600 group-hover:from-orange-600 group-hover:to-orange-700 transition-all duration-300">
                            <p class="font-bold text-lg text-white text-center">Full Body</p>
                            <p class="text-xs text-orange-100 text-center mt-1">Starting from IDR 125,000</p>
                        </div>
                        <div
                            class="absolute top-3 right-3 bg-black text-white text-xs px-3 py-1 rounded-full font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            Select →
                        </div>
                    </div>
                </a>
            </div>

            <!-- Additional Info Section -->
            <div class="mt-6 text-center max-w-2xl">
                <p class="text-gray-600 text-sm">
                    <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    Click on any artwork type to customize your commission with additional options and pricing
                </p>
            </div>
        </div>
    </div>
@endsection
