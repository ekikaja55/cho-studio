@extends('member.member_template')

@section('content')
<div class="flex justify-center min-h-screen py-8 px-4">
    <div class="flex justify-center bg-[#f0ebe3] border-4 border-black w-[95%] xl:w-[85%] rounded-2xl shadow-md">
        <div class="flex flex-col w-full p-6 md:p-10 gap-8">
            {{-- Alert Message Container --}}
            <div id="alertContainer" class="hidden fixed top-4 left-1/2 transform -translate-x-1/2 w-[90%] max-w-md z-50">
                <div id="alertBox" class="flex items-start gap-3 p-4 rounded-lg shadow-lg border-l-4">
                    <svg id="alertIcon" class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"></svg>
                    <div>
                        <h3 id="alertTitle" class="font-semibold"></h3>
                        <ul id="errorList" class="text-sm mt-2 space-y-1 list-disc list-inside"></ul>
                        <p id="successMessage" class="text-sm mt-2"></p>
                    </div>
                </div>
            </div>

            {{-- Show server-side validation errors if any --}}
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="post" action="{{ route('member.commission_store') }}" enctype="multipart/form-data" id="commissionForm">
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
                                        <input type="radio" name="style" value="normal" id="normal-style">
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
                                        <input type="radio" name="background" value="none" id="no-bg">
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
                            <input type="date" name="deadline" id="deadline"
                                min="{{ Carbon\Carbon::now()->addWeeks(2)->format('Y-m-d') }}"
                                class="w-full border-3 border-[#b4a6d5] text-[#b4a6d5] rounded-lg px-3 py-2 focus:outline-none focus:border-[#a27fe1] focus:ring-2 focus:ring-[#a27fe1]/20">
                            <p class="text-xs text-gray-500 mt-1">Minimum 2 weeks from today</p>
                        </div>
                    </div>

                    {{-- Reference Image Upload --}}
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-2">
                        <label class="font-[HammersmithOne-Regular] md:mt-1">Reference:</label>
                        <div class="flex flex-col gap-2 w-full md:w-[70%]">
                            <input type="file" name="image" id="imageInput" accept="image/*"
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
                            <textarea name="description" id="description" rows="4" 
                                placeholder="Describe your commission request in detail..."
                                class="w-full border-3 border-[#b4a6d5] text-[#b4a6d5] rounded-lg px-3 py-2 resize-none focus:outline-none focus:border-[#a27fe1] focus:ring-2 focus:ring-[#a27fe1]/20"
                                maxlength="1000"></textarea>
                            <div class="flex justify-between items-center mt-1">
                                <p class="text-xs text-gray-500">Maximum 1000 characters</p>
                                <p class="text-xs text-gray-500"><span id="charCount">0</span>/1000</p>
                            </div>
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
        const form = document.getElementById('commissionForm');
        
        // Character counter
        descriptionInput.addEventListener('input', function() {
            document.getElementById('charCount').textContent = this.value.length;
        });

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
                
                document.getElementById('finalPrice').value = total;
            }
        }

        styleInputs.forEach(input => input.addEventListener('change', updatePrice));
        bgInputs.forEach(input => input.addEventListener('change', updatePrice));

        // Show alert with errors or success
        function showAlert(errors = null, isSuccess = false) {
            const alertContainer = document.getElementById('alertContainer');
            const alertBox = document.getElementById('alertBox');
            const alertTitle = document.getElementById('alertTitle');
            const errorList = document.getElementById('errorList');
            const successMessage = document.getElementById('successMessage');
            const alertIcon = document.getElementById('alertIcon');

            if (isSuccess) {
                // Success alert (green)
                alertBox.className = 'flex items-start gap-3 p-4 rounded-lg shadow-lg border-l-4 bg-green-100 border-green-500 text-green-700';
                alertTitle.textContent = 'Success!';
                alertTitle.className = 'font-semibold text-green-700';
                errorList.innerHTML = '';
                successMessage.textContent = 'Your commission has been submitted successfully!';
                successMessage.className = 'text-sm mt-2 text-green-700';
                
                // Success icon
                alertIcon.innerHTML = `<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>`;
                alertIcon.className = 'w-5 h-5 mt-0.5 flex-shrink-0 text-green-700';
            } else {
                // Error alert (red)
                alertBox.className = 'flex items-start gap-3 p-4 rounded-lg shadow-lg border-l-4 bg-red-100 border-red-500 text-red-700';
                alertTitle.textContent = 'Validation Error';
                alertTitle.className = 'font-semibold text-red-700';
                successMessage.textContent = '';
                
                errorList.innerHTML = '';
                errors.forEach(error => {
                    const li = document.createElement('li');
                    li.textContent = error;
                    li.className = 'text-red-700';
                    errorList.appendChild(li);
                });
                
                // Error icon
                alertIcon.innerHTML = `<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>`;
                alertIcon.className = 'w-5 h-5 mt-0.5 flex-shrink-0 text-red-700';
            }
            
            alertContainer.classList.remove('hidden');
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                alertContainer.classList.add('hidden');
            }, 5000);
        }

        // Form validation
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const errors = [];
            
            // Validate Art Style
            const selectedStyle = document.querySelector('input[name="style"]:checked');
            if (!selectedStyle) {
                errors.push('Please select an Art Style (Normal or Cartoon)');
            }
            
            // Validate Background
            const selectedBg = document.querySelector('input[name="background"]:checked');
            if (!selectedBg) {
                errors.push('Please select a Background option');
            }
            
            // Validate Deadline
            const deadline = document.getElementById('deadline').value;
            if (!deadline) {
                errors.push('Please select a Deadline date');
            } else {
                const selectedDate = new Date(deadline);
                const minDate = new Date();
                minDate.setDate(minDate.getDate() + 14);
                
                if (selectedDate < minDate) {
                    errors.push('Deadline must be at least 2 weeks from today');
                }
            }
            
            // Validate Description
            const description = descriptionInput.value.trim();
            if (!description) {
                errors.push('Please fill in the Commission Details');
            } else if (description.length > 1000) {
                errors.push('Commission Details cannot exceed 1000 characters');
            }
            
            // Show errors if any
            if (errors.length > 0) {
                showAlert(errors, false);
                return false;
            }
            
            // If validation passes, append style and submit
            const style = document.querySelector('input[name="style"]:checked')?.value;
            if (style) {
                descriptionInput.value += `\n${style.charAt(0).toUpperCase() + style.slice(1)} style.`;
            }
            
            // Show success alert before submitting
            showAlert(null, true);
            
            // Submit after showing success message
            setTimeout(() => {
                form.submit();
            }, 1500);
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