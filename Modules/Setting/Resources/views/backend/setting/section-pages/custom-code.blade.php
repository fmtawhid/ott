

@extends('setting::backend.setting.index')

@section('settings-content')
<form method="POST" action="{{ route('backend.setting.store') }}"  enctype="multipart/form-data">
    @csrf
    <div>
        <div class="d-flex justify-content-between align-items-center card-title">
            <h3 class="mb-3"><i class="fa-solid fa-file-code"></i> {{ __('setting_sidebar.lbl_custom_code') }}</h3>
        </div>
    </div>
    <div class="form-group">

        <label for="custom_css_block" class="form-label">{{ __('setting_custom_code.lbl_css_name') }} </label>
        {{ html()->textarea('custom_css_block')
                  ->class('form-control' . ($errors->has('custom_css_block') ? ' is-invalid' : ''))
                  ->value($data['custom_css_block'] ?? old('custom_css_block'))
                  ->placeholder(__('setting_custom_code.lbl_css_name'))
                  ->rows('5') }}
        @error('custom_css_block')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="form-group">
        <label for="custom_js_block" class="form-label">{{ __('setting_custom_code.lbl_js_name') }} </label>
        {{ html()->textarea('custom_js_block')
                  ->class('form-control' . ($errors->has('custom_js_block') ? ' is-invalid' : ''))
                  ->value($data['custom_js_block'] ?? old('custom_js_block'))
                  ->placeholder(__('setting_custom_code.lbl_js_name'))
                  ->rows('5') }}
        @error('custom_js_block')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="form-group text-end">
        <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
    </div>
</form>
@endsection

@push('scripts')
<script src="{{ asset('js/form-modal/index.js') }}" defer></script>
<script src="{{ asset('js/form/index.js') }}" defer></script>


@endpush
