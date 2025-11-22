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

        /* For other browsers */
        input:autofill {
            background-color: #a2e1db !important;
        }
    </style>

    <div class="flex justify-center items-center min-h-screen py-8">
        <div
            class="flex flex-col relative justify-center items-center bg-[#f0ebe3] w-[95%] md:w-[85%] lg:w-[80%] min-h-[90vh] sm:min-h-[85vh] md:min-h-[80vh] p-4 sm:p-6 md:p-8 rounded-3xl border-4 border-black">
            {{-- Back to home --}}
            <div class="absolute top-4 left-4 sm:top-10 sm:left-10 w-full flex justify-start mb-4">
                <a href={{ route('home') }}
                    class="flex items-center gap-2 font-[HammersmithOne-Regular] bg-[#a2e1db] hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-base px-3 py-2 sm:px-4 sm:py-2 rounded-2xl border-2 sm:border-4 border-black">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span class="hidden sm:inline">Back to Home</span>
                </a>
            </div>

            {{-- judul --}}
            <div class="flex justify-center mb-6 font-[HammersmithOne-Regular] mt-[5vh]">
                <h1 class="text-3xl md:text-5xl lg:text-5xl">Register</h1>
            </div>

            <form class="w-full max-w-4xl" action="{{ route('process_register') }}" method="post" id="registerForm">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <h3 class="font-[HammersmithOne-Regular] text-xl font-semibold text-center text-gray-800 mb-1">Basic
                            Information</h3>
                        <p class="font-[HammersmithOne-Regular] text-sm text-center text-gray-600 mb-4">Please provide your
                            basic details below</p>
                        <div class="space-y-4">
                            <input
                                class="bg-[#a2e1db] font-[HammersmithOne-Regular] placeholder-[#477c77] rounded-2xl p-4 text-base w-full focus:outline-none focus:ring-4 focus:ring-[#477c77] focus:border-transparent transition-all duration-200"
                                type="text" name="username" id="username" placeholder="Username">
                            <input
                                class="bg-[#a2e1db] font-[HammersmithOne-Regular] placeholder-[#477c77] rounded-2xl p-4 text-base w-full focus:outline-none focus:ring-4 focus:ring-[#477c77] focus:border-transparent transition-all duration-200"
                                type="email" name="email" id="email" placeholder="Email Address">
                            <input
                                class="bg-[#a2e1db] font-[HammersmithOne-Regular] placeholder-[#477c77] rounded-2xl p-4 text-base w-full focus:outline-none focus:ring-4 focus:ring-[#477c77] focus:border-transparent transition-all duration-200"
                                type="password" name="password" id="password" placeholder="Password">
                            <input
                                class="bg-[#a2e1db] font-[HammersmithOne-Regular] placeholder-[#477c77] rounded-2xl p-4 text-base w-full focus:outline-none focus:ring-4 focus:ring-[#477c77] focus:border-transparent transition-all duration-200"
                                type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="Confirm Password">
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="space-y-4">
                        <h3 class="font-[HammersmithOne-Regular] text-xl font-semibold text-center text-gray-800 mb-1">
                            Contact Information</h3>
                        <p class="font-[HammersmithOne-Regular] text-sm text-center text-gray-600 mb-4">Please provide at
                            least one contact method below
                        </p>

                        <div class="space-y-4">
                            {{-- Added checkbox for Line ID with show/hide functionality --}}
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="has_line_id" id="has_line_id"
                                        class="w-5 h-5 rounded border-2 border-black">
                                    <span class="text-base font-semibold text-gray-800">Line ID</span>
                                </label>
                                <input
                                    class="bg-[#a2e1db] placeholder-[#477c77] font-[HammersmithOne-Regular] rounded-2xl p-4 text-base w-full hidden contact-field focus:outline-none focus:ring-4 focus:ring-[#477c77] focus:border-transparent transition-all duration-200"
                                    type="text" name="line_id" id="line_id" placeholder="Enter your Line ID">
                            </div>

                            {{-- Added checkbox for Phone Number with show/hide functionality --}}
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="has_phone" id="has_phone"
                                        class="w-5 h-5 rounded border-2 border-black">
                                    <span class="text-base font-semibold text-gray-800">Phone Number</span>
                                </label>
                                <input
                                    class="bg-[#a2e1db] placeholder-[#477c77] font-[HammersmithOne-Regular] rounded-2xl p-4 text-base w-full hidden contact-field focus:outline-none focus:ring-4 focus:ring-[#477c77] focus:border-transparent transition-all duration-200"
                                    type="tel" name="phone_number" id="phone_number"
                                    placeholder="Enter your phone number">
                            </div>

                            {{-- Added checkbox for Instagram with show/hide functionality --}}
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="has_instagram" id="has_instagram"
                                        class="w-5 h-5 rounded border-2 border-black">
                                    <span class="text-base font-semibold text-gray-800">Instagram</span>
                                </label>
                                <input
                                    class="bg-[#a2e1db] placeholder-[#477c77] font-[HammersmithOne-Regular] rounded-2xl p-4 text-base w-full hidden contact-field focus:outline-none focus:ring-4 focus:ring-[#477c77] focus:border-transparent transition-all duration-200"
                                    type="text" name="instagram" id="instagram"
                                    placeholder="Enter your Instagram handle">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-4">
                    <input type="checkbox" id="agree_terms" class="w-5 h-5"
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
        
        $(document).ready(function() {
            const lineIdCheckbox = $('#has_line_id');
            const phoneCheckbox = $('#has_phone');
            const instagramCheckbox = $('#has_instagram');

            const lineIdInput = $('#line_id');
            const phoneInput = $('#phone_number');
            const instagramInput = $('#instagram');

            lineIdCheckbox.on('change', function() {
                lineIdInput.toggleClass('hidden');
                if (!this.checked) lineIdInput.val('');
            });

            phoneCheckbox.on('change', function() {
                phoneInput.toggleClass('hidden');
                if (!this.checked) phoneInput.val('');
            });

            instagramCheckbox.on('change', function() {
                instagramInput.toggleClass('hidden');
                if (!this.checked) instagramInput.val('');
            });

            $('#registerForm').on('submit', function(e) {
                e.preventDefault();

                const username = $('#username').val().trim();
                const email = $('#email').val().trim();
                const password = $('#password').val();
                const confirmPassword = $('#password_confirmation').val();

                // Basic validation
                if (username === '' || email === '' || password === '' || confirmPassword ===
                    '') {
                    notie.alert({
                        type: 'error',
                        text: 'Please fill in all required fields.',
                        time: 5,
                    });
                    return;
                }

                if (!$('#agree_terms').is(':checked')) {
                    notie.alert({
                        type: 'error',
                        text: 'You must accept the Terms & Conditions before registering.',
                        time: 5,
                    });
                    return;
                }

                // Password confirmation validation
                if (password !== confirmPassword) {
                    notie.alert({
                        type: 'error',
                        text: 'Passwords do not match.',
                        time: 5,
                    });
                    return;
                }

                // Password length validation
                if (password.length < 8) {
                    notie.alert({
                        type: 'error',
                        text: 'Password must be at least 8 characters long.',
                        time: 5,
                    });
                    return;
                }

                // Contact method validation
                const hasLineId = lineIdCheckbox.is(':checked') && $.trim(lineIdInput.val()) !== '';
                const hasPhone = phoneCheckbox.is(':checked') && $.trim(phoneInput.val()) !== '';
                const hasInstagram = instagramCheckbox.is(':checked') && $.trim(instagramInput.val()) !==
                    '';

                if (!hasLineId && !hasPhone && !hasInstagram) {
                    notie.alert({
                        type: 'error',
                        text: 'Please provide at least one contact method (Line ID, Phone Number, or Instagram).',
                        time: 5,
                    });
                    return;
                }

                const formData = $(this).serialize();
                const actionUrl = $(this).attr('action');
                const submitButton = $(this).find('button[type="submit"]');

                // Disable the submit button to prevent multiple clicks
                submitButton.prop('disabled', true).text('Registering...');

                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',

                    success: function(response) {
                        console.log('Registration response:', response);

                        submitButton.prop('disabled', false).text('Register');

                        if (response.success) {
                            notie.alert({
                                type: 'success',
                                text: response.message,
                                time: 2,
                            });

                            

                            setTimeout(() => {
                                window.location.href = response.redirect_url;
                            }, 500);
                        } else {
                            notie.alert({
                                type: 'error',
                                text: response.message,
                                time: 5,
                            });
                        }
                    },

                    error: function(xhr) {
                        console.error('Registration error:', xhr);
                        submitButton.prop('disabled', false).text('Register');

                        let errorMessage = 'An error occurred. Please try again.';

                        try {
                            const response = xhr.responseJSON;

                            if (xhr.status === 422) {
                                // Validation errors
                                if (response && response.message) {
                                    errorMessage = response.message;
                                } else if (response && response.errors) {
                                    // Get first validation error
                                    const firstErrorField = Object.keys(response.errors)[0];
                                    errorMessage = response.errors[firstErrorField][0];
                                }
                            } else if (xhr.status === 500) {
                                errorMessage = response.message ||
                                    'Server error. Please try again later.';
                            } else {
                                errorMessage = response.message || 'Unexpected error occurred.';
                            }
                        } catch (e) {
                            console.error('Error parsing response:', e);
                        }

                        notie.alert({
                            type: 'error',
                            text: errorMessage,
                            time: 10,
                        });
                    }
                });
            });
        });
    </script>
@endsection
