@extends('frontend::layouts.master')
@section('content')
<div class="page-title">
    <h4 class="m-0 text-center">{{__('frontend.pin_settings')}}</h4>
</div>
        <div class="section-spacing-bottom ">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <ul class="nav nav-tabs flex-column gap-4">
                            @if(getCurrentProfileSession('is_child_profile') == 0)
                            <li class="nav-item">
                                <a class="nav-link active p-3 text-center" data-bs-toggle="pill" href="#changePin">
                                    @if(!empty(auth()->user()->pin))
                                    <h6 class="m-0">{{__('frontend.change_pins')}}</h6>
                                    @endif

                                    @if(empty(auth()->user()->pin))
                                    <h6 class="m-0">{{ __('frontend.set_pin') }}</h6>
                                    @endif
                                </a>
                            </li>
                            @endif

                            @if(getCurrentProfileSession('is_child_profile') == 1)
                            <li class="nav-item">
                                <a class="nav-link active p-3 text-center" data-bs-toggle="pill" href="#changeParentPin">
    <h6 class="m-0">{{ __('frontend.change_pins') }}</h6>
</a>

                            </li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-lg-9 mt-lg-0 mt-5">
                        <div class="tab-content">
                            @if(empty(auth()->user()->pin))
                            <!---- change pin model -->
                            <div class="tab-pane active fade show" id="changePin" role="tabpanel">
                                <div class="card user-login-card p-md-5 p-3">
                                    <div class="edit-profile-content">
                                        <div class="edit-profile-details">
                                            <div class="bg-body rounded p-md-5 p-3">
                                                <h5 class="mb-3 text-center">{{ __('frontend.enter_your_new_pin') }}</h5>

                                                <div class="row">
                                                    <div class="col-xl-4 col-md-3 d-md-block d-none"></div>
                                                    <div class="col-xl-4 col-md-6">
                                                        <form id="editProfileDetail">
                                                            @csrf
                                                            <div>
                                                                <input type="hidden" name="type" class="form-control input-style-box" value="change_pin">
                                                            </div>


                                                        <div class="mb-3" >
                                                            <label class="form-label">{{ __('frontend.enter_pin') }}</label>
                                                            <div id="otp-form" class="d-flex align-items-center gap-md-3 gap-2 otp-form">
                                                                <input type="text" name="pin[]" class="otp-input" maxlength="1" required autofocus>
                                                                <input type="text" name="pin[]" class="otp-input" maxlength="1" required>
                                                                <input type="text" name="pin[]" class="otp-input" maxlength="1" required>
                                                                <input type="text" name="pin[]" class="otp-input" maxlength="1" required>
                                                            </div>
                                                            <div class="invalid-feedback text-center" id="pin_error">Pin field is required</div>
                                                            <p class="text-danger text-center" id="pin_bk_error"></p>
                                                        </div>

                                                        <div>
                                                            <label class="form-label">{{ __('frontend.confirm_pin') }}</label>
                                                            <div id="otp-form" class="d-flex align-items-center gap-md-3 gap-2 otp-form">
                                                                <input type="text" name="confirm_pin[]" class="otp-input"  maxlength="1" required autofocus>
                                                                <input type="text" name="confirm_pin[]" class="otp-input" maxlength="1" required>
                                                                <input type="text" name="confirm_pin[]" class="otp-input" maxlength="1" required>
                                                                <input type="text" name="confirm_pin[]" class="otp-input" maxlength="1" required>
                                                            </div>
                                                            <div class="invalid-feedback text-center" id="pin_error">Confirm Pin field is required</div>
                                                            <p class="text-danger text-center" id="confirm_pin_bk_error"></p>
                                                        </div>

                                                        <div class="d-flex justify-content-center mt-4">
                                                            <button type="button" id="updatePinBtn" class="btn btn-primary">{{__('frontend.submit')}}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-xl-4 col-md-3 d-md-block d-none"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!---- end change pin model -->
                        @endif


                        @if(!empty(auth()->user()->pin))
                        <!---- set parentral pin model -->
                        <div class="tab-pane active fade show" id="changeParentPin" role="tabpanel">
                            <div class="card user-login-card p-5">
                                <div class="edit-profile-content">
                                    <div class="edit-profile-details">
                                        <div class="bg-body rounded p-5">

                                            <!-- <div class="row"> -->
                                                <div class="d-flex flex-md-nowrap flex-wrap gap-3">
