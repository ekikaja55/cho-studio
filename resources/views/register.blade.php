@extends('template')

@section('content')
    <style>
        /* Prevent browser autofill from changing background color */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #a2e1db inset !important;
            -webkit-text-fill-color: #000 !important;
        }
        input:autofill {
            background-color: #a2e1db !important;
        }
    </style>

    <div class="flex justify-center items-center min-h-screen py-8">
        <div class="flex flex-col relative justify-center items-center bg-[#f0ebe3] w-[95%] md:w-[85%] lg:w-[80%] min-h-[90vh] sm:min-h-[85vh] md:min-h-[80vh] p-4 sm:p-6 md:p-8 rounded-3xl border-4 border-black">
            {{-- Back to home --}}
            <div class="absolute top-4 left-4 sm:top-10 sm:left-10 w-full flex justify-start mb-4">
                <a href={{ route('home') }}
                    class="flex items-center gap-2 font-[HammersmithOne-Regular] bg-[#a2e1db] hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-base px-3 py-2 sm:px-4 sm:py-2 rounded-2xl border-2 sm:border-4 border-black">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span class="hidden sm:inline">Back to Home</span>
                </a>
            </div>

            <div class="flex justify-center mb-6 font-[HammersmithOne-Regular] mt-[5vh]">
                <h1 class="text-3xl md:text-5xl lg:text-5xl">Register</h1>
            </div>

            <form class="w-full max-w-4xl" action="{{ route('process_register') }}" method="post" id="registerForm">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <h3 class="font-[HammersmithOne-Regular] text-xl font-semibold text-center text-gray-800 mb-1">Basic Information</h3>
                        <p class="font-[HammersmithOne-Regular] text-sm text-center text-gray-600 mb-4">Please provide your basic details below</p>
                        <div class="space-y-4">
                            <input class="bg-[#a2e1db] font-[HammersmithOne-Regular] placeholder-[#477c77] rounded-2xl p-4 text-base w-full focus:outline-none focus:ring-4 focus:ring-[#477c77] focus:border-transparent transition-all duration-200"
                                type="text" name="username" id="username" placeholder="Username">
                            <input class="bg-[#a2e1db] font-[HammersmithOne-Regular] placeholder-[#477c77] rounded-2xl p-4 text-base w-full focus:outline-none focus:ring-4 focus:ring-[#477c77] focus:border-transparent transition-all duration-200"
                                type="email" name="email" id="email" placeholder="Email Address">
                            <input class="bg-[#a2e1db] font-[HammersmithOne-Regular] placeholder-[#477c77] rounded-2xl p-4 text-base w-full focus:outline-none focus:ring-4 focus:ring-[#477c77] focus:border-transparent transition-all duration-200"
                                type="password" name="password" id="password" placeholder="Password">
                            <input class="bg-[#a2e1db] font-[HammersmithOne-Regular] placeholder-[#477c77] rounded-2xl p-4 text-base w-full focus:outline-none focus:ring-4 focus:ring-[#477c77] focus:border-transparent transition-all duration-200"
                                type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="space-y-4">
                        <h3 class="font-[HammersmithOne-Regular] text-xl font-semibold text-center text-gray-800 mb-1">Contact Information</h3>
                        <p class="font-[HammersmithOne-Regular] text-sm text-center text-gray-600 mb-4">Please provide at least one contact method below</p>

                        <div class="space-y-4">
                            {{-- Line ID --}}
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="has_line_id" id="has_line_id" class="w-5 h-5 rounded border-2 border-black">
                                    <span class="text-base font-semibold text-gray-800">Line ID</span>
                                </label>
                                <input class="bg-[#a2e1db] placeholder-[#477c77] font-[HammersmithOne-Regular] rounded-2xl p-4 text-base w-full hidden contact-field focus:outline-none focus:ring-4 focus:ring-[#477c77] focus:border-transparent transition-all duration-200"
                                    type="text" name="line_id" id="line_id" placeholder="Enter your Line ID">
                            </div>

                            {{-- Phone --}}
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="has_phone" id="has_phone" class="w-5 h-5 rounded border-2 border-black">
                                    <span class="text-base font-semibold text-gray-800">Phone Number</span>
                                </label>
                                <input class="bg-[#a2e1db] placeholder-[#477c77] font-[HammersmithOne-Regular] rounded-2xl p-4 text-base w-full hidden contact-field focus:outline-none focus:ring-4 focus:ring-[#477c77] focus:border-transparent transition-all duration-200"
                                    type="tel" name="phone_number" id="phone_number" placeholder="Enter your phone number">
                            </div>

                            {{-- Instagram --}}
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="has_instagram" id="has_instagram" class="w-5 h-5 rounded border-2 border-black">
                                    <span class="text-base font-semibold text-gray-800">Instagram</span>
                                </label>
                                <input class="bg-[#a2e1db] placeholder-[#477c77] font-[HammersmithOne-Regular] rounded-2xl p-4 text-base w-full hidden contact-field focus:outline-none focus:ring-4 focus:ring-[#477c77] focus:border-transparent transition-all duration-200"
                                    type="text" name="instagram" id="instagram" placeholder="Enter your Instagram handle">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Terms Checkbox -->
                <div class="flex items-center gap-3 mt-4">
                    {{-- FIX: Ditambahkan attribute name="agree_terms" --}}
                    <input type="checkbox" id="agree_terms" name="agree_terms" class="w-5 h-5"
                        {{ request()->has('accepted') ? 'checked' : '' }}>
                    <label for="agree_terms" class="text-base font-semibold text-gray-800">
                        I agree to the <a href="{{ route('termsnconditions') }}" class="text-blue-600 underline">Terms & Conditions</a>
                    </label>
                </div>

                <div class="flex justify-center mt-8">
                    <button type="submit"
                        class="font-[HammersmithOne-Regular] bg-[#b4a6d5] w-full max-w-md py-4 text-xl rounded-2xl border-3 border-black hover:bg-[#8b7db8] focus:outline-none focus:ring-4 focus:ring-[#ffac81] transition-colors duration-300 ease-in-out">Register</button>
                </div>
            </form>

            <div class="flex flex-col items-center gap-3 mt-6">
                <a href="/login"
                    class="text-base font-semibold text-black hover:text-[#ffac81] transition-colors duration-300 md:text-lg lg:text-xl">
                    Already have an account? Login here
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const $ = window.jQuery || window.$;

        $(document).ready(function() {
            // --- DEFINISI ELEMENT ---
            const lineIdCheckbox = $('#has_line_id');
            const phoneCheckbox = $('#has_phone');
            const instagramCheckbox = $('#has_instagram');

            const lineIdInput = $('#line_id');
            const phoneInput = $('#phone_number');
            const instagramInput = $('#instagram');
            const termsCheckbox = $('#agree_terms');

            // ===============================================
            // 1. FITUR AUTO-SAVE (Agar data teks tidak hilang)
            // ===============================================

            // A. Fungsi Restore
            function restoreFormData() {
                $('#registerForm').find('input').each(function() {
                    const name = $(this).attr('name');
                    const type = $(this).attr('type');
                    
                    // Skip password & hidden token
                    if(type === 'password' || type === 'hidden' || !name) return;

                    const savedVal = sessionStorage.getItem('reg_' + name);
                    
                    if (savedVal !== null) {
                        if (type === 'checkbox') {
                            const isChecked = savedVal === 'true';
                            $(this).prop('checked', isChecked);
                            if(isChecked) {
                                // Trigger logika show/hide untuk kontak
                                if(name === 'has_line_id') lineIdInput.removeClass('hidden');
                                if(name === 'has_phone') phoneInput.removeClass('hidden');
                                if(name === 'has_instagram') instagramInput.removeClass('hidden');
                            }
                        } else {
                            $(this).val(savedVal);
                        }
                    }
                });
            }

            // B. Fungsi Save (Saat mengetik/klik)
            $('#registerForm').on('input change', 'input', function() {
                const name = $(this).attr('name');
                const type = $(this).attr('type');
                
                if(type === 'password' || type === 'hidden' || !name) return;

                let value;
                if (type === 'checkbox') {
                    value = $(this).is(':checked');
                } else {
                    value = $(this).val();
                }
                sessionStorage.setItem('reg_' + name, value);
            });

            // C. Clear Data
            function clearFormData() {
                $('#registerForm').find('input').each(function() {
                    const name = $(this).attr('name');
                    if(name) sessionStorage.removeItem('reg_' + name);
                });
            }

            // ===============================================
            // 2. LOGIKA TOGGLE KONTAK (UI Only)
            // ===============================================
            lineIdCheckbox.on('change', function() {
                if (this.checked) lineIdInput.removeClass('hidden');
                else {
                    lineIdInput.addClass('hidden');
                    lineIdInput.val('');
                    sessionStorage.setItem('reg_line_id', '');
                }
            });

            phoneCheckbox.on('change', function() {
                if (this.checked) phoneInput.removeClass('hidden');
                else {
                    phoneInput.addClass('hidden');
                    phoneInput.val('');
                    sessionStorage.setItem('reg_phone_number', '');
                }
            });

            instagramCheckbox.on('change', function() {
                if (this.checked) instagramInput.removeClass('hidden');
                else {
                    instagramInput.addClass('hidden');
                    instagramInput.val('');
                    sessionStorage.setItem('reg_instagram', '');
                }
            });

            // ===============================================
            // 3. EKSEKUSI SAAT LOAD
            // ===============================================
            
            // 1. Restore data lama dari sesi sebelumnya
            restoreFormData(); 

            // 2. CEK URL PARAMETER (?accepted=1)
            // Ini akan memaksa checkbox tercentang jika user kembali dari halaman Terms
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('accepted') === '1') {
                console.log("URL accepted=1 detected. Auto-checking terms.");
                // Centang visual
                termsCheckbox.prop('checked', true);
                // Simpan ke storage agar persist kalau di-refresh
                sessionStorage.setItem('reg_agree_terms', 'true');
            }

            // ===============================================
            // 4. LOGIKA SUBMIT
            // ===============================================
            $('#registerForm').on('submit', function(e) {
                e.preventDefault();

                const username = $('#username').val().trim();
                const email = $('#email').val().trim();
                const password = $('#password').val();
                const confirmPassword = $('#password_confirmation').val();

                if (username === '' || email === '' || password === '' || confirmPassword === '') {
                    notie.alert({ type: 'error', text: 'Please fill in all required fields.', time: 5 });
                    return;
                }

                if (!termsCheckbox.is(':checked')) {
                    notie.alert({ type: 'error', text: 'You must accept the Terms & Conditions.', time: 5 });
                    return;
                }

                if (password !== confirmPassword) {
                    notie.alert({ type: 'error', text: 'Passwords do not match.', time: 5 });
                    return;
                }

                if (password.length < 8) {
                    notie.alert({ type: 'error', text: 'Password must be at least 8 characters.', time: 5 });
                    return;
                }

                const hasLineId = lineIdCheckbox.is(':checked') && $.trim(lineIdInput.val()) !== '';
                const hasPhone = phoneCheckbox.is(':checked') && $.trim(phoneInput.val()) !== '';
                const hasInstagram = instagramCheckbox.is(':checked') && $.trim(instagramInput.val()) !== '';

                if (!hasLineId && !hasPhone && !hasInstagram) {
                    notie.alert({ type: 'error', text: 'Please provide at least one contact method.', time: 5 });
                    return;
                }

                const formData = $(this).serialize();
                const actionUrl = $(this).attr('action');
                const submitButton = $(this).find('button[type="submit"]');

                submitButton.prop('disabled', true).text('Registering...');

                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',

                    success: function(response) {
                        submitButton.prop('disabled', false).text('Register');
                        if (response.success) {
                            clearFormData(); // Bersihkan storage
                            notie.alert({ type: 'success', text: response.message, time: 2 });
                            setTimeout(() => {
                                window.location.href = response.redirect_url;
                            }, 500);
                        } else {
                            notie.alert({ type: 'error', text: response.message, time: 5 });
                        }
                    },
                    error: function(xhr) {
                        submitButton.prop('disabled', false).text('Register');
                        let errorMessage = 'An error occurred.';
                        try {
                            const response = xhr.responseJSON;
                            if (xhr.status === 422) {
                                if (response && response.message) errorMessage = response.message;
                                else if (response && response.errors) {
                                    const firstKey = Object.keys(response.errors)[0];
                                    errorMessage = response.errors[firstKey][0];
                                }
                            }
                        } catch (e) { console.error(e); }
                        notie.alert({ type: 'error', text: errorMessage, time: 10 });
                    }
                });
            });
        });
    </script>
@endsection