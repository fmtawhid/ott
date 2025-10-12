
@extends('setting::backend.setting.index')

@section('settings-content')

<div class="mb-4">
    <h4><i class="fas fa-envelope"></i> {{ __('setting_sidebar.lbl_mail') }} </h4>
</div>
<form method="POST" action="{{ route('backend.setting.store') }}"id="other-settings-form">
    @csrf
      <div class="row">
        <div class="form-group col-md-6">
            <label class="form-label">{{ __('setting_mail_page.lbl_email') }} <span class="text-danger">*</span></label>
            {!! html()->email('email')
                ->class('form-control')
                ->placeholder('info@example.com')
                ->value(old('email', $data['email'] ?? ''))
                ->required() !!}
            @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label class="form-label">{{ __('setting_mail_page.lbl_driver') }} <span class="text-danger">*</span></label>
            {!! html()->text('mail_driver')
                ->class('form-control')
                ->placeholder('smtp')
                ->value(old('mail_driver', $data['mail_driver'] ?? ''))
                ->required() !!}
            @error('mail_driver')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label class="form-label">{{ __('setting_mail_page.lbl_host') }} <span class="text-danger">*</span></label>
            {!! html()->text('mail_host')
                ->class('form-control')
                ->placeholder('smtp.gmail.com')
                ->value(old('mail_host', $data['mail_host'] ?? ''))
                ->required() !!}
            @error('mail_host')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label class="form-label">{{ __('setting_mail_page.lbl_port') }} <span class="text-danger">*</span></label>
            {!! html()->number('mail_port')
                ->class('form-control')
                ->placeholder('587')
                ->value(old('mail_port', $data['mail_port'] ?? ''))
                ->required() !!}
            @error('mail_port')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label class="form-label">{{ __('setting_mail_page.lbl_encryption') }} <span class="text-danger">*</span></label>
            {!! html()->text('mail_encryption')
                ->class('form-control')
                ->placeholder('tls')
                ->value(old('mail_encryption', $data['mail_encryption'] ?? ''))
                ->required() !!}
            @error('mail_encryption')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label class="form-label">{{ __('setting_mail_page.lbl_username') }} <span class="text-danger">*</span></label>
            {!! html()->text('mail_username')
                ->class('form-control')
                ->placeholder('youremail@gmail.com')
                ->value(old('mail_username', $data['mail_username'] ?? ''))
                ->required() !!}
            @error('mail_username')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label class="form-label">{{ __('setting_mail_page.lbl_password') }} <span class="text-danger">*</span></label>
            {!! html()->password('mail_password')
                ->class('form-control')
                ->placeholder('Password')
                ->required() !!}
            @error('mail_password')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label class="form-label">{{ __('setting_mail_page.lbl_mail') }} <span class="text-danger">*</span></label>
            {!! html()->email('mail_from')
                ->class('form-control')
                ->placeholder('youremail@gmail.com')
                ->value(old('mail_from', $data['mail_from'] ?? ''))
                ->required() !!}
            @error('mail_from')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label class="form-label">{{ __('setting_mail_page.lbl_from_name') }} <span class="text-danger">*</span></label>
            {!! html()->text('from_name')
                ->class('form-control')
                ->placeholder('Streamit-Laravel')
                ->value(old('from_name', $data['from_name'] ?? ''))
                ->required() !!}
            @error('from_name')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="form-group text-end">
        <button type="submit" class="btn btn-primary float-right">
         {{ __('messages.save') }}
        </button>
      </div>
</form>



@endsection
