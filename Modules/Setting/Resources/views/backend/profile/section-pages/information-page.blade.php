@extends('setting::backend.profile.profile-layout')

@section('profile-content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-user"></i> {{__('messages.lbl_personal_info')}}</h2>
    </div>

    <!-- @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif -->

    <!-- <form method="POST" action="{{ route('backend.profile.information-update') }}" enctype="multipart/form-data"> -->
    {{ html()->form('POST' ,route('backend.profile.information-update'))->attribute('enctype', 'multipart/form-data')->attribute('data-toggle', 'validator')
    ->attribute('id', 'form-submit')  // Add the id attribute here
    ->class('requires-validation')  // Add the requires-validation class
    ->attribute('novalidate', 'novalidate')  // Disable default browser validation
    ->open() }}
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="first_name">{{ __('profile.lbl_first_name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                                @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="invalid-feedback" id="name-error">First Name field is required</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="last_name">{{ __('profile.lbl_last_name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                                @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="invalid-feedback" id="name-error">Last Name field is required</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="email">{{ __('profile.lbl_email') }} <span class="text-danger">*</span></label>
                                <input type="email" class="form-control " id="email" name="email" value="{{ old('email', $user->email) }}" required >
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="invalid-feedback" id="email-error">Email field is required</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="mobile">{{ __('profile.lbl_contact_number') }} <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control " id="mobile" name="mobile" value="{{ old('mobile', $user->mobile) }}" required>
                                @error('mobile')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="invalid-feedback" id="name-error">Contact Number field is required</div>
                            </div>
                        </div>
                    </div>
    
                    <div class="col-md-6 col-lg-4 position-relative">
                        <div class="input-group btn-file-upload">
                            {{ html()->button('<i class="ph ph-image"></i>'. __('messages.lbl_choose_image'))
                                ->class('input-group-text form-control')
                                ->type('button')
                                ->attribute('data-bs-toggle', 'modal')
                                ->attribute('data-bs-target', '#exampleModal')
                                ->attribute('data-image-container', 'selectedImageContainerCastcerw')
                                ->attribute('data-hidden-input', 'file_url_image')
                            }}
    
                            {{ html()->text('castcrew_input')
                                ->class('form-control')
                                ->placeholder('Select Image')
                                ->attribute('aria-label', 'Profile Image')
                                ->attribute('data-bs-toggle', 'modal')
                                ->attribute('data-bs-target', '#exampleModal')
                                ->attribute('data-image-container', 'selectedImageContainerCastcrew')
                            }}
                        </div>
                        <div class="uploaded-image" id="selectedImageContainerCastcerw">
                            @if(old('file_url', isset($user) ? $user->file_url : ''))
                                <img id="profileImage" src="{{ old('file_url', isset($user) ? setBaseUrlWithFileName($user->file_url) : '') }}" class="img-fluid mb-2">
                                <span class="remove-media-icon"
                                      style="cursor: pointer; font-size: 24px; color: red;"
                                      onclick="removeProfileImage()">×</span>
                            @endif
                        </div>
    
                        {{ html()->hidden('file_url')->id('file_url_image')->value(old('file_url', isset($user) ? $user->file_url : '')) }}
                    </div>
    
    
                    <div class="col-md-4 mt-md-0 mt-3">
                        <div class="form-group">
                            <label class="form-label" for="" class="w-100">{{ __('profile.lbl_gender') }}</label>
                            <div class="d-flex align-items-center flex-wrap gap-3">
                                <label class="form-check form-control w-auto flex-grow-1 px-5 cursor-pointer">
                                    <div>
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ old('gender', $user->gender) == 'male' ? 'checked' : '' }} />
                                        <span class="form-check-label">  {{__('messages.lbl_male')}} </span>
                                    </div>
                                </label>
                                <label class="form-check form-control w-auto flex-grow-1 px-5 cursor-pointer">
                                    <div>
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ old('gender', $user->gender) == 'female' ? 'checked' : '' }} />
                                        <span class="form-check-label" for="female">  {{__('messages.lbl_female')}} </span>
                                    </div>
                                </label>
                                <label class="form-check form-control w-auto flex-grow-1 px-5 cursor-pointer">
                                    <div class="">
                                        <input class="form-check-input" type="radio" name="gender" id="other" value="other" {{ old('gender', $user->gender) == 'other' ? 'checked' : '' }} />
                                        <span class="form-check-label" for="other"> {{__('messages.lbl_other')}} </span>
                                    </div>
                                </label>
                            </div>
        
                            @error('gender')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="form-group col-md-12 text-end">
                {{ html()->submit(trans('messages.save'))->class('btn btn-md btn-primary float-right')->id('submit-button') }}
                    <!-- <button type="submit" class="btn btn-primary">{{ __('dashboard.lbl_submit') }}</button> -->
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@push('after-scripts')

@include('components.media-modal')


<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const container = document.getElementById('selectedImageContainerCastcerw');
            container.innerHTML = '';

            const imgElement = document.createElement('img');
            imgElement.src = reader.result;
            imgElement.classList.add('img-fluid', 'mb-2');

            const removeIcon = document.createElement('span');
            removeIcon.className = 'remove-media-icon';
            removeIcon.style.cursor = 'pointer';
            removeIcon.style.color = 'red';
            removeIcon.style.fontSize = '24px';
            removeIcon.textContent = '×';
            removeIcon.onclick = removeProfileImage;

            container.appendChild(imgElement);
            container.appendChild(removeIcon);
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    function removeProfileImage() {
        const container = document.getElementById('selectedImageContainerCastcerw');
        const hiddenInput = document.getElementById('file_url_image');

        container.innerHTML = '';
        hiddenInput.value = '';
    }
</script>
@endpush
