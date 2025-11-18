@extends('member.member_template')

@section('content')
<div class="flex justify-center min-h-screen py-8 px-4">
    <div class="flex justify-center bg-[#f0ebe3] border-4 border-black w-[95%] xl:w-[85%] rounded-2xl shadow-md">
        <div class="flex flex-col w-full p-6 md:p-10 gap-8">
            {{-- Show validation errors if any --}}
            @if ($errors->any())
                <div class="bg-red-50 text-red-500 p-4 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="post" action="{{ route('member.commission_store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="category" value="{{ $category ?? '' }}">
                <input type="hidden" name="price" id="finalPrice">

                {{-- Top Section: Image + Form Inputs --}}
                <div class="flex flex-col md:flex-row items-start gap-8 mb-8">
                    {{-- Left Image --}}
                    @php
                        $imgPath = match($category ?? '') {
                            'Head Shot' => asset('assets/comm_sample/HeadShot_Sample.png'),
                            'Half Body' => asset('assets/comm_sample/HalfBody_Sample.png'),
                            'Full Body' => asset('assets/comm_sample/FullBody_Sample.png'),
                            'Bust Up' => asset('assets/comm_sample/Custom_Sample.jpg'),
                            default => asset('assets/comm_sample/Custom_Sample.jpg'),
                        };
                    @endphp

                    <div class="flex flex-col justify-center items-center md:w-[40%]">
                        <img src="{{ $imgPath }}" alt="{{ $category ?? 'Sample' }}"
                            class="object-cover w-full max-w-[450px] rounded-xl border-3 border-black">
                        <p class="mt-4 font-[HammersmithOne-Regular] text-xl">{{ $category ?? 'No selection' }}</p>
                    </div>

                    {{-- Right Form Section (Top Inputs) --}}
                    <div class="flex flex-col w-full md:w-[60%] bg-white rounded-2xl border-4 border-black p-6">
                        <h2 class="text-2xl mb-6 font-[HammersmithOne-Regular] text-center">Commission Form</h2>
                        
                        <div class="flex flex-col gap-6 text-[#b4a6d5]">
                            {{-- Art Style Selection --}}
                            <div class="flex justify-between items-start bg-gray-50 p-4 rounded-lg">
                                <label class="font-[HammersmithOne-Regular] mt-1">Art Style:</label>
                                <div class="flex flex-col gap-2 w-[70%]">
                                    <div class="flex items-center gap-2">
                                        <input type="radio" name="style" value="normal" id="normal-style" required>
                                        <label for="normal-style">Normal Style</label>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input type="radio" name="style" value="cartoon" id="cartoon-style">
                                        <label for="cartoon-style">Cartoon Style</label>
                                    </div>
                                </div>
                            </div>

                            {{-- Background Options --}}
                            <div class="flex justify-between items-start bg-gray-50 p-4 rounded-lg">
                                <label class="font-[HammersmithOne-Regular] mt-1">Background:</label>
                                <div class="flex flex-col gap-2 w-[70%]">
                                    <div class="flex items-center gap-2">
                                        <input type="radio" name="background" value="none" id="no-bg" required>
                                        <label for="no-bg">No Background (+ 0k)</label>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input type="radio" name="background" value="simple" id="simple-bg">
                                        <label for="simple-bg">Simple Background (+ 5k)</label>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input type="radio" name="background" value="detailed" id="detailed-bg">
                                        <label for="detailed-bg">Detailed Background (+ 10k)</label>
                                    </div>
                                </div>
                            </div>

                            {{-- Price Display --}}
                            <div class="flex justify-between items-start">
                                <label class="font-[HammersmithOne-Regular] mt-1">Price:</label>
                                <div class="flex flex-col gap-1 w-[70%] bg-gray-50 p-4 rounded-lg border border-[#b4a6d5]">
                                    <p class="text-sm">Base Price: <span id="basePrice" class="font-medium">-</span></p>
                                    <p class="text-sm">Background Addition: <span id="bgPrice" class="font-medium">-</span></p>
                                    <div class="h-px bg-gray-200 my-2"></div>
                                    <p class="font-semibold text-lg">Total: <span id="totalPrice" class="text-[#a27fe1]">-</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bottom Section: Full Width Inputs --}}
                <div class="flex flex-col gap-6 bg-white rounded-2xl border-4 border-black p-6 md:p-8 text-[#b4a6d5]">
                        <h2 class="text-2xl mb-6 font-[HammersmithOne-Regular] text-black">Commission Details</h2>
                    {{-- Deadline Input --}}
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2">
                        <label class="font-[HammersmithOne-Regular]">Deadline:</label>
                        <div class="w-full md:w-[70%]">
                            <input type="date" name="deadline" 
                                min="{{ Carbon\Carbon::now()->addWeeks(2)->format('Y-m-d') }}"
                                class="w-full border-3 border-[#b4a6d5] text-[#b4a6d5] rounded-lg px-3 py-2 focus:outline-none focus:border-[#a27fe1] focus:ring-2 focus:ring-[#a27fe1]/20"
                                required>
                            <p class="text-xs text-gray-500 mt-1">Minimum 2 weeks from today</p>
                        </div>
                    </div>

                    {{-- Reference Image Upload --}}
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-2">
                        <label class="font-[HammersmithOne-Regular] md:mt-1">Reference:</label>
                        <div class="flex flex-col gap-2 w-full md:w-[70%]">
                            <input type="file" name="image" accept="image/*"
                                class="file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-[#b4a6d5] file:text-white hover:file:bg-[#a27fe1] text-sm text-gray-500 rounded-lg border-3 border-[#b4a6d5] w-full"
                                onChange="previewImage(this)">
                            <span class="text-xs text-gray-500">Optional. Max 2MB (JPG, PNG)</span>
                            <div id="imagePreview" class="hidden mt-2">
                                <img src="#" alt="Preview" class="max-w-[200px] max-h-[200px] rounded-lg border-2 border-[#b4a6d5]">
                            </div>
                        </div>
                    </div>

                    {{-- Commission Details --}}
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-2">
                        <label class="font-[HammersmithOne-Regular] md:mt-1">Details:</label>
                        <div class="w-full md:w-[70%]">
                            <textarea name="description" rows="4" 
                                placeholder="Describe your commission request in detail..."
                                class="w-full border-3 border-[#b4a6d5] text-[#b4a6d5] rounded-lg px-3 py-2 resize-none focus:outline-none focus:border-[#a27fe1] focus:ring-2 focus:ring-[#a27fe1]/20"
                                required></textarea>
                            <p class="text-xs text-gray-500 mt-1">Maximum 1000 characters</p>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex justify-end pt-4">
                        <button type="submit"
                            class="bg-[#f3a77e] border-3 border-black rounded-xl px-8 py-3 font-[HammersmithOne-Regular] hover:bg-[#e48d5f] transition-all duration-200 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#f3a77e]/50 active:transform active:scale-95 text-black">
                            Submit Commission
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const prices = {
            normal: {
                'Head Shot': 40000,
                'Bust Up': 50000,
                'Half Body': 65000,
                'Full Body': 125000
            },
            cartoon: {
                'Bust Up': 25000,
                'Half Body': 35000,
                'Full Body': 50000
            }
        };

        const bgPrices = {
            none: 0,
            simple: 5000,
            detailed: 10000
        };

        const styleInputs = document.querySelectorAll('input[name="style"]');
        const bgInputs = document.querySelectorAll('input[name="background"]');
        const descriptionInput = document.querySelector('textarea[name="description"]');
        
        function updatePrice() {
            const style = document.querySelector('input[name="style"]:checked')?.value;
            const bg = document.querySelector('input[name="background"]:checked')?.value;
            const category = '{{ $category }}';

            if (style && bg && category) {
                const basePrice = prices[style][category] || 0;
                const bgPrice = bgPrices[bg];
                const total = basePrice + bgPrice;

                document.getElementById('basePrice').textContent = `${basePrice.toLocaleString('id-ID')} IDR`;
                document.getElementById('bgPrice').textContent = `${bgPrice.toLocaleString('id-ID')} IDR`;
                document.getElementById('totalPrice').textContent = `${total.toLocaleString('id-ID')} IDR`;
            }
        }

        styleInputs.forEach(input => input.addEventListener('change', updatePrice));
        bgInputs.forEach(input => input.addEventListener('change', updatePrice));

        // Append style to description
        document.querySelector('form').addEventListener('submit', function(e) {
            const style = document.querySelector('input[name="style"]:checked')?.value;
            if (style) {
                descriptionInput.value += `\n${style.charAt(0).toUpperCase() + style.slice(1)} style.`;
            }
        });
    });

    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const img = preview.querySelector('img');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.classList.add('hidden');
        }
    }
</script>
@endsection