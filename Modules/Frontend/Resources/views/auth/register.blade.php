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

                        <div >
                            <form action="{{ route('auth.otp-login-store') }}" method="post"
                                class="requires-validation" data-toggle="validator" novalidate>
                                @csrf
                                <div class="input-group mb-3">
                                    <span class="input-group-text px-0"><i class="ph ph-phone"></i></span>
                                    <input type="text" name="mobile" id="mobile_number" class="form-control"
                                        placeholder="{{ __('frontend.enter_mobile') }}"
                                        aria-describedby="basic-addon1" value="{{ session('mobile') ?? '' }}" required readonly>
                                    <div class="invalid-feedback" id="mobile-error">Mobile number field is required.
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text px-0"><i class="ph ph-user"></i></span>
                                    <input type="text" name="first_name" class="form-control"
                                        placeholder="{{ __('frontend.enter_fname') }}" required>
                                    <div class="invalid-feedback" id="first_name_error">First Name field is required
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text px-0"><i class="ph ph-user"></i></span>
                                    <input type="text" name="last_name" class="form-control"
                                        placeholder="{{ __('frontend.enter_lname') }}" required>
                                    <div class="invalid-feedback" id="last_name_error">Last Name field is required
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text px-0"><i class="ph ph-envelope"></i></span>
                                    <input type="text" name="email" class="form-control"
                                        placeholder="{{ __('frontend.enter_email') }}" required>
                                    <div class="invalid-feedback" id="email_error">Email field is required</div>
                                </div>
                                <!-- 🔹 Password -->
                                <div class="input-group mb-3">
                                    <span class="input-group-text px-0"><i class="ph ph-lock"></i></span>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="{{ __('frontend.password') }}" required minlength="6">
                                    <div class="invalid-feedback" id="password_error">Password must be at least 6 characters.</div>
                                </div>

                                <!-- 🔹 Confirm Password -->
                                <div class="input-group mb-3">
                                    <span class="input-group-text px-0"><i class="ph ph-lock"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                        class="form-control" placeholder="{{ __('frontend.confirm_password') }}" required>
                                    <div class="invalid-feedback" id="password_confirmation_error">Passwords do not match.</div>
                                </div>

                                <div class="full-button text-center">
                                    <button type="submit" id="register-button" class="btn btn-primary w-100"
                                        data-signup-text="{{ __('frontend.sign_up') }}">
                                        {{ __('frontend.sign_up') }}
                                    </button>
                                </div>
                            </form>
                            <script>
                            document.getElementById('register-button').addEventListener('click', function(e) {
                                const pass = document.getElementById('password').value;
                                const confirm = document.getElementById('password_confirmation').value;

                                if (pass !== confirm) {
                                    e.preventDefault();
                                    document.getElementById('password_confirmation').classList.add('is-invalid');
                                }
                            });
                            </script>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection