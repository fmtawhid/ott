@extends('backend.layouts.app')
@section('content')
<x-back-button-component route="backend.users.index" />

   {{ html()->form('POST' ,route('backend.users.update_password', $id))
    ->attribute('enctype', 'multipart/form-data')
    ->attribute('data-toggle', 'validator')
    ->attribute('id', 'form-submit')  // Add the id attribute here
    ->class('requires-validation')  // Add the requires-validation class
    ->attribute('novalidate', 'novalidate')  // Disable default browser validation
    ->open() }}
    @csrf
        <div class="card">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-6 col-lg-4">
                        <label for="old_password" class="form-label">{{ __('users.lbl_old_password') }}<span class="text-danger">*</span></label>
                        <input type="password" class="form-control" value="{{ old('old_password', $data->old_password ?? '') }}"
                            name="old_password" id="old_password" placeholder="{{__('messages.enter_old_password')}}" required>
                            <div class="invalid-feedback" id="name-error">Old password field is required</div>
                        @error('old_password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <label for="password" class="form-label">{{ __('users.lbl_new_password') }}<span class="text-danger">*</span></label>
                        <input type="password" class="form-control" value="{{ old('password', $data->password ?? '') }}"
                            name="password" id="password" placeholder="{{__('messages.enter_new_password')}}" required>
                            <div class="invalid-feedback" id="name-error">Password field is required</div>
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <label for="password_confirmation" class="form-label">{{ __('users.lbl_confirm_password') }}<span
                                class="text-danger">*</span></label>
                        <input type="password" class="form-control"
                            value="{{ old('password_confirmation', $data->password_confirmation ?? '') }}"
                            name="password_confirmation" id="password_confirmation" placeholder="{{__('messages.enter_confirm_password')}}" required>
                            <div class="invalid-feedback" id="name-error">Confirm Password field is required</div>
                            @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="d-grid d-sm-flex justify-content-sm-end gap-3 mb-5">
            {{ html()->submit(trans('messages.save'))->class('btn btn-md btn-primary float-right')->id('submit-button') }}
        </div>

        {{ html()->form()->close() }}
@endsection
