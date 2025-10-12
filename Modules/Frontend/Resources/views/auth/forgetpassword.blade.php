@extends('frontend::layouts.auth_layout')

@section('content')

    <div>
        <div class="vh-100">
            <div class="container">
                <div class="row justify-content-center align-items-center height-self-center vh-100">
                    <div class="col-lg-5 col-md-12 align-self-center">
                        <div class="user-login-card card my-5">
                               

                            <div class="text-center auth-heading">

                         @php
    $logo = GetSettingValue('dark_logo') ?? asset(setting('dark_logo'));
@endphp

<a href="{{ route('user.login') }}">
    <img src="{{ $logo }}" class="img-fluid logo h-4 mb-4">
</a>


                                <h5>{{__('frontend.forgot_password')}}</h5>
                                <p class="fs-14">{!!__('frontend.email_prompt')!!}</p>
                            </div>

                            <p class="text-danger" id="forgetpassword_error_message"></p>
                            <form   id="forgetpassword-form" class="requires-validation" data-toggle="validator" novalidate>
                
                               <div class="input-group">
                                   <span class="input-group-text px-0"><i class="ph ph-envelope"></i></span>
                                   <input type="email" name="email" class="form-control" placeholder="{{__('frontend.enter_email')}}"  aria-describedby="basic-addon1" required>
                                   <div class="invalid-feedback" id="name-error">Email field is required.</div>
                               </div>
                                <div class="full-button text-center">
                                    <button type="submit" class="btn btn-primary w-100" id="forget_password_btn">
                                        {{__('frontend.continue')}}
                                    </button>
                                </div>
                                <div class="border p-4 rounded mt-5 d-none" id="forget_password_msg">
                                    <h6>{{__('frontend.link_sent_to_email')}}!</h6>
                                    <small class="mb-0">{{__('frontend.check_inbox')}}.</small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="{{ asset('js/auth.min.js') }}" defer></script>


@endsection
