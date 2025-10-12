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
                            $logo = GetSettingValue('dark_logo') ?? asset(setting('dark_logo'));
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

                        <!-- <div id="otp-form">
                            <form id="verify-otp-form" class="requires-validation" data-toggle="validator" novalidate
                                  method="POST" action="{{ route('verify.otp') }}">
                                @csrf

                                
                                <input type="hidden" name="mobile" value="{{ session('mobile') }}">

                                <div class="input-group mb-3">
                                    <span class="input-group-text px-0"><i class="ph ph-lock-key"></i></span>
                                    <input type="text" name="otp" class="form-control"
                                           placeholder="{{ __('frontend.enter_otp') }}"
                                           id="otp" required>
                                    <div class="invalid-feedback" id="otp-error">OTP field is required.</div>
                                </div>

                                <div id="otp-timer" style="color: red; display: none;">
                                    You can resend the OTP in <span id="timer"></span> seconds.
                                </div>

                                <div class="full-button text-center">
                                    <button type="submit" id="verify-otp-button" class="btn btn-primary w-100">
                                        <span id="button-text">
                                            <i class="fa-solid fa-floppy-disk"></i> {{ __('frontend.verify_otp') }}
                                        </span>
                                        <span id="button-spinner" class="d-none">
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                  aria-hidden="true"></span>
                                            Loading...
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div> -->
                        <div id="otp-form">
    <form id="verify-otp-form" class="requires-validation" data-toggle="validator" novalidate
          method="POST" action="{{ route('verify.otp') }}">
        @csrf

        <!-- Hidden mobile input -->
        <input type="hidden" name="mobile" value="{{ session('mobile') }}">

        <div class="input-group mb-3">
            <span class="input-group-text px-0"><i class="ph ph-lock-key"></i></span>
            <input type="text" name="otp" class="form-control"
                   placeholder="{{ __('frontend.enter_otp') }}"
                   id="otp" required>
            <div class="invalid-feedback" id="otp-error">OTP field is required.</div>
        </div>

        <div id="otp-timer" style="color: red;">
            You must verify within <span id="timer">60</span> seconds.
        </div>

        <!-- Return Button (hidden initially) -->
        <div id="return-back-container" class="text-center mt-3" style="display: none;">
            <button type="button" id="return-back-button" class="btn btn-warning">
                Are you sure you want to return back?
            </button>
        </div>

        <div class="full-button text-center mt-3">
            <button type="submit" id="verify-otp-button" class="btn btn-primary w-100">
                <span id="button-text">
                    <i class="fa-solid fa-floppy-disk"></i> {{ __('frontend.verify_otp') }}
                </span>
                <span id="button-spinner" class="d-none">
                    <span class="spinner-border spinner-border-sm" role="status"
                          aria-hidden="true"></span>
                    Loading...
                </span>
            </button>
        </div>
    </form>
</div>

<script>
    let timeLeft = 60; // 1 minute
    const timerDisplay = document.getElementById('timer');
    const verifyButton = document.getElementById('verify-otp-button');
    const returnContainer = document.getElementById('return-back-container');
    const returnButton = document.getElementById('return-back-button');

    const countdown = setInterval(() => {
        timeLeft--;
        timerDisplay.textContent = timeLeft;

        if (timeLeft <= 0) {
            clearInterval(countdown);

            // Disable OTP submit button
            verifyButton.disabled = true;

            // Show return back button
            returnContainer.style.display = 'block';
        }
    }, 1000);

    // Return button click redirect
    returnButton.addEventListener('click', function() {
        window.location.href = "{{ url('/login') }}"; // redirect back
    });
</script>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