<div>
    @if(getCurrentProfileSession('is_child_profile') != 0)
        <h5 class="mb-3">{{ __('frontend.change_pins') }}</h5>
    @endif
    <p class="mb-0">{{ __('frontend.pin_change_notice') }}</p>
</div>
</br>
<div class="flex-shrink-0">
    <button id="sendOtpBtn" class="btn btn-primary">{{ __('frontend.send_otps') }}</button>
</div>
</div>
                                                <!-- </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!---- end set parentral pin model -->
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Otp verification Modal -->
    <div class="modal fade add-profile-modal" id="selectOTPModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
           <div class="modal-content position-relative">
               <button type="button" class="btn btn-primary custom-close-btn rounded-2" data-bs-dismiss="modal">
    <i class="ph ph-x text-white fw-bold align-middle"></i>
</button>
              <form id="otpVerification" action="Post" class="requires-validation" data-toggle="validator" novalidate>
<div class="modal-body text-center">
    <div class="mb-3">
        @csrf
        <h5>{{ __('frontend.otp_verification_title') }}</h5>
        <p class="mb-5">{{ __('frontend.otp_sent_message') }}</p>

        <div id="otp-form" class="align-items-center gap-md-3 gap-2 otp-form mb-5">
            <input type="text" id="otp1" name="otp[]" class="otp-input mr-2" maxlength="1" required>
            <input type="text" name="otp[]" class="otp-input" maxlength="1" required>
            <input type="text" name="otp[]" class="otp-input" maxlength="1" required>
            <input type="text" name="otp[]" class="otp-input" maxlength="1" required>
        </div>

        <div class="invalid-feedback text-center" id="otp_error">{{ __('frontend.otp_required_error') }}</div>
        <p class="text-danger text-center" id="otp_bk_error"></p>
    </div>

    <div>
        <span class="font-size-14">
            {{ __('frontend.did_not_receive_otp') }}
            <a href="javascript:void(0)" id="resendOtpBtn">{{ __('frontend.resend_otp') }}</a>
        </span>
    </div>

    <div>
        <button type="button" id="otpBtn" class="btn btn-primary mt-5">{{ __('frontend.verify_otp') }}</button>
    </div>
</div>
</form>
              </div>
            </div>
        </div>

    <!-- Pin Model Modal -->
 <<div class="modal fade add-profile-modal" id="parentPinModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content position-relative">
            <!-- Close button positioned at top-right -->
            <button type="button" class="btn btn-primary custom-close-btn rounded-circle position-absolute top-0 end-0 m-2 p-2" data-bs-dismiss="modal" aria-label="Close" style="width: 40px; height: 40px;">
                <i class="ph ph-x text-white fw-bold align-middle fs-5"></i>
            </button>

            <div class="bg-body rounded p-5 text-center">
                <h5 class="mb-3">{{ __('messages.set_new_parental_pin') }}
