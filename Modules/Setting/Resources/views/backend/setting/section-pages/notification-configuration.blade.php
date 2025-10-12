@extends('setting::backend.setting.index')

@section('settings-content')
<!-- <form method="POST" action="{{ route('backend.setting.store') }}"> -->
{{ html()->form('POST', route('backend.setting.store'))
    ->attribute('data-toggle', 'validator')
    ->attribute('id', 'form-submit')  // Add the id attribute here
    ->class('requires-validation')  // Add the requires-validation class
    ->attribute('novalidate', 'novalidate')  // Disable default browser validation
    ->attribute('enctype', 'multipart/form-data')
    ->open()
}}
    @csrf

    <div class="card">
        <div class="card-header">
            <h4><i class="fa-solid fa-bell"></i> {{ __('setting_sidebar.lbl_notification_configuration') }}</h4>
        </div>
        <div class="card-body">
            <div class="row gy-3">

                <div class="col-lg-4">
                    {{ html()->label(__('messages.lbl_expiry_plan'). ' <span class="text-danger">*</span>')->class('form-label') }}
                    {{ html()->number('expiry_plan')
                        ->class('form-control')
                        ->placeholder(__('messages.lbl_expiry_plan') . ' ' . __('messages.days'))
                        ->value(old('expiry_plan', $settings['expiry_plan'] ?? ''))->required() }}
                    @error('expiry_plan')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="name-error">Expiry plan is required</div>
                </div>

                <div class="col-lg-4">
                    {{ html()->label(__('messages.lbl_upcoming'). ' <span class="text-danger">*</span>')->class('form-label') }}
                    {{ html()->number('upcoming')
                        ->class('form-control')
                        ->placeholder(__('messages.lbl_upcoming'). ' ' . __('messages.days'))
                        ->value(old('upcoming', $settings['upcoming'] ?? ''))->required() }}
                    @error('upcoming')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="name-error">Upcoming is required</div>
                </div>

                <div class="col-lg-4">
                    {{ html()->label(__('messages.lbl_continue_watch'). ' <span class="text-danger">*</span>')->class('form-label') }}
                    {{ html()->number('continue_watch')
                        ->class('form-control')
                        ->placeholder(__('messages.lbl_continue_watch'). ' ' . __('messages.days'))
                        ->value(old('continue_watch', $settings['continue_watch'] ?? ''))->required() }}
                    @error('continue_watch')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="name-error">Continue watch is required</div>
                </div>

            </div>
        </div>
        <div class="text-end">
            {{ html()->button(__('messages.save'))
                ->type('submit')
                ->class('btn btn-primary')->id('submit-button') }}
        </div>
    </div>
</form>

@endsection


