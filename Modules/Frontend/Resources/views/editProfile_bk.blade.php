@extends('frontend::layouts.master')
@section('content')
<div class="page-title">
    <h4 class="m-0 text-center">{{__('frontend.edit_profile')}}</h4>
</div>
<div class="section-spacing-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <ul class="nav nav-tabs flex-column gap-4">
                    <li class="nav-item">
                        <a class="nav-link active p-3 text-center" data-bs-toggle="pill" href="#editProfile">
                            <h6 class="m-0">{{__('frontend.update_profile')}}</h6>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-3 text-center" data-bs-toggle="pill" href="#changePassword">
                            <h6 class="m-0">{{__('frontend.profiles')}}</h6>
                        </a>
                    </li>

                    @php

                    $user=auth()->user();

                    @endphp

                    @if(empty($user) || empty($user->login))
                    <li class="nav-item">
                        <a class="nav-link p-3 text-center" data-bs-toggle="pill" href="#changeUserPassword">
                            <h6 class="m-0">{{__('frontend.change_password')}}</h6>
                        </a>
                    </li>
                    @endif

                </ul>
            </div>
            <div class="col-lg-9 mt-lg-0 mt-5">
                <div class="tab-content">
                    <div class="tab-pane active fade show" id="editProfile" role="tabpanel">
                        <div class="card user-login-card p-5">
                            <div class="edit-profile-content">
                                <div class="edit-profile-details">
                                    <div class="bg-body rounded p-5">
                                        <h6 class="mb-3">{{__('frontend.profiles_details')}}</h6>
                                        <div class="row">
                                            <div class="col-md-3 text-center">
                                                <div class="select-profile-card position-relative d-inline-block">
                                                    <!-- Profile Image -->
                                                    <img id="profileImage" src="{{setBaseUrlWithFileName($user->file_url) ?? setDefaultImage()}}" class="img-fluid rounded-circle object-cover"
                                                        alt="select-profile-image" style="cursor: pointer; width: 150px; height: 150px;">

                                                    <!-- Hidden file input -->
                                                    <input type="file" id="profileImageInput" class="d-none" accept="image/*" onchange="previewImage(event)">

                                                    <!-- Pencil icon -->
                                                    <i class="ph ph-pencil pencil-icon" onclick="triggerFileInput()"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-9 mt-md-0 mt-4">
                                                <form id="editProfileDetail">
                                                    @csrf
                                                    <div class="input-group mb-3">
                                                        <span class="input-style-text input-group-text px-0"><i class="ph ph-user"></i></span>
                                                        <input type="text" name="first_name" class="form-control input-style-box" value="{{ $user->first_name }}" placeholder="{{__('frontend.enter_fname')}}" >
                                                        <div class="invalid-feedback" id="first_name_error">First Name field is required</div>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text input-style-text px-0"><i class="ph ph-user"></i></span>
                                                        <input type="text" name="last_name" class="form-control input-style-box" value="{{ $user->last_name }}" placeholder="{{__('frontend.enter_lname')}}">
                                                        <div class="invalid-feedback" id="last_name_error">Last Name field is required</div>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text input-style-text px-0"><i class="ph ph-envelope"></i></span>
                                                        <input type="email" name="email" class="form-control input-style-box" value="{{ $user->email }}" @if ($user->login== 'google') readonly @endif>
                                                        <div class="invalid-feedback" id="email_error">Email is required</div>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text input-style-text px-0"><i class="ph ph-phone"></i></span>
                                                        <input type="tel" class="form-control input-style-box" value="{{ $user->mobile }}" id="mobileInput"  @if ($user->login== 'otp') readonly @endif>
                                                        <div class="invalid-feedback" id="mobile_error">Mobile number is required</div>
                                                    </div>
                                                    <div class="input-group mb-3 flex-nowrap">
                                                     <span class="input-group-text input-style-text px-0"><i class="ph ph-gender-neuter"></i></span>
                                                        <div class="d-flex flex-wrap align-items-center input-style-box w-100 gap-2 px-2">
                                                            <label class="form-check form-check-inline cursor-pointer">
                                                                <input class="form-check-input" type="radio" name="gender" id="male" value="male"
                                                                    {{ old('gender', isset($user) ? $user->gender : 'male') == 'male' ? 'checked' : '' }}>
                                                                <span class="form-check-label">{{ __('messages.lbl_male') }}</span>
                                                            </label>
                                                            <label class="form-check form-check-inline cursor-pointer">
                                                                <input class="form-check-input" type="radio" name="gender" id="female" value="female"
                                                                    {{ old('gender', isset($user) ? $user->gender : 'male') == 'female' ? 'checked' : '' }}>
                                                                <span class="form-check-label">{{ __('messages.lbl_female') }}</span>
                                                            </label>
                                                            <label class="form-check form-check-inline cursor-pointer">
                                                                <input class="form-check-input" type="radio" name="gender" id="other" value="other"
                                                                    {{ old('gender', isset($user) ? $user->gender : 'male') == 'other' ? 'checked' : '' }}>
                                                                <span class="form-check-label">{{ __('messages.lbl_other') }}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text input-style-text px-0"><i class="ph ph-calendar"></i></span>
                                                        <input type="date" name="date_of_birth" class="form-control input-style-box"
                                                            value="{{ old('date_of_birth', isset($user) && $user->date_of_birth  ? date('Y-m-d', strtotime($user->date_of_birth)) : '') }}"
                                                            max="{{ date('Y-m-d') }}" placeholder="{{ __('placeholder.lbl_user_date_of_birth') }}" required>
                                                        <div class="invalid-feedback" id="date_of_birth_error">Date of Birth field is required</div>
                                                    </div>
                                                    <div class="text-end">
                                                        <button type="button" id="updateProfileBtn" class="btn btn-primary mt-5">{{__('frontend.update')}}</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal fade" id="SuccessfullyUpdateProfileModal" tabindex="-1" aria-labelledby="SuccessfullyUpdateProfileModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <span style="color: white; font-size: 18px;">
                                                               {{__('frontend.profile_updated')}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="changePassword" role="tabpanel">
                        <div class="card user-login-card p-5">
                            <div class="edit-profile-content">
                                <h6>{{__('frontend.profiles')}}</h6>
                                <div class="row row-cols-xl-4 row-cols-md-3 row-cols-sm-2 row-cols-1 gy-5" id="profileList">
                                    @foreach ($userProfile->toArray(request()) as $profile)
                                    <?php
                                        $class= $pinModel = "";
                                        // (getCurrentProfileSession('is_child_profile') == 0) && $pinModel = 'data-bs-toggle="modal" data-bs-target="#parentPinModal"';
                                        ($profile['id'] == getCurrentProfileSession('id')) && $class = "border border-primary";
                                        $onClass = "";

                                        $onClass = ($profile['is_child_profile'] == 1) ? "SelectProfile(".$profile['id'].")" : "SelectProfile11(".$profile['id'].")";

                                    ?>
                                        @if($profile['is_active'] == 1)
                                            <div class="col">
                                                <div  class="card bg-body profil-card {{ $class }}" onclick="{{ $onClass}}">
                                                    <small class="text-end p-2">{{ ($profile['is_child_profile'] == 1) ? 'Child' : 'Parent'  }}</small>
                                                    <div class="card-body  rounded text-center">
                                                        <div class="profile-card-image">
                                                            <img id="profile_image_{{ $profile['id'] }}"
                                                            src="{{ !empty($profile['avatar']) ? $profile['avatar'] : asset('path/to/default/image.png') }}"
                                                            alt="profile-image">
                                                        </div>
                                                        <h5 class="mt-3 mb-4 font-size-18" id="profile_name_{{ $profile['id'] }}">
                                                            {{ $profile['name'] }}
                                                        </h5>
                                                        <button class="btn p-0 h6 mb-0" data-bs-toggle="modal"
                                                            data-bs-target="#selectProfileModal" data-type="update">
                                                            <span class="d-flex align-items-center gap-2" onclick="editProfile({{ $profile['id'] }})">
                                                                <span><i class="ph ph-pencil-simple-line"></i></span>
                                                                <span>{{__('frontend.edit')}}</span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col" >
                                                <div class="card bg-body profil-card {{ $class }}" onclick="{{ $onClass}}">
                                                    <small class="text-end p-2">{{ ($profile['is_child_profile'] == 1) ? 'Child' : 'Parent'  }}</small>
                                                    @if($profile['is_child_profile'] == 1)
                                                    <div class="card-body rounded text-center" onclick="SelectProfile({{ $profile['id'] }})">
                                                    @else
                                                    <div class="card-body rounded text-center" onclick="SelectProfile11({{ $profile['id'] }})">
                                                    @endif
                                                    {{-- <div class="card-body rounded text-center" onclick="SelectProfile11({{ $profile['id'] }})"> --}}
                                                        <div class="profile-card-image" >
                                                            <img id="profile_image_{{ $profile['id'] }}" src="{{ $profile['']?? setDefaultImage()}}" alt="profile-image">
                                                        </div>
                                                        <h5 class="mt-3 mb-4 font-size-18" id="profile_name_{{ $profile['id'] }}">{{ $profile['name'] }}</h5>
                                                        <button class="btn p-0 h6 mb-0" data-bs-toggle="modal" data-type="update"
                                                            data-bs-target="#selectProfileModal" >
                                                            <span class="d-flex align-items-center gap-2" onclick=" event.stopPropagation(); editProfile({{ $profile['id']}})">
                                                                <span><i class="ph ph-pencil-simple-line"></i></span>
                                                                <span>{{__('frontend.edit')}}</span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                    <div class="col">
                                        <div class="card profil-card cursor-pointer" data-bs-toggle="modal"
                                            data-bs-target="#selectProfileModal" data-type="add">
                                            <div
                                                class="card-body bg-body rounded text-center d-flex flex-column align-items-center justify-content-center">
                                                <div class="profile-card-add-user bg-dark">
                                                    <i class="ph ph-plus"></i>
                                                </div>
                                                <h5 class="mt-3 mb-0 font-size-18">{{__('frontend.add_user')}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="changeUserPassword" role="tabpanel">
                        <div class="section-bg p-4 rounded">
                            <h6 class="mb-2 pb-1">Update yourfwefew Password</h6>
                            <form id="update-password-form" method="POST" novalidate>
                                @csrf
                                <div class="mb-3">
                                    <div class="input-group custom-input-group">
                                        <input type="password"
                                            name="old_password"
                                            class="form-control"
                                            id="old_password"
                                            placeholder="Old Password"
                                            required>
                                        <span class="input-group-text-1">
                                            <i class="ph ph-eye" id="toggleOldPassword"></i>
                                        </span>
                                    </div>
                                    <div id="error-old-password" class="text-danger mt-1" style="display: none;"></div>
                                </div>

                                <div class="mb-3">
                                    <div class="input-group custom-input-group">
                                        <input type="password"
                                            name="new_password"
                                            class="form-control"
                                            id="new_password"
                                            placeholder="New Password"
                                            required>
                                        <span class="input-group-text-1">
                                            <i class="ph ph-eye" id="toggleNewPassword"></i>
                                        </span>
                                    </div>
                                    <div id="error-new-password" class="text-danger mt-1" style="display: none;"></div>
                                    <!-- <small class="text-muted">Password must be at least 8 characters long and contain letters and numbers</small> -->
                                </div>

<div class="mb-3">
    <div class="input-group custom-input-group">
        <input type="password"
               name="new_password_confirmation"
               class="form-control"
               id="new_password_confirmation"
               placeholder="Confirm Password"
               required>
        <span class="input-group-text-1">
            <i class="ph ph-eye" id="toggleConfirmPassword"></i>
        </span>
    </div>
    <div id="error-confirm-password" class="text-danger mt-1" style="display: none;"></div>
</div>

                                <div class="d-flex justify-content-md-end mt-5">
                                    <button type="submit" class="btn btn-danger">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content position-relative">
            <div class="modal-body user-login-card m-0 p-4 position-relative">
                <button type="button" class="btn btn-primary custom-close-btn rounded-2" data-bs-dismiss="modal">
                    <i class="ph ph-x text-white fw-bold align-middle"></i>
                </button>
                <h6>{{__('frontend.edit_profile_details')}}</h6>
                <form class="editProfileDetail">
                    <div class="input-group mb-3">
                        <span class="input-style-text input-group-text px-0"><i class="ph ph-user"></i></span>
                        <input type="text" name="first_name" class="form-control input-style-box" value="{{ $user->first_name }}">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text input-style-text px-0"><i class="ph ph-user"></i></span>
                        <input type="text" name="last_name" class="form-control input-style-box" value="{{ $user->last_name }}">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text input-style-text px-0"><i class="ph ph-envelope"></i></span>
                        <input type="text" name="email" class="form-control input-style-box" value="{{ $user->email }}">
                    </div>
                </form>
                <div class="d-flex align-items-center justify-content-center">
                    <button class="btn btn-primary mt-5" data-bs-toggle="modal" data-bs-target="#SuccessfullyUpdateProfileModal">{{__('frontend.update')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade add-profile-modal" id="selectProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content position-relative">
          <button type="button" class="btn btn-primary custom-close-btn rounded-2" data-bs-dismiss="modal">
              <i class="ph ph-x text-white fw-bold align-middle"></i>
          </button>
          <form id="ProfileDetail" action="Post" class="requires-validation" data-toggle="validator" novalidate >
            <div class="modal-body text-center">

                <input type="hidden" name="profile_id" id="profile_id" value=""/>
                <div class="select-profile-slider d-flex align-items-center gap-3 ">
                    <!-- Example for the first image -->

                   <div class="slick-item">
                    <label class="select-profile-card">
                        <input type="radio" name="profile_image" value="{{ asset('/img/web-img/user-img.png')}}" class="d-none" />
                        <img src="{{ asset('/img/web-img/user-img.png')}}" class="select-profile-image" id="profile_image" alt="select-profile-image">
                        <input type="file" id="profileFileImageInput" class="d-none" accept="image/*" onchange="previewProfileImage(event)">
                        <i class="ph ph-pencil pencil-icon" onclick="triggerProfileFileInput()"></i>
                    </label>

                   </div>
                   <div class="slick-item">
                      <label class="select-profile-card">
                          <input type="radio" name="profile_image" value="{{ asset('/img/web-img/user-img.png')}}" class="d-none" />
                          <img src="{{ asset('/img/web-img/user-img.png')}}" class="select-profile-image" alt="select-profile-image">
                      </label>
                   </div>
                  <div class="slick-item">
                      <label class="select-profile-card">
                          <input type="radio" name="profile_image" value="{{ asset('/img/web-img/user-img.png')}}" class="d-none" id="profile_image_value" checked />
                          <img src="{{ asset('/img/web-img/user-img.png')}}" class="select-profile-image" alt="select-profile-image">
                      </label>
                  </div>
                  <div class="slick-item">
                      <label class="select-profile-card">
                          <input type="radio" name="profile_image" value="{{ asset('/img/web-img/user-img.png')}}" class="d-none" />
                          <img src="{{ asset('/img/web-img/user-img.png')}}" class="select-profile-image" alt="select-profile-image">
                      </label>
                  </div>
                  <div class="slick-item">
                      <label class="select-profile-card">
                          <input type="radio" name="profile_image" value="{{ asset('/img/web-img/user-img.png')}}" class="d-none" />
                          <img src="{{ asset('/img/web-img/user-img.png')}}" class="select-profile-image" alt="select-profile-image">
                      </label>
                  </div>
              </div>
              <div class="pt-4 mt-4 user-login-card">

                      <div class="input-group mb-3">
                          <span class="input-style-text input-group-text px-0"><i class="ph ph-user"></i></span>
                          <input type="text" name="profile_first_name" class="form-control input-style-box" placeholder="{{__('frontend.enter_name')}}" id="profile_first_name" required>
                          <div class="invalid-feedback" id="password-error">Name field is required.</div>
                      </div>

                        <div class="input-group mb-3">
                            <div class="d-flex justify-content-between align-items-center form-control">
                                {{ html()->label('Children`s Profile', 'is_child_profile')->class('form-label mb-0 text-body') }}
                                <div class="form-check form-switch">
                                    {{ html()->checkbox('is_child_profile')->class('form-check-input')->id('is_child_profile') }}
                                    @error('is_child_profile')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                      <div class="mt-5 pt-4">
                          <button type="submit"  id="update-profile" class="btn btn-primary">{{__('messages.add')}}</button>
                      </div>

              </div>
          </div>

                </div>
            </div>
        </form>
      </div>
    </div>
</div>

<style>

    #otp-form {
      width: 100%;
      display: flex;
      gap: 20px;
      align-items: center;
      justify-content: center;
    }
    #otp-form input {
      border: none;
      background-color: #121517;
      color: white;
      font-size: 32px;
      text-align: center;
      padding: 10px;
      width: 100%;
      max-width: 70px;
      height: 70px;
      border-radius: 4px;
      outline: 2px solid rgb(66, 66, 66);
    }
    #otp-form input:focus-visible {
      outline: 2px solid royalblue;
    }
    #otp-form input.filled {
      outline: 2px solid rgb(7, 192, 99);
    }

</style>

<!-- Pin Model Modal -->
<div class="modal fade add-profile-modal" id="verifyPinModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content position-relative">
        <button type="button" class="btn btn-primary custom-close-btn rounded-2" data-bs-dismiss="modal">
            <i class="ph ph-x text-white fw-bold align-middle"></i>
        </button>
        <div class="bg-body rounded p-5">
            <form id="verifyPinDetail">
                @csrf
                <div class="mb-3" >
                    <input type="hidden" id="select_profile_id" name="select_profile_id" value="">
                    <h4 class="mb-3 text-center">Enter Your PIN </h4>
                    <div id="otp-form">
                        <input type="text" name="pin[]" class="otp-input" maxlength="1" required autofocus>
                        <input type="text" name="pin[]" class="otp-input" maxlength="1" required>
                        <input type="text" name="pin[]" class="otp-input" maxlength="1" required>
                        <input type="text" name="pin[]" class="otp-input" maxlength="1" required>
                    </div>
                    <div class="invalid-feedback text-center" id="pin_error">Pin field is required</div>
                    <p class="text-danger text-center mt-3" id="pin_bk_error"></p>
                </div>

                <div class="text-center">
                    <button type="button" id="verifyPinBtn" class="btn btn-primary mt-5">{{__('frontend.submit')}}</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>


    var input = document.querySelector("#mobileInput");
    var iti = window.intlTelInput(input, {
        initialCountry: "in",  // Automatically detect user's country
        separateDialCode: true,  // Show the country code separately
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"  // To handle number formatting
    });


