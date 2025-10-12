

@extends('setting::backend.setting.index')

@section('settings-content')

<div class="col-md-12 d-flex justify-content-between mb-4">
    <h4><i class="fa-solid fa-file-invoice"></i> {{ __('setting_sidebar.lbl_inv_setting') }}</h4>
</div>
<form method="POST" action="{{ route('backend.setting.store') }}">
    @csrf
      <div class="row gy-3">
        <div class="form-group col-md-6">
            <label class="form-label">{{ __('settings.lbl_order_prefix') }} <span class="text-danger">*</span></label>
            {!! html()->text('inv_prefix')
                ->class('form-control')
                ->placeholder('# - INV')
                ->value(old('inv_prefix', $data['inv_prefix'] ?? ''))
                ->required() !!}
            @error('inv_prefix')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label class="form-label">{{ __('settings.lbl_order_starts') }} <span class="text-danger">*</span></label>
            {!! html()->number('order_code_start')
                ->class('form-control')
                ->placeholder('1')
                ->value(old('order_code_start', $data['order_code_start'] ?? ''))
                ->required() !!}
            @error('order_code_start')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group col-12">
            <label class="form-label">{{ __('settings.lbl_spacial_note') }} <span class="text-danger">*</span></label>
            {!! html()->text('spacial_note')
                ->class('form-control')
                ->placeholder('Enter your spacial note')
                ->value(old('spacial_note', $data['spacial_note'] ?? ''))
                ->required() !!}
            @error('spacial_note')
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
