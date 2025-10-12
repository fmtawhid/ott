@extends('setting::backend.setting.index')

@section('settings-content')
    <div class="container">
        <div class="mb-4">
            <h4><i class="fa-solid fa-coins"></i> {{ __('setting_sidebar.lbl_payment') }} </h4>
        </div>


        <form method="POST" action="{{ route('backend.setting.store') }}" id="payment-settings-form">
            @csrf

            {{-- cash --}}
            {{-- <div class="form-group border-bottom pb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label m-0" for="payment_method_cash">{{ __('Cash') }}</label>
                    <input type="hidden" value="0" name="cash_payment_method">
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input toggle-input" data-toggle-target="#cash-fields" value="1"
                            name="cash_payment_method" id="payment_method_cash" type="checkbox"
                            {{ old('cash_payment_method', $settings['cash_payment_method'] ?? 0) == 1 ? 'checked' : '' }} />
                    </div>
                </div>
            </div>
            <div id="cash-fields"
                class="{{ old('cash_payment_method', $settings['cash_payment_method'] ?? 0) == 1 ? '' : 'd-none' }}">
                <div class="row">

                </div>
            </div> --}}

            {{-- Razorpay --}}
            <div class="form-group border-bottom pb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label m-0" for="payment_method_razorpay">{{ __('setting_payment_method.lbl_razorpay') }}</label>
                    <input type="hidden" value="0" name="razor_payment_method">
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input toggle-input" data-toggle-target="#razorpay-fields" value="1"
                            name="razor_payment_method" id="payment_method_razorpay" type="checkbox"
                            {{ old('razor_payment_method', $settings['razor_payment_method'] ?? 0) == 1 ? 'checked' : '' }} />
                    </div>
                </div>
            </div>
            <div id="razorpay-fields"
                class="ps-3 {{ old('razor_payment_method', $settings['razor_payment_method'] ?? 0) == 1 ? '' : 'd-none' }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="razorpay_secretkey">{{ __('setting_payment_method.lbl_secret_key') }}</label>
                            <input type="text" class="form-control @error('razorpay_secretkey') is-invalid @enderror"
                                name="razorpay_secretkey" id="razorpay_secretkey"
                                value="{{ old('razorpay_secretkey', $settings['razorpay_secretkey'] ?? '') }}">
                            @error('razorpay_secretkey')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="razorpay_publickey">{{ __('setting_payment_method.lbl_app_key') }}</label>
                            <input type="text" class="form-control @error('razorpay_publickey') is-invalid @enderror"
                                name="razorpay_publickey" id="razorpay_publickey"
                                value="{{ old('razorpay_publickey', $settings['razorpay_publickey'] ?? '') }}">
                            @error('razorpay_publickey')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stripe --}}
            <div class="form-group border-bottom pb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label m-0" for="payment_method_stripe">{{ __('setting_payment_method.lbl_stripe') }}</label>
                    <input type="hidden" value="0" name="str_payment_method">
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input toggle-input" data-toggle-target="#stripe-fields" value="1"
                            name="str_payment_method" id="payment_method_stripe" type="checkbox"
                            {{ old('str_payment_method', $settings['str_payment_method'] ?? 0) == 1 ? 'checked' : '' }} />
                    </div>
                </div>
            </div>
            <div id="stripe-fields"
                class="ps-3 {{ old('str_payment_method', $settings['str_payment_method'] ?? 0) == 1 ? '' : 'd-none' }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="stripe_secretkey">{{ __('setting_payment_method.lbl_secret_key') }}</label>
                            <input type="text" class="form-control @error('stripe_secretkey') is-invalid @enderror"
                                name="stripe_secretkey" id="stripe_secretkey"
                                value="{{ old('stripe_secretkey', $settings['stripe_secretkey'] ?? '') }}">
                            @error('stripe_secretkey')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="stripe_publickey">{{ __('setting_payment_method.lbl_app_key') }}</label>
                            <input type="text" class="form-control @error('stripe_publickey') is-invalid @enderror"
                                name="stripe_publickey" id="stripe_publickey"
                                value="{{ old('stripe_publickey', $settings['stripe_publickey'] ?? '') }}">
                            @error('stripe_publickey')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Paystack --}}
            <div class="form-group border-bottom pb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label m-0" for="payment_method_paystack">{{ __('setting_payment_method.lbl_paystack') }}</label>
                    <input type="hidden" value="0" name="paystack_payment_method">
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input toggle-input" data-toggle-target="#paystack-fields" value="1"
                            name="paystack_payment_method" id="payment_method_paystack" type="checkbox"
                            {{ old('paystack_payment_method', $settings['paystack_payment_method'] ?? 0) == 1 ? 'checked' : '' }} />
                    </div>
                </div>
            </div>
            <div id="paystack-fields"
                class="ps-3 {{ old('paystack_payment_method', $settings['paystack_payment_method'] ?? 0) == 1 ? '' : 'd-none' }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="paystack_secretkey">{{ __('setting_payment_method.lbl_secret_key') }}</label>
                            <input type="text" class="form-control @error('paystack_secretkey') is-invalid @enderror"
                                name="paystack_secretkey" id="paystack_secretkey"
                                value="{{ old('paystack_secretkey', $settings['paystack_secretkey'] ?? '') }}">
                            @error('paystack_secretkey')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="paystack_publickey">{{ __('setting_payment_method.lbl_app_key') }}</label>
                            <input type="text" class="form-control @error('paystack_publickey') is-invalid @enderror"
                                name="paystack_publickey" id="paystack_publickey"
                                value="{{ old('paystack_publickey', $settings['paystack_publickey'] ?? '') }}">
                            @error('paystack_publickey')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- PayPal --}}
            <div class="form-group border-bottom pb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label m-0" for="payment_method_paypal">{{ __('setting_payment_method.lbl_paypal') }}</label>
                    <input type="hidden" value="0" name="paypal_payment_method">
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input toggle-input" data-toggle-target="#paypal-fields" value="1"
                            name="paypal_payment_method" id="payment_method_paypal" type="checkbox"
                            {{ old('paypal_payment_method', $settings['paypal_payment_method'] ?? 0) == 1 ? 'checked' : '' }} />
                    </div>
                </div>
            </div>
            <div id="paypal-fields"
                class="ps-3 {{ old('paypal_payment_method', $settings['paypal_payment_method'] ?? 0) == 1 ? '' : 'd-none' }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="paypal_secretkey">{{ __('setting_payment_method.lbl_secret_key') }}</label>
                            <input type="text" class="form-control @error('paypal_secretkey') is-invalid @enderror"
                                name="paypal_secretkey" id="paypal_secretkey"
                                value="{{ old('paypal_secretkey', $settings['paypal_secretkey'] ?? '') }}">
                            @error('paypal_secretkey')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="paypal_clientid">{{ __('setting_payment_method.lbl_client_id') }}</label>
                            <input type="text" class="form-control @error('paypal_clientid') is-invalid @enderror"
                                name="paypal_clientid" id="paypal_clientid"
                                value="{{ old('paypal_clientid', $settings['paypal_clientid'] ?? '') }}">
                            @error('paypal_clientid')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Flutterwave --}}
            <div class="form-group border-bottom pb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label m-0" for="payment_method_flutterwave">{{ __('setting_payment_method.lbl_flutterwave') }}</label>
                    <input type="hidden" value="0" name="flutterwave_payment_method">
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input toggle-input" data-toggle-target="#flutterwave-fields"
                            value="1" name="flutterwave_payment_method" id="payment_method_flutterwave"
                            type="checkbox"
                            {{ old('flutterwave_payment_method', $settings['flutterwave_payment_method'] ?? 0) == 1 ? 'checked' : '' }} />
                    </div>
                </div>
            </div>
            <div id="flutterwave-fields"
                class="ps-3 {{ old('flutterwave_payment_method', $settings['flutterwave_payment_method'] ?? 0) == 1 ? '' : 'd-none' }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="flutterwave_secretkey">{{ __('setting_payment_method.lbl_secret_key') }}</label>
                            <input type="text"
                                class="form-control @error('flutterwave_secretkey') is-invalid @enderror"
                                name="flutterwave_secretkey" id="flutterwave_secretkey"
                                value="{{ old('flutterwave_secretkey', $settings['flutterwave_secretkey'] ?? '') }}">
                            @error('flutterwave_secretkey')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="flutterwave_publickey">{{ __('setting_payment_method.lbl_app_key') }}</label>
                            <input type="text" class="form-control @error('flutterwave_publickey') is-invalid @enderror"
                                name="flutterwave_publickey" id="flutterwave_publickey"
                                value="{{ old('flutterwave_publickey', $settings['flutterwave_publickey'] ?? '') }}">
                            @error('flutterwave_publickey')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cinet --}}
            <div class="form-group border-bottom pb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label m-0" for="payment_method_cinet">{{ __('messages.lbl_cinet') }}</label>
                    <input type="hidden" value="0" name="cinet_payment_method">
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input toggle-input" data-toggle-target="#cinet-fields" value="1"
                            name="cinet_payment_method" id="payment_method_cinet" type="checkbox"
                            {{ old('cinet_payment_method', $settings['cinet_payment_method'] ?? 0) == 1 ? 'checked' : '' }} />
                    </div>
                </div>
            </div>
            <div id="cinet-fields"
                class="ps-3 {{ old('cinet_payment_method', $settings['cinet_payment_method'] ?? 0) == 1 ? '' : 'd-none' }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="cinet_siteid">{{ __('messages.site_id') }}</label>
                            <input type="text" class="form-control @error('cinet_siteid') is-invalid @enderror"
                                name="cinet_siteid" id="cinet_siteid"
                                value="{{ old('cinet_siteid', $settings['cinet_siteid'] ?? '') }}">
                            @error('cinet_siteid')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="cinet_api_key">{{ __('messages.api_key') }}</label>
                            <input type="text" class="form-control @error('cinet_api_key') is-invalid @enderror"
                                name="cinet_api_key" id="cinet_api_key"
                                value="{{ old('cinet_api_key', $settings['cinet_api_key'] ?? '') }}">
                            @error('cinet_api_key')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="cinet_Secret_key">{{ __('setting_payment_method.lbl_secret_key') }}</label>
                            <input type="text" class="form-control @error('cinet_Secret_key') is-invalid @enderror"
                                name="cinet_Secret_key" id="cinet_Secret_key"
                                value="{{ old('cinet_Secret_key', $settings['cinet_Secret_key'] ?? '') }}">
                            @error('cinet_Secret_key')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sadad --}}
            <div class="form-group border-bottom pb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label m-0" for="payment_method_sadad">{{ __('messages.sadad') }}</label>
                    <input type="hidden" value="0" name="sadad_payment_method">
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input toggle-input" data-toggle-target="#sadad-fields" value="1"
                            name="sadad_payment_method" id="payment_method_sadad" type="checkbox"
                            {{ old('sadad_payment_method', $settings['sadad_payment_method'] ?? 0) == 1 ? 'checked' : '' }} />
                    </div>
                </div>
            </div>
            <div id="sadad-fields"
                class="ps-3 {{ old('sadad_payment_method', $settings['sadad_payment_method'] ?? 0) == 1 ? '' : 'd-none' }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="sadad_Sadadkey">{{ __('messages.sadad') }} {{ __('messages.key') }}</label>
                            <input type="text" class="form-control @error('sadad_Sadadkey') is-invalid @enderror"
                                name="sadad_Sadadkey" id="sadad_Sadadkey"
                                value="{{ old('sadad_Sadadkey', $settings['sadad_Sadadkey'] ?? '') }}">
                            @error('sadad_Sadadkey')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="sadad_id_key">{{ __('messages.id') }} {{ __('messages.key') }}</label>
                            <input type="text" class="form-control @error('sadad_id_key') is-invalid @enderror"
                                name="sadad_id_key" id="sadad_id_key"
                                value="{{ old('sadad_id_key', $settings['sadad_id_key'] ?? '') }}">
                            @error('sadad_id_key')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="sadad_Domain">{{ __('messages.domain') }} {{ __('messages.key') }}</label>
                            <input type="text" class="form-control @error('sadad_Domain') is-invalid @enderror"
                                name="sadad_Domain" id="sadad_Domain"
                                value="{{ old('sadad_Domain', $settings['sadad_Domain'] ?? '') }}">
                            @error('sadad_Domain')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Airtel Money --}}
            <div class="form-group border-bottom pb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label m-0" for="payment_method_airtel_money">{{ __('messages.lbl_airtel_money') }}</label>
                    <input type="hidden" value="0" name="airtel_payment_method">
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input toggle-input" data-toggle-target="#airtel-money-fields"
                            value="1" name="airtel_payment_method" id="payment_method_airtel_money" type="checkbox"
                            {{ old('airtel_payment_method', $settings['airtel_payment_method'] ?? 0) == 1 ? 'checked' : '' }} />
                    </div>
                </div>
            </div>
            <div id="airtel-money-fields"
                class="ps-3 {{ old('airtel_payment_method', $settings['airtel_payment_method'] ?? 0) == 1 ? '' : 'd-none' }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="airtel_money_secretkey">{{ __('setting_payment_method.lbl_secret_key') }}</label>
                            <input type="text"
                                class="form-control @error('airtel_money_secretkey') is-invalid @enderror"
                                name="airtel_money_secretkey" id="airtel_money_secretkey"
                                value="{{ old('airtel_money_secretkey', $settings['airtel_money_secretkey'] ?? '') }}">
                            @error('airtel_money_secretkey')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="airtel_money_client_id">{{ __('setting_payment_method.lbl_client_id') }}</label>
                            <input type="text"
                                class="form-control @error('airtel_money_client_id') is-invalid @enderror"
                                name="airtel_money_client_id" id="airtel_money_client_id"
                                value="{{ old('airtel_money_client_id', $settings['airtel_money_client_id'] ?? '') }}">
                            @error('airtel_money_client_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- PhonePe --}}
            <div class="form-group border-bottom pb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label m-0" for="payment_method_phonepe">{{ __('messages.lbl_phonepe') }}</label>
                    <input type="hidden" value="0" name="phonepe_payment_method">
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input toggle-input" data-toggle-target="#phonepe-fields" value="1"
                            name="phonepe_payment_method" id="payment_method_phonepe" type="checkbox"
                            {{ old('phonepe_payment_method', $settings['phonepe_payment_method'] ?? 0) == 1 ? 'checked' : '' }} />
                    </div>
                </div>
            </div>
            <div id="phonepe-fields"
                class="ps-3 {{ old('phonepe_payment_method', $settings['phonepe_payment_method'] ?? 0) == 1 ? '' : 'd-none' }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="phonepe_App_id">{{ __('setting_mobile_page.lbl_app_id') }}</label>
                            <input type="text" class="form-control @error('phonepe_App_id') is-invalid @enderror"
                                name="phonepe_App_id" id="phonepe_App_id"
                                value="{{ old('phonepe_App_id', $settings['phonepe_App_id'] ?? '') }}">
                            @error('phonepe_App_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="phonepe_salt_key">{{ __('messages.merchant') }}</label>
                            <input type="text" class="form-control @error('phonepe_Merchant_id') is-invalid @enderror"
                                name="phonepe_Merchant_id" id="phonepe_Merchant_id"
                                value="{{ old('phonepe_Merchant_id', $settings['phonepe_Merchant_id'] ?? '') }}">
                            @error('phonepe_Merchant_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="phonepe_salt_key">{{ __('messages.salt') }}</label>
                            <input type="text" class="form-control @error('phonepe_salt_key') is-invalid @enderror"
                                name="phonepe_salt_key" id="phonepe_salt_key"
                                value="{{ old('phonepe_salt_key', $settings['phonepe_salt_key'] ?? '') }}">
                            @error('phonepe_salt_key')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="phonepe_salt_index">{{ __('messages.salt_index') }}</label>
                            <input type="text" class="form-control @error('phonepe_salt_index') is-invalid @enderror"
                                name="phonepe_salt_index" id="phonepe_salt_index"
                                value="{{ old('phonepe_salt_index', $settings['phonepe_salt_index'] ?? '') }}">
                            @error('phonepe_salt_index')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            {{-- Midtrans --}}
            <div class="form-group border-bottom pb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label m-0" for="payment_method_midtrans">{{ __('messages.midtrans') }}</label>
                    <input type="hidden" value="0" name="midtrans_payment_method">
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input toggle-input" data-toggle-target="#midtrans-fields" value="1"
                            name="midtrans_payment_method" id="payment_method_midtrans" type="checkbox"
                            {{ old('midtrans_payment_method', $settings['midtrans_payment_method'] ?? 0) == 1 ? 'checked' : '' }} />
                    </div>
                </div>
            </div>
            <div id="midtrans-fields"
                class="ps-3 {{ old('midtrans_payment_method', $settings['midtrans_payment_method'] ?? 0) == 1 ? '' : 'd-none' }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="midtrans_client_id">{{ __('setting_payment_method.lbl_app_key') }}</label>
                            <input type="text" class="form-control @error('midtrans_client_id') is-invalid @enderror"
                                name="midtrans_client_id" id="midtrans_client_id"
                                value="{{ old('midtrans_client_id', $settings['midtrans_client_id'] ?? '') }}">
                            @error('midtrans_client_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="midtrans_server_key">{{ __('setting_payment_method.lbl_server_key') }}</label>
                            <input type="text" class="form-control @error('midtrans_server_key') is-invalid @enderror"
                                name="midtrans_server_key" id="midtrans_server_key"
                                value="{{ old('midtrans_server_key', $settings['midtrans_server_key'] ?? '') }}">
                            @error('midtrans_server_key')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- In App Purchase --}}
            <div class="form-group border-bottom pb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label m-0" for="payment_method_iap">{{ __('messages.in_app_purchase') }}</label>
                    <input type="hidden" value="0" name="iap_payment_method">
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input toggle-input" data-toggle-target="#iap-fields" value="1"
                            name="iap_payment_method" id="payment_method_iap" type="checkbox"
                            {{ old('iap_payment_method', $settings['iap_payment_method'] ?? 0) == 1 ? 'checked' : '' }} />
                    </div>
                </div>
            </div>
            <div id="iap-fields"
                class="ps-3 {{ old('iap_payment_method', $settings['iap_payment_method'] ?? 0) == 1 ? '' : 'd-none' }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="entertainment_id">{{ __('messages.lbl_entitlement_id') }}</label>
                            <input type="text" class="form-control @error('entertainment_id') is-invalid @enderror"
                                name="entertainment_id" id="entertainment_id"
                                value="{{ old('entertainment_id', $settings['entertainment_id'] ?? '') }}">
                            @error('entertainment_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="apple_api_key">{{ __('messages.lbl_apple_api_key') }}</label>
                            <input type="text" class="form-control @error('apple_api_key') is-invalid @enderror"
                                name="apple_api_key" id="apple_api_key"
                                value="{{ old('apple_api_key', $settings['apple_api_key'] ?? '') }}">
                            @error('apple_api_key')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="google_api_key">{{ __('messages.lbl_google_api_key') }}</label>
                            <input type="text" class="form-control @error('google_api_key') is-invalid @enderror"
                                name="google_api_key" id="google_api_key"
                                value="{{ old('google_api_key', $settings['google_api_key'] ?? '') }}">
                            @error('google_api_key')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-end">
            <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
            </div>
        </form>
    </div>
@endsection
@push('after-scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-input').forEach(function(toggle) {
                toggle.addEventListener('change', function() {
                    var target = document.querySelector(toggle.getAttribute('data-toggle-target'));
                    if (toggle.checked) {
                        target.classList.remove('d-none');
                        target.querySelectorAll('input').forEach(function(input) {
                            input.disabled = false;
                        });
                    } else {
                        target.classList.add('d-none');
                        target.querySelectorAll('input').forEach(function(input) {
                            input.disabled = true;
                        });
                    }
                });
            });

            // Disable fields if their toggle is not checked on page load
            document.querySelectorAll('.toggle-input').forEach(function(toggle) {
                var target = document.querySelector(toggle.getAttribute('data-toggle-target'));
                if (!toggle.checked) {
                    target.querySelectorAll('input').forEach(function(input) {
                        input.disabled = true;
                    });
                }
            });

            // Enable fields on form submission if they are visible
            document.getElementById('payment-settings-form').addEventListener('submit', function() {
                document.querySelectorAll('.toggle-input').forEach(function(toggle) {
                    var target = document.querySelector(toggle.getAttribute('data-toggle-target'));
                    if (toggle.checked) {
                        target.querySelectorAll('input').forEach(function(input) {
                            input.disabled = false;
                        });
                    }
                });
            });
        });
    </script>
@endpush
