@extends('setting::backend.profile.profile-layout')

@section('profile-content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-key"></i> {{ __('messages.change_password') }}</h2>
    </div>

    <form method="POST" action="{{ route('backend.profile.change_password') }}" class="requires-validation" novalidate id="form-submit">
        @csrf

        <div class="form-group">
            <label class="form-label" for="old_password">{{ __('users.lbl_password') }}</label>
            <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" name="old_password" placeholder="{{__('messages.enter_old_password')}}" required>
            @error('old_password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="invalid-feedback" id="old-pass-error">Old password field is required</div>
        </div>

        <div class="form-group">
            <label class="form-label" for="new_password">{{ __('messages.lbl_new_password') }}</label>
            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" placeholder="{{__('messages.enter_new_password')}}"  required>
            @error('new_password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="invalid-feedback" id="new-pass-error">New password field is required</div>
        </div>

        <div class="form-group">
            <label class="form-label" for="confirm_password">{{ __('users.lbl_confirm_password') }}</label>
            <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" placeholder="{{__('messages.enter_confirm_password')}}" required>
            @error('confirm_password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="invalid-feedback" id="confirm-pass-error">Confirm password field is required</div>
            <div class="invalid-feedback d-none " id="confirm-pass-match-error" >Confirm password not match.</div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary" id="submit-button" disabled>
                {{ __('dashboard.lbl_submit') }}
            </button>
        </div>
    </form>
</div>

<script>
    const newPasswordField = document.getElementById('new_password');
    const confirmPasswordField = document.getElementById('confirm_password');
    const submitButton = document.getElementById('submit-button');
    const confirmError = document.getElementById('confirm-pass-error');
    const confirmMatchError = document.getElementById('confirm-pass-match-error');
    function validatePasswords() {
        const newPassword = newPasswordField.value;
        const confirmPassword = confirmPasswordField.value;

        if (newPassword == confirmPassword) {
            confirmMatchError.style.display = 'none';
            confirmMatchError.classList.add('d-none');
            submitButton.disabled = false;  // Disable the submit button
        } else {
            if (confirmPassword.value === '') {
                        confirmError.style.display = 'block';
                        confirmMatchError.style.display = 'none';
                        confirmMatchError.classList.add('d-none');
                        return false;
            } else {
                confirmError.style.display = 'none';
                submitButton.disabled = false;
                if (newPassword !== confirmPassword) {
                    confirmMatchError.style.display = 'block';
                    confirmMatchError.classList.remove('d-none');
                    submitButton.disabled = true;  // Enable the submit button
                    return false;
                } 
            }
            
        }
    }

    // Add oninput event listeners to both fields
    newPasswordField.addEventListener('input', validatePasswords);
    confirmPasswordField.addEventListener('input', validatePasswords);
</script>

@endsection



