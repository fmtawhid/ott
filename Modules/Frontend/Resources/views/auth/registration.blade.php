@extends('frontend::layouts.auth_layout')

@section('content')
    <div id="login">
        <div class="vh-100"
            style="background: url('{{ asset('img/img-web/authbg.png') }}'); background-size: cover; background-repeat: no-repeat; position: relative; min-height: 500px;">
            <div class="container">
                <div class="row justify-content-center align-items-center height-self-center vh-100">
                    <div class="col-lg-5 col-md-8 col-11 align-self-center">
                        <div class="user-login-card card my-5">
                            <div class="text-center auth-heading">

                                 <div class="text-center auth-heading">
                               @php
    $logo = GetSettingValue('dark_logo') ?? asset(setting('dark_logo'));
@endphp

<a href="{{ route('user.login') }}">
    <img src="{{ $logo }}" class="img-fluid logo h-4 mb-4">
</a>


                                <h5>{{ __('frontend.sign_up_title') }}</h5>
                                <p class="font-size-14">{{ __('frontend.sign_sub_title') }}</p>
                            </div>
                            <p class="text-danger" id="error_message"></p>
                            <form id="registerForm" action="post" class="requires-validation" data-toggle="validator"
                                novalidate>

                                <div class="input-group mb-3">
                                    <span class="input-group-text px-0"><i class="ph ph-user"></i></span>
                                    <input type="text" name="first_name" class="form-control"
                                        placeholder="{{ __('frontend.first_name') }}" required>
                                    <div class="invalid-feedback" id="first_name_error">First Name field is required</div>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text px-0"><i class="ph ph-user"></i></span>
                                    <input type="text" name="last_name" class="form-control"
                                        placeholder="{{ __('frontend.last_name') }}" required>
                                    <div class="invalid-feedback" id="last_name_error">Last Name field is required</div>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text px-0"><i class="ph ph-envelope"></i></span>
                                    <input type="text" name="email" class="form-control"
                                        placeholder="{{ __('frontend.email') }}" required>
                                    <div class="invalid-feedback" id="email_error">Email field is required</div>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text px-0"><i class="ph ph-lock-key"></i></span>

                                    <input type="password" name="password" class="form-control" id="password"
                                        placeholder="{{ __('frontend.password') }}" required>

                                    <span class="input-group-text px-0" style="cursor:pointer;">
                                        <i class="ph ph-eye" id="togglePassword"></i> <!-- Eye icon with unique ID -->
                                    </span>

                                    <div class="invalid-feedback" id="password_error">Password field is required</div>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text px-0"><i class="ph ph-lock-key"></i></span>
                                    <input type="password" name="confirm_password" class="form-control"
                                        id="confirm_password" placeholder="{{ __('frontend.confirm_password') }}" required>
                                    <span class="input-group-text px-0"><i class="ph ph-eye"
                                            id="toggleConfirmPassword"></i></span>
                                    <div class="invalid-feedback" id="confirm_password_error">Confirm Password field is
                                        required</div>
                                </div>
                                <div class="full-button text-center">
                                    <button type="submit" id="register-button" class="btn btn-primary w-100"
                                        data-signup-text="{{ __('frontend.sign_up') }}">
                                        {{ __('frontend.sign_up') }}
                                    </button>
                                    <p class="mt-2 mb-0 fw-normal"> {{ __('frontend.already_have_account') }} <a
                                            href="{{ route('login') }}" class="ms-1">{{ __('frontend.signin') }}</a></p>
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
                const toggleIcon = document.getElementById('togglePassword');

                if (passwordInput && toggleIcon) {
                    // Detach any previous event and re-bind every time
                    const newIcon = toggleIcon.cloneNode(true);
                    toggleIcon.parentNode.replaceChild(newIcon, toggleIcon);

                    newIcon.addEventListener('click', function() {
                        const isHidden = passwordInput.type === 'password';
                        passwordInput.type = isHidden ? 'text' : 'password';

                        newIcon.classList.remove(isHidden ? 'ph-eye' : 'ph-eye-slash');
                        newIcon.classList.add(isHidden ? 'ph-eye-slash' : 'ph-eye');
                    });
                }
            }, 500); // Adjust delay as needed
        });
    </script>
@endsection
