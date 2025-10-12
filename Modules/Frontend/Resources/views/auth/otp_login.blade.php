@extends('frontend::layouts.auth_layout')

@section('content')
<div id="login">

    <div class="vh-100" style="background-image: url('{{ asset("dummy-images/login_banner.jpg") }}')">
        <div class="container">
            <div class="row justify-content-center align-items-center height-self-center vh-100">

                <div class="col-lg-5 col-md-8 col-11 align-self-center">
                    <div class="user-login-card card my-5">
                        <div class="text-center auth-heading">
                            @php
                            $logo=GetSettingValue('dark_logo') ?? asset(setting('dark_logo'));
                            @endphp

                            <img src="{{ $logo }}" class="img-fluid logo h-4 mb-4">

                            <h5>{{ __('frontend.sign_in_title') }}</h5>
                            <p class="fs-14">{{ __('frontend.sign_in_sub_title') }}</p>
                            @if (session()->has('error'))
                            <span class="text-danger">{{ session()->get('error') }}</span>
                            @endif
                        </div>
                        <p class="text-danger" id="otp_error_message"></p>
                        <p class="text-success" id="otp_success_message"></p>
                        <p class="fs-14" id="otp_subtitle"></p>

                        <!-- Mobile Number Form -->
                        <div id="mobile-form">
                            <form id="send-otp-form" class="requires-validation" data-toggle="validator" 
                                action="{{ route('send.otp') }}" novalidate method="post">
                                @csrf

                                <style>
                                    .form-control.is-invalid:focus {
                                        border-color: inherit !important;
                                        box-shadow: none !important;
                                    }
                                </style>

                                <div class="input-group mb-3">
                                    <span class="input-group-text px-0"><i class="ph ph-phone"></i></span>
                                    <input 
                                        type="tel" 
                                        id="mobile" 
                                        name="mobile" 
                                        value="" 
                                        class="form-control"
                                        placeholder="{{ __('frontend.enter_mobile') }}" 
                                        required
                                        oninput="validateMobile();">
                                    <div class="invalid-feedback" id="mobile-error">Mobile number must be exactly 10 digits.</div>
                                </div>

                                <script>
                                function validateMobile() {
                                    const mobileInput = document.getElementById('mobile');
                                    const errorDiv = document.getElementById('mobile-error');
                                    const button = document.getElementById('send-otp-button');

                                    // শুধুমাত্র সংখ্যা রাখবে
                                    mobileInput.value = mobileInput.value.replace(/[^0-9]/g, '');

                                    if (mobileInput.value.length === 10) {
                                        // ঠিক 10 digit হলে valid
                                        errorDiv.style.display = 'none';
                                        mobileInput.classList.remove('is-invalid');
                                        mobileInput.classList.add('is-valid');
                                        button.disabled = false; // button enable
                                    } else {
                                        // 10 digit এর কম বা বেশি হলে invalid
                                        errorDiv.style.display = 'block';
                                        mobileInput.classList.add('is-invalid');
                                        mobileInput.classList.remove('is-valid');
                                        button.disabled = true; // button disable
                                    }
                                }

                                // page load হলে default disable করে রাখি
                                document.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('send-otp-button').disabled = true;
                                });
                                </script>

                                <div id="recaptcha-container" class="d-none"></div>
                                <div class="full-button text-center">
                                    <button type="submit" id="send-otp-button" class="btn btn-primary w-100">
                                        <span id="send-button-text">
                                            <i class="fa-solid fa-paper-plane"></i> {{ __('frontend.send_otp') }}
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>



<script type="text/javascript">
    window.onload = function() {
        render();
    }

    function render() {
        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
            size: 'invisible'
        });
        recaptchaVerifier.render();
    }
    var input = document.querySelector("#mobile");
    var iti = window.intlTelInput(input, {
        initialCountry: "bd", // Automatically detect user's country
        separateDialCode: true, // Show the country code separately
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js" // To handle number formatting
    });

    let timerInterval;
    var number = '';
</script>


@endsection