</h5>

                <form id="editProfileDetail">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="hidden" name="type" class="form-control input-style-box" value="change_pin">
                    </div>

                    <div class="mb-3" >
                        <p class="text-center">Enter PIN </p>
                        <div id="otp-form" class="align-items-center gap-md-3 gap-2 otp-form mb-5">
                            <input type="text" name="pin[]" class="otp-input" maxlength="1" required>
                            <input type="text" name="pin[]" class="otp-input" maxlength="1" required>
                            <input type="text" name="pin[]" class="otp-input" maxlength="1" required>
                            <input type="text" name="pin[]" class="otp-input" maxlength="1" required>
                        </div>
                        <div class="invalid-feedback text-center" id="pin_error">Pin field is required</div>
                        <p class="text-danger text-center" id="pin_bk_error"></p>
                    </div>

                    <div class="mb-3" >
                        <p class="text-center">Confirm PIN </p>
                        <div id="otp-form" class="align-items-center gap-md-3 gap-2 otp-form mb-5">
                            <input type="text" name="confirm_pin[]" class="otp-input"  maxlength="1" required>
                            <input type="text" name="confirm_pin[]" class="otp-input" maxlength="1" required>
                            <input type="text" name="confirm_pin[]" class="otp-input" maxlength="1" required>
                            <input type="text" name="confirm_pin[]" class="otp-input" maxlength="1" required>
                        </div>
                        <div class="invalid-feedback text-center" id="pin_error">Confirm Pin field is required</div>
                        <p class="text-danger text-center" id="confirm_pin_bk_error"></p>
                    </div>

                    <div class="text-center">
                        <button type="button" id="updatePinBtn" class="btn btn-primary mt-5">{{__('frontend.submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
    document.addEventListener('DOMContentLoaded', function ()
    {
        $(document).ready(function()
        {
            $('#updatePinBtn').on('click', function(e)
            {
                e.preventDefault();
                $('.invalid-feedback').hide();
                $('input').removeClass('is-invalid');
                let valid = true;
                const fieldsToValidate = [
                    {
                        name: 'pin[]',
                        errorElement: '#pin_error'
                    },
                    {
                        name: 'confirm_pin[]',
                        errorElement: '#confirm_pin_error'
                    }
                ];

                fieldsToValidate.forEach(field => {
                    const value = $(`input[name="${field.name}"]`).val();
                    console.log(value);
                    if (!value) {
                        $(field.errorElement).show();
                        $(`input[name="${field.name}"]`).addClass('is-invalid');
                        valid = false;
                    }
                });

                if (!valid) {
                    return;
                }

                var formData = new FormData($('#editProfileDetail')[0]);

                var $btn = $(this);
                $btn.prop('disabled', true).text('Updating...');

                $.ajax({
                    url: `${baseUrl}/api/change-pin`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'Authorization': 'Bearer ' + '{{ auth()->user()->api_token }}'
                    },
                    success: function(response) {
                        if (response.status === true) {
                            $('#pin_bk_error').html(null);
                            $('#confirm_pin_bk_error').html(null);
                            $("#editProfileDetail")[0].reset();
                            window.successSnackbar(response.message)
                            $btn.prop('disabled', false).text('Submit');
                            $('#parentPinModal').modal('hide');
                            setTimeout(function() {
                                window.location.href = baseUrl ;
                            }, 1000);

                        } else {
                            window.successSnackbar('Error change pin.')
                            $btn.prop('disabled', false).text('Submit');
                        }
                    },
                    error: function(xhr, status, error)
                    {
                        var response = JSON.parse(xhr.responseText);

                        if (response.errors && response.errors.pin)
                        {
                            $('#pin_bk_error').html(response.errors.pin[0]);
                        }

                        if (response.errors && response.errors.confirm_pin)
                        {
                            $('#confirm_pin_bk_error').html(response.errors.confirm_pin[0]);
                        }

                        $btn.prop('disabled', false).text('Submit');
                    }
                });
            });


         $('#sendOtpBtn').on('click', function(e) {
    var $btn = $(this);
    $btn.prop('disabled', true).text(window.translations.sending);

    $.ajax({
        url: `${baseUrl}/api/send-otp`,
        type: 'GET',
        success: function(response) {
            if (response.status === true) {
                window.successSnackbar(window.translations.otp_send_success);
                $('#selectOTPModal').modal('show');
            } else {
                window.successSnackbar(window.translations.otp_send_error);
            }

            $btn.prop('disabled', false).text(window.translations.send_otp);
        },
        error: function(xhr, status, error) {
            let response = JSON.parse(xhr.responseText);
            window.successSnackbar(response.message || window.translations.otp_send_error);
            $btn.prop('disabled', false).text(window.translations.send_otp);
        }
    });
});





            $('#otpBtn').on('click', function(e)
            {
                e.preventDefault();
                $('.invalid-feedback').hide();
                $('input').removeClass('is-invalid');
                let valid = true;
                const fieldsToValidate = [
                    {
                        name: 'otp[]',
                        errorElement: '#pin_error'
                    }
                ];

                fieldsToValidate.forEach(field => {
                    const value = $(`input[name="${field.name}"]`).val();
                    console.log(value);
                    if (!value) {
                        $(field.errorElement).show();
                        $(`input[name="${field.name}"]`).addClass('is-invalid');
                        valid = false;
                    }
                });

                if (!valid) {
                    return;
                }

                var formData = new FormData($('#otpVerification')[0]);

                var $btn = $(this);
                $btn.prop('disabled', true).text('Verifying...');

                $.ajax({
                    url: `${baseUrl}/api/verify-otp`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'Authorization': 'Bearer ' + '{{ auth()->user()->api_token }}'
                    },
                    success: function(response) {
                        if (response.status === true) {
                            $('#otp_bk_error').html(null);
                            $("#otpVerification")[0].reset();
                            window.successSnackbar(response.message)
                            $btn.prop('disabled', false).text('Verify OTP');
                            $('#selectOTPModal').modal('hide');
                            $('#parentPinModal').modal('show');

                        } else {
                            window.successSnackbar('Please Enter Valid OTP')
                            $btn.prop('disabled', false).text('Verify OTP');
                        }
                    },
                    error: function(xhr, status, error)
                    {
                        var response = JSON.parse(xhr.responseText);

                        if (response.errors && response.errors.otp)
                        {
                            $('#otp_bk_error').html(response.errors.otp[0]);
                        }
                        $('#otp_bk_error').html(response.message);
                        $btn.prop('disabled', false).text('Verify OTP');
                    }
                });
            });


            $('#resendOtpBtn').on('click', function(e)
            {
                var $btn = $(this);
                $btn.prop('disabled', true).text('Sending...');
                $.ajax({
                    url: `${baseUrl}/api/send-otp`,
                    type: 'GET',
                    success: function(response) {
                        if (response.status === true) {
                            window.successSnackbar(response.message)
                            $btn.prop('disabled', false).text('Resend OTP');

                        } else {
                            window.successSnackbar('Error change pin.')
                            $btn.prop('disabled', false).text('Resend OTP');
                        }
                    },
                    error: function(xhr, status, error)
                    {
                        var response = JSON.parse(xhr.responseText);
                        window.successSnackbar(response.message);
                        $btn.prop('disabled', false).text('Resend OTP');
                    }

                });
            });

        });
    });

    document.addEventListener("DOMContentLoaded", function () {
    const otpInputs = document.querySelectorAll(".otp-input");

    otpInputs.forEach((input, index) => {
        input.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, ''); // Allow only digits
            if (this.value.length === 1) {
                const next = otpInputs[index + 1];
                if (next) next.focus();
            }
        });

        input.addEventListener("keydown", function (e) {
            if (e.key === "Backspace" && !this.value) {
                const prev = otpInputs[index - 1];
                if (prev) prev.focus();
            }
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    var selectOTPModal = document.getElementById('selectOTPModal');

    // Function to initialize OTP input behavior
    function initializeOtpInputs() {
      const otpInputs = document.querySelectorAll('#otp-form .otp-input');

      otpInputs.forEach((input, index) => {
        input.addEventListener('input', function () {
          this.value = this.value.replace(/[^0-9]/g, ''); // Allow only digits
          if (this.value.length === 1) {
            const next = otpInputs[index + 1];
            if (next) next.focus();
          }
        });

        input.addEventListener('keydown', function (e) {
          if (e.key === 'Backspace' && !this.value) {
            const prev = otpInputs[index - 1];
            if (prev) prev.focus();
          }
        });
      });
    }

    // Set focus when modal is shown
    selectOTPModal.addEventListener('shown.bs.modal', function () {
      const firstOtpInput = document.getElementById('otp1');
      if (firstOtpInput) {
        firstOtpInput.focus();
      }
      initializeOtpInputs();
    });
  });

 document.addEventListener('DOMContentLoaded', function () {
    const pinInputs = document.querySelectorAll('.otp-input');
    const parentPinModal = document.getElementById('parentPinModal');

    // Initialize PIN input behavior
    function initializePinInputs() {
      pinInputs.forEach((input, index) => {
        input.addEventListener('input', function () {
          this.value = this.value.replace(/[^0-9]/g, ''); // Allow only digits
          if (this.value.length === 1 && index < pinInputs.length - 1) {
            pinInputs[index + 1].focus();
          }
        });

        input.addEventListener('keydown', function (e) {
          if (e.key === 'Backspace' && !this.value && index > 0) {
            pinInputs[index - 1].focus();
          }
        });
      });
    }

    // Set focus when modal is shown
    parentPinModal.addEventListener('shown.bs.modal', function () {
      pinInputs[0].focus();
      initializePinInputs();
    });
  });


</script>
<style>
    .custom-close-btn {
    width: 37px;          /* increase width */
    height: 37px;         /* increase height */
    display: flex;        /* center content */
    align-items: center;  /* vertical center */
    justify-content: center; /* horizontal center */
    padding: 0;           /* remove padding */
}

.custom-close-btn i {
    font-size: 1.5rem;    /* increase icon size */
}
</style>
@endsection
