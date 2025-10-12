@extends('frontend::layouts.auth_layout')

@section('content')
    <div id="login">

        <div class="vh-100"
            style="background: url('../img/web-img/authbg.png'); background-size: cover; background-repeat: no-repeat; position: relative;min-height:500px">
            <div class="container">
                <div class="row justify-content-center align-items-center height-self-center vh-100">
                    <div class="col-lg-5 col-md-8 col-11 align-self-center">
                        <div class="user-login-card card my-5">
                            {{-- <!-- <div class="text-center auth-heading">
                                                    <h5>{{ __('frontend.sign_in_title') }}</h5>
                                                    <p class="fs-14">{{ __('frontend.sign_in_sub_title') }}</p>
                                                    @if (session()->has('error'))
                                                    <span class="text-danger">{{ session()->get('error') }}</span>
                                                    @endif
                                                    </div> --> --}}

                            <div class="text-center auth-heading">
                                @php
                                    $logo = GetSettingValue('dark_logo') ?? asset(setting('dark_logo'));
                                @endphp

                                <img src="{{ $logo }}" class="img-fluid logo h-4 mb-4">
                                  {{-- @dd(setting('app_name')); --}}
                                    <h5>{{ __('frontend.sign_in_title') }} {{ app_name() }}!</h5>
                                <p class="fs-14">{{ __('frontend.sign_in_sub_title') }}</p>
                                @if (session()->has('error'))
                                    <span class="text-danger">{{ session()->get('error') }}</span>
                                @endif
                            </div>

                            <p class="text-danger" id="login_error_message"></p>
                            <form action="post" id="login-form" class="requires-validation" data-toggle="validator"
                                novalidate>
                                <div class="input-group">
                                    <span class="input-group-text px-0"><i class="ph ph-envelope"></i></span>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="{{ __('frontend.enter_email') }}" aria-describedby="basic-addon1"
                                        required>
                                    <div class="invalid-feedback" id="name-error">Email field is required.</div>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text px-0"><i class="ph ph-lock-key"></i></span>
                                    <input type="password" name="password" class="form-control" id="password"
                                        placeholder="Enter password" required>

                                    <span class="input-group-text px-0" id="togglePassword" style="cursor:pointer;">
                                        <i class="ph ph-eye-slash" id="toggleIcon"></i>
                                    </span>

                                    <div class="invalid-feedback" id="password-error">Password field is required.</div>
                                </div>
                                <div class="d-flex flex-wrap align-items-center justify-content-between">
                                    <label class="list-group-item d-flex align-items-center"><input
                                            class="form-check-input m-0 me-2"
                                            type="checkbox">{{ __('frontend.remember_me') }}</label>
                                    <a href="{{ url('/forget-password') }}">{{ __('frontend.forgot_password') }}</a>
                                </div>
                                <div class="full-button text-center">
                                    <button type="submit" id="login-button" class="btn btn-primary w-100">
                                        {{ __('frontend.sign_in') }}
                                    </button>
                                    <p class="mt-2 mb-0 fw-normal">{{ __('frontend.not_have_account') }}<a
                                            href="{{ route('register-page') }}"
                                            class="ms-1">{{ __('frontend.sign_up') }}</a></p>
                                </div>

                                <div class="border-style">
                                    <span>Or</span>
                                </div>

                                <div class="full-button text-center">
                                    @if (setting('is_google_login') == 1)
                                        <a href="{{ route('auth.google') }}" class="d-block">
                                            <span id="google-login" class="btn btn-dark w-100">
                                                <svg class="me-2" width="16" height="16" viewBox="0 0 16 16"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M3.4473 8.00005C3.4473 7.48042 3.5336 6.98224 3.68764 6.51496L0.991451 4.45605C0.465978 5.52296 0.169922 6.72515 0.169922 8.00005C0.169922 9.27387 0.465614 10.4753 0.990358 11.5415L3.68509 9.4786C3.53251 9.01351 3.4473 8.51715 3.4473 8.00005Z"
                                                        fill="#FBBC05" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M8.18202 3.27273C9.3109 3.27273 10.3305 3.67273 11.1317 4.32727L13.4622 2C12.042 0.763636 10.2213 0 8.18202 0C5.01608 0 2.29513 1.81055 0.992188 4.456L3.68838 6.51491C4.30962 4.62909 6.0805 3.27273 8.18202 3.27273Z"
                                                        fill="#EB4335" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M8.18202 12.7275C6.0805 12.7275 4.30962 11.3712 3.68838 9.48535L0.992188 11.5439C2.29513 14.1897 5.01608 16.0003 8.18202 16.0003C10.1361 16.0003 12.0016 15.3064 13.4018 14.0064L10.8425 12.0279C10.1204 12.4828 9.21112 12.7275 8.18202 12.7275Z"
                                                        fill="#34A853" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M15.8289 7.99996C15.8289 7.52723 15.756 7.01814 15.6468 6.54541H8.18164V9.63632H12.4786C12.2638 10.6901 11.679 11.5003 10.8421 12.0276L13.4014 14.0061C14.8722 12.641 15.8289 10.6076 15.8289 7.99996Z"
                                                        fill="#4285F4" />
                                                </svg>
                                                {{ __('frontend.continue_with_google') }}
                                            </span>
                                        </a>
                                    @endif
                                    @if (setting('is_otp_login') == 1)
                                        <a href="{{ route('otp-login') }}" class="d-block mt-3">
                                            <span id="otp-login" class="btn btn-dark w-100">
                                                {{ __('frontend.login_with_otp') }}
                                            </span>
                                        </a>
                                    @endif
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/auth.min.js') }}" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setInterval(() => {
                const passwordInput = document.getElementById('password');
                const toggleSpan = document.getElementById('togglePassword');
                const toggleIcon = document.getElementById('toggleIcon');

                if (passwordInput && toggleSpan && toggleIcon) {
                    // Replace existing toggle span to remove any previous event handlers
                    const newToggleSpan = toggleSpan.cloneNode(true);
                    toggleSpan.parentNode.replaceChild(newToggleSpan, toggleSpan);

                    newToggleSpan.addEventListener('click', function() {
                        const isHidden = passwordInput.type === 'password';
                        passwordInput.type = isHidden ? 'text' : 'password';

                        const icon = newToggleSpan.querySelector('i');
                        if (icon) {
                            icon.classList.remove(isHidden ? 'ph-eye-slash' : 'ph-eye');
                            icon.classList.add(isHidden ? 'ph-eye' : 'ph-eye-slash');
                        }
                    });
                }
            }, 500); // Adjust time if needed
        });
    </script>
@endsection