function triggerProfileFileInput() {
    document.getElementById('profileFileImageInput').click();
}

// Function to preview the selected image
function previewProfileImage(event) {
    const reader = new FileReader();
    const fileInput = event.target;

    reader.onload = function() {
        const previewImage = document.getElementById('profile_image');
        previewImage.src = reader.result; // Update the image preview
    };

    reader.readAsDataURL(fileInput.files[0]);
}


      function triggerFileInput() {
        document.getElementById('profileImageInput').click();
    }
    function previewImage(event) {
        const image = document.getElementById('profileImage');
        image.src = URL.createObjectURL(event.target.files[0]);
    }

    document.getElementById('profileImage').addEventListener('click', triggerFileInput);
    const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');

    document.addEventListener('DOMContentLoaded', function () {

        $(document).ready(function() {

            $('#updateProfileBtn').on('click', function(e) {
                e.preventDefault();

                $('.invalid-feedback').hide();
                $('input').removeClass('is-invalid');

                let valid = true;

                const fieldsToValidate = [
                    {
                        name: 'first_name',
                        errorElement: '#first_name_error'
                    },
                    {
                        name: 'last_name',
                        errorElement: '#last_name_error'
                    },
                    {
                        name: 'date_of_birth',
                        errorElement: '#date_of_birth_error'
                    }
                ];

                fieldsToValidate.forEach(field => {
                    const value = $(`input[name="${field.name}"]`).val().trim();
                    if (!value) {
                        $(field.errorElement).show();
                        $(`input[name="${field.name}"]`).addClass('is-invalid');
                        valid = false;
                    }
                });

                const mobileInput = $('#mobileInput');

                    const mobileValue = mobileInput.val().trim();
                    if (!mobileValue) {
                        $('#mobileInput').addClass('is-invalid');
                        $('#mobile_error').show().text('Mobile number is required');
                        valid = false;
                    } else {
                        $('#mobile_error').hide();
                    }

                if (!valid) {
                    return;
                }

                var number = iti.getNumber()


                var formData = new FormData($('#editProfileDetail')[0]);

                formData.append('mobile', number);

                var imageFile = $('#profileImageInput')[0].files[0];
                if (imageFile) {
                    formData.append('file_url', imageFile);
                }

                var $btn = $(this);
                $btn.prop('disabled', true).text('Updating...');

                $.ajax({
                    url: `${baseUrl}/api/update-profile`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'Authorization': 'Bearer ' + '{{ auth()->user()->api_token }}'
                    },
                    success: function(response) {
                        if (response.status === true) {
                            $('input[name="first_name"]').val(response.data.first_name);
                            $('input[name="last_name"]').val(response.data.last_name);
                            $('input[name="email"]').val(response.data.email);
                            $('input[name="mobile"]').val(response.data.mobile);
                            $('input[name="date_of_birth"]').val(response.data.date_of_birth);

                          //  const image = document.getElementById('profileImage');
                         //   image.src =setBaseUrlWithFileName(response.data.file_url);

                            $('input[name="gender"][value="' + response.data.gender + '"]').prop('checked', true);

                            window.successSnackbar(response.message)

                            $btn.prop('disabled', false).text('Update');

                        } else {
                            window.successSnackbar('Error updating profile.')
                            $btn.prop('disabled', false).text('Update');

                        }   
                    },
                    error: function(xhr, status, error) {
                  var response = JSON.parse(xhr.responseText);

                  if (response.message) {

                      window.successSnackbar(response.message);
                  } else if (response.errors && response.errors.mobile) {

                      window.successSnackbar(response.errors.mobile[0]);
                  }

                  $btn.prop('disabled', false).text('Update');
                 }
                });
            });

            $('#verifyPinBtn').on('click', function(e)
            {
                e.preventDefault();
                $('.invalid-feedback').hide();
                $('input').removeClass('is-invalid');
                let valid = true;
                const fieldsToValidate = [
                    {
                        name: 'pin[]',
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

                var formData = new FormData($('#verifyPinDetail')[0]);

                var select_profile_id = $('#select_profile_id').val();

                var $btn = $(this);
                $btn.prop('disabled', true).text('Submiting...');

                $.ajax({
                    url: `${baseUrl}/api/verify-pin`,
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
                            $("#verifyPinDetail")[0].reset();
                            window.successSnackbar(response.message)
                            $btn.prop('disabled', false).text('Submit');
                            SelectProfile(select_profile_id);
                        } else {
                            $('#pin_bk_error').html(response.message);
                            window.successSnackbar(response.message)
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

                        $btn.prop('disabled', false).text('Submit');
                    }
                });
            });
        });

        $(document).ready(function () {
            const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');

            const apiUrl = `${baseUrl}/api/save-userprofile`;

            $("#ProfileDetail").on("submit", function (e) {
                e.preventDefault();
                let isValid = true;

                const nameField = $("#profile_first_name");
                if (nameField.val().trim() === "") {
                    nameField.addClass("is-invalid");
                    isValid = false;
                } else {
                    nameField.removeClass("is-invalid");
                }

                const selectedImage = $('input[name="profile_image"]:checked').val();
                const profileId = $("#profile_id").val();

                var formData = new FormData();

                if (!isValid) return;

                formData.append('id', profileId);
                formData.append('avatar', selectedImage);
                formData.append('name', nameField.val());

                const isChildProfile = $('input[name="is_child_profile"]:checked').val();
                if (isChildProfile) {
                    formData.append('is_child_profile', isChildProfile);
                }


                var imageFile = $('#profileFileImageInput')[0].files[0];
                if (imageFile) {
                    formData.append('file_url', imageFile);
                }
                        // Make an AJAX request to save the profile
                        $.ajax({
                            url: apiUrl, // Replace with your actual API endpoint
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {

                                $("#profileList").empty();

                                response.data.forEach(function (profile) {
                                    let profileHtml = '';

                                    if(profile.is_child_profile == 1)
                                    {
                                        var onClass = "SelectProfile("+profile.id+")";
                                    } else{
                                        var onClass = "SelectProfile11("+profile.id+")";
                                    }

                                    if (profile.is_active == 1) {
                                        profileHtml = `
                                        <div class="col">
                                            <div class="card bg-body profil-card border border-primary" onclick="${onClass}">
                                                <div class="card-body  rounded text-center">
                                                    <div class="profile-card-image">
                                                        <img id="profile_image_${profile.id}" src="${profile.avatar}" alt="profile-image">
                                                    </div>
                                                    <h5 class="mt-3 mb-4 font-size-18" id="profile_name_${profile.id}">${profile.name}</h5>
                                                    <button class="btn p-0 h6 mb-0" data-bs-toggle="modal" data-type="update" data-bs-target="#selectProfileModal">
                                                        <span class="d-flex align-items-center gap-2" onclick="event.stopPropagation(); editProfile(${profile.id})">
                                                            <span><i class="ph ph-pencil-simple-line"></i></span>
                                                            <span>Edit</span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>`;
                                    } else {

                                        if(profile.is_child_profile == 1)
                                        {
                                            var onClass = "SelectProfile("+profile.id+")";
                                        } else{
                                            var onClass = "SelectProfile11("+profile.id+")";
                                        }

                                        profileHtml = `
                                        <div class="col">
                                            <div class="card bg-body profil-card" onclick="${onClass}" >
                                                <div class="card-body  rounded text-center">
                                                    <div class="profile-card-image" >
                                                        <img id="profile_image_${profile.id}" src="${profile.avatar}" alt="profile-image">
                                                    </div>
                                                    <h5 class="mt-3 mb-4 font-size-18" id="profile_name_${profile.id}">${profile.name}</h5>
                                                    <button class="btn p-0 h6 mb-0" data-bs-toggle="modal" data-type="update" data-bs-target="#selectProfileModal">
                                                        <span class="d-flex align-items-center gap-2" onclick="event.stopPropagation(); editProfile(${profile.id})">
                                                            <span><i class="ph ph-pencil-simple-line"></i></span>
                                                            <span>Edit</span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>`;
                                    }

                                    $("#profileList").append(profileHtml);
                                });

                                // Append the "Add User" card at the end of the profile list
                                const addUserHtml = `
                                    <div class="col">
                                        <div class="card profil-card cursor-pointer" data-bs-toggle="modal"  data-type="add" data-bs-target="#selectProfileModal">
                                            <div class="card-body bg-body rounded text-center d-flex flex-column align-items-center justify-content-center">
                                                <div class="profile-card-add-user bg-dark">
                                                    <i class="ph ph-plus"></i>
                                                </div>
                                                <h5 class="mt-3 mb-0 font-size-18">Add Profile</h5>
                                            </div>
                                        </div>
                                    </div>`;

                                $("#profileList").append(addUserHtml);
                                window.successSnackbar(response.message)
                                // Close the modal
                                $("#selectProfileModal").modal('hide');
                            },
                            error: function (xhr, status, error) {
                                if(xhr.status){
                                    window.successSnackbar(xhr.responseJSON.error)

                                }else{
                                    window.successSnackbar('Something went wrong!')
                                }
                                $("#selectProfileModal").modal('hide');

                            }
                        });

                        $("#profile_id").val("");
                    });

                    // Reset validation feedback when modal is closed
                    $('#selectProfileModal').on('hidden.bs.modal', function () {
                        $("#ProfileDetail")[0].reset();
                        $(".is-invalid").removeClass("is-invalid");

                    });
                });

            });

            function editProfile(id) {

                const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
                const apiUrl = `${baseUrl}/api/get-userprofile/${id}`;

                fetch(apiUrl, {
                    method: 'GET',
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(response => {

                    document.getElementById('profile_id').value = response.data.id;
                    document.getElementById('profile_first_name').value = response.data.name;
                    const profileImageValue = response.data.avatar; // Get the profile image value from the API
                    const modalImage = document.getElementById('profile_image');
                    document.getElementById('profile_image_value').value = profileImageValue;
                    modalImage.setAttribute('src', profileImageValue);
                    $('#selectProfileModal').modal('show');


                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
            }

            function SelectProfile11(id){
                $('#select_profile_id').val(id);
                var pin = "<?php echo getLoggedUserPin() ?>";
                if(pin != "")
                {
                    $('#verifyPinModal').modal('show');
                }else{
                    SelectProfile(id);
                }
            }

            function SelectProfile(id)
            {
                const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
                const apiUrl = `${baseUrl}/api/select-userprofile/${id}`;

                fetch(apiUrl, {
                    method: 'GET',
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(response => {
                    // window.successSnackbar(response.message)
                    $("#profileList").empty();

                        response.data.forEach(function (profile) {
                                    let profileHtml = '';

                                    if(profile.is_child_profile == 1)
                                    {
                                        var onClass = "SelectProfile("+profile.id+")";
                                    } else{
                                        var onClass = "SelectProfile11("+profile.id+")";
                                    }

                                    if(profile.id == id) {
                                        profileHtml = `
                                        <div class="col">
                                            <div class="card bg-body profil-card border border-primary" onclick="${onClass}">
                                                <div class="card-body  rounded text-center">
                                                    <div class="profile-card-image">
                                                        <img id="profile_image_${profile.id}" src="${profile.avatar}" alt="profile-image">
                                                    </div>
                                                    <h5 class="mt-3 mb-4 font-size-18" id="profile_name_${profile.id}">${profile.name}</h5>
                                                    <button class="btn p-0 h6 mb-0" data-bs-toggle="modal" data-type="update" data-bs-target="#selectProfileModal">
                                                        <span class="d-flex align-items-center gap-2" onclick="event.stopPropagation(); editProfile(${profile.id})">
                                                            <span><i class="ph ph-pencil-simple-line"></i></span>
                                                            <span>Edit</span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>`;
                                    } else {
                                        if(profile.is_child_profile == 1)
                                        {
                                            var onClass = "SelectProfile("+profile.id+")";
                                        } else{
                                            var onClass = "SelectProfile11("+profile.id+")";
                                        }
                                        profileHtml = `
                                        <div class="col" >
                                            <div class="card bg-body profil-card" onclick="${onClass}">
                                                <div class="card-body  rounded text-center">
                                                    <div class="profile-card-image">
                                                        <img id="profile_image_${profile.id}" src="${profile.avatar}" alt="profile-image">
                                                    </div>
                                                    <h5 class="mt-3 mb-4 font-size-18" id="profile_name_${profile.id}">${profile.name}</h5>
                                                    <button class="btn p-0 h6 mb-0" data-bs-toggle="modal" data-type="update" data-bs-target="#selectProfileModal">
                                                        <span class="d-flex align-items-center gap-2" onclick="event.stopPropagation(); editProfile(${profile.id})">
                                                            <span><i class="ph ph-pencil-simple-line"></i></span>
                                                            <span>Edit</span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>`;
                                    }

                                    $("#profileList").append(profileHtml);
                        });

                    
                        // Append the "Add User" card at the end of the profile list
                        const addUserHtml = `
                            <div class="col">
                                <div class="card profil-card cursor-pointer" data-bs-toggle="modal"  data-type="add" data-bs-target="#selectProfileModal">
                                    <div class="card-body bg-body rounded text-center d-flex flex-column align-items-center justify-content-center">
                                        <div class="profile-card-add-user bg-dark">
                                            <i class="ph ph-plus"></i>
                                        </div>
                                        <h5 class="mt-3 mb-0 font-size-18">Add Profile</h5>
                                    </div>
                                </div>
                            </div>`;

                        $("#profileList").append(addUserHtml);

                        $('#select_profile_id').val('');
                        $('#verifyPinModal').modal('hide');
                     

                })
                .catch(error => {
                    window.successSnackbar(error)

                });

            }

            document.addEventListener('DOMContentLoaded', function () {
                const selectProfileModal = document.getElementById('selectProfileModal');

                selectProfileModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget; // Button that triggered the modal
                    const dataType = button.getAttribute('data-type');
                    const updateButton = document.getElementById('update-profile');

                    if (dataType === 'add') {
                        $("#ProfileDetail")[0].reset();
                        $("#profile_id").val('');
                        updateButton.textContent = '{{__('messages.add')}}'; // Change to "Add"

                    } else {

                        updateButton.textContent = '{{__('frontend.update')}}'; // Default "Update"

                    }
                });
                document.getElementById('update-password-form').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const form = e.target;
                    const formData = new FormData(form);

                    document.getElementById('error-old-password').classList.add('d-none');
                    document.getElementById('error-new-password').classList.add('d-none');

                    fetch("{{ route('account.password.update') }}", {
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: formData,
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {

                                window.successSnackbar('Your password has been successfully updated')
                                // Swal.fire({
                                //     icon: 'success',
                                //     title: 'Password Updated',
                                //     text: 'Your password has been successfully updated.',
                                // });
                                form.reset(); // Clear form on success
                            } else if (data.errors) {
                                if (data.errors.old_password) {
                                    const oldPasswordError = document.getElementById('error-old-password');
                                    oldPasswordError.innerText = data.errors.old_password;
                                    oldPasswordError.classList.remove('d-none');
                                }
                                if (data.errors.new_password) {
                                    const newPasswordError = document.getElementById('error-new-password');
                                    newPasswordError.innerText = data.errors.new_password.join(', '); // Handle array errors
                                    newPasswordError.classList.remove('d-none');
                                }
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });


            });

            function showSuccessMessage(message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });

                Toast.fire({
                    icon: 'success',
                    title: message
                });
            }

            document.getElementById('update-password-form').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = e.target;
                const formData = new FormData(form);

                // Clear previous error messages
                document.getElementById('error-old-password').style.display = 'none';
                document.getElementById('error-new-password').style.display = 'none';

                // Disable submit button to prevent double submission
                const submitButton = form.querySelector('button[type="submit"]');
                submitButton.disabled = true;

                fetch("{{ route('account.password.update') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        // showSuccessMessage('Password updated successfully');

                        // Reset form
                        form.reset();

                        // Optional: Close any open modals if needed
                        // const modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
                        // if (modal) modal.hide();
                    } else if (data.errors) {
                        // Handle validation errors
                        if (data.errors.old_password) {
                            const oldPasswordError = document.getElementById('error-old-password');
                            oldPasswordError.textContent = data.errors.old_password;
                            oldPasswordError.style.display = 'block';
                        }
                        if (data.errors.new_password) {
                            const newPasswordError = document.getElementById('error-new-password');
                            newPasswordError.textContent = Array.isArray(data.errors.new_password)
                                ? data.errors.new_password.join(', ')
                                : data.errors.new_password;
                            newPasswordError.style.display = 'block';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please try again.',
                    });
                })
                .finally(() => {
                    // Re-enable submit button
                    submitButton.disabled = false;
                });
            });

            // Add this to your existing JavaScript code
            document.addEventListener('DOMContentLoaded', function() {

                    function togglePasswordVisibility(inputId, toggleId) {
                    const passwordInput = document.getElementById(inputId);
                    const toggleIcon = document.getElementById(toggleId);

                    if (passwordInput && toggleIcon) {
                        toggleIcon.addEventListener('click', function() {
                            // Toggle password visibility
                            if (passwordInput.type === 'password') {
                                passwordInput.type = 'text';
                                toggleIcon.classList.add('ph-eye');
                                toggleIcon.classList.remove('ph-eye-slash');
                            } else {
                                passwordInput.type = 'password';
                                toggleIcon.classList.add('ph-eye-slash');
                                toggleIcon.classList.remove('ph-eye');
                            }
                        });
                    }
                }

                // Initialize toggle functionality for all password fields
                togglePasswordVisibility('old_password', 'toggleOldPassword');
                togglePasswordVisibility('new_password', 'toggleNewPassword');
                togglePasswordVisibility('new_password_confirmation', 'toggleConfirmPassword');


                const newPassword = document.getElementById('new_password');
                const confirmPassword = document.getElementById('new_password_confirmation');
                const confirmPasswordError = document.getElementById('error-confirm-password');

                // Function to check password match
                function checkPasswordMatch() {
                    if (confirmPassword.value) {
                        if (confirmPassword.value !== newPassword.value) {
                            confirmPassword.classList.add('is-invalid');
                            confirmPasswordError.textContent = 'Passwords do not match';
                            confirmPasswordError.style.display = 'block';
                            return false;
                        } else {
                            confirmPassword.classList.remove('is-invalid');
                            confirmPasswordError.style.display = 'none';
                            return true;
                        }
                    }
                    return true;
                }

                // Real-time validation for confirm password
                confirmPassword.addEventListener('input', function() {
                    checkPasswordMatch();
                });

                // Also check when new password changes
                newPassword.addEventListener('input', function() {
                    if (confirmPassword.value) {
                        checkPasswordMatch();
                    }
                });

                // Update your form submit validation
                document.getElementById('update-password-form').addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Clear previous errors
                    const errors = document.querySelectorAll('.text-danger');
                    errors.forEach(error => error.style.display = 'none');

                    let isValid = true;

                    // Validate old password
                    const oldPassword = document.getElementById('old_password');
                    if (!oldPassword.value.trim()) {
                        document.getElementById('error-old-password').textContent = 'Old password is required';
                        document.getElementById('error-old-password').style.display = 'block';
                        oldPassword.classList.add('is-invalid');
                        isValid = false;
                    }

                    // Validate new password
                    if (!newPassword.value.trim()) {
                        document.getElementById('error-new-password').textContent = 'New password is required';
                        document.getElementById('error-new-password').style.display = 'block';
                        newPassword.classList.add('is-invalid');
                        isValid = false;
                    } else if (newPassword.value.length < 8) {
                        document.getElementById('error-new-password').textContent = 'Password must be at least 8 characters long';
                        document.getElementById('error-new-password').style.display = 'block';
                        newPassword.classList.add('is-invalid');
                        isValid = false;
                    }

                    // Validate confirm password
                    if (!confirmPassword.value.trim()) {
                        confirmPasswordError.textContent = 'Please confirm your password';
                        confirmPasswordError.style.display = 'block';
                        confirmPassword.classList.add('is-invalid');
                        isValid = false;
                    } else if (!checkPasswordMatch()) {
                        isValid = false;
                    }

                    if (!isValid) {
                        return;
                    }

                    // Continue with form submission if validation passes
                    const formData = new FormData(this);
                    const submitButton = this.querySelector('button[type="submit"]');
                    // submitButton.disabled = true;
                    // submitButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Updating...';

                    // Your existing fetch call here...
                });
            });
            // Add this to your existing JavaScript code
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('update-password-form');
                const oldPassword = document.getElementById('old_password');
                const newPassword = document.getElementById('new_password');
                const confirmPassword = document.getElementById('new_password_confirmation');

                // Function to validate a password field and show/hide error message
                function validatePasswordField(input, errorElementId, validationFn) {
                    const errorElement = document.getElementById(errorElementId);
                    const isValid = validationFn(input.value);

                    if (!isValid) {
                        input.classList.add('is-invalid');
                        errorElement.style.display = 'block';
                    } else {
                        input.classList.remove('is-invalid');
                        errorElement.style.display = 'none';
                    }

                    return isValid;
                }

                // Real-time validation on input
                oldPassword.addEventListener('input', function() {
                    validatePasswordField(this, 'error-old-password', value => value.trim().length > 0);
                });

                newPassword.addEventListener('input', function() {
                    const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
                    validatePasswordField(this, 'error-new-password', value => {
                        if (!value.trim()) {
                            document.getElementById('error-new-password').textContent = 'New password is required';
                            return false;
                        }
                        if (value.length < 8) {
                            document.getElementById('error-new-password').textContent = 'Password must be at least 8 characters long';
                            return false;
                        }
                        // if (!passwordRegex.test(value)) {
                        //     document.getElementById('error-new-password').textContent = 'Password must contain both letters and numbers';
                        //     return false;
                        // }
                        if (value === oldPassword.value) {
                            document.getElementById('error-new-password').textContent = 'New password must be different from old password';
                            return false;
                        }
                        return true;
                    });

                    // Validate confirm password when new password changes
                    if (confirmPassword.value) {
                        validatePasswordField(confirmPassword, 'error-confirm-password',
                            value => value === this.value);
                    }
                });

                confirmPassword.addEventListener('input', function() {
                    validatePasswordField(this, 'error-confirm-password',
                        value => value === newPassword.value);
                });

                // Form submission
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Validate all fields
                    const isOldPasswordValid = validatePasswordField(oldPassword, 'error-old-password',
                        value => value.trim().length > 0);

                    const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
                    const isNewPasswordValid = validatePasswordField(newPassword, 'error-new-password', value => {
                        if (!value.trim()) {
                            document.getElementById('error-new-password').textContent = 'New password is required';
                            return false;
                        }
                        if (value.length < 8) {
                            document.getElementById('error-new-password').textContent = 'Password must be at least 8 characters long';
                            return false;

                        }
                        if (!passwordRegex.test(value)) {
                            document.getElementById('error-new-password').textContent = 'Password must contain both letters and numbers';
                            return false;

                        }
                        if (value === oldPassword.value) {
                            document.getElementById('error-new-password').textContent = 'New password must be different from old password';
                            return false;

                        }
                        return true;
                    });

                    const isConfirmPasswordValid = validatePasswordField(confirmPassword, 'error-confirm-password',
                        value => value === newPassword.value);

                    if (!isOldPasswordValid || !isNewPasswordValid || !isConfirmPasswordValid) {
                        return;
                    }

                    // Submit form if validation passes
                    const submitButton = form.querySelector('button[type="submit"]');
                    // submitButton.disabled = true;
                    // submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...';

                    const formData = new FormData(form);

                    fetch("{{ route('account.password.update') }}", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Password updated successfully',
                                showConfirmButton: false,
                                timer: 2000
                            });
                            form.reset();
                        } else if (data.errors) {
                            Object.entries(data.errors).forEach(([key, value]) => {
                                const errorElement = document.getElementById(`error-${key.replace('_', '-')}`);
                                if (errorElement) {
                                    errorElement.textContent = Array.isArray(value) ? value[0] : value;
                                    errorElement.style.display = 'block';
                                    document.getElementById(key).classList.add('is-invalid');

                                }

                                    submitButton.disabled = false;
                                    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Update';
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong! Please try again.',
                        });
                    })
                    .finally(() => {
                        submitButton.disabled = false;
                        submitButton.textContent = 'Update';
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
</script>
@endsection
