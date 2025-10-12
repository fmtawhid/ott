@extends('backend.layouts.app')

@section('content')
<x-back-button-component route="backend.constants.index" />
{{ html()->form('PUT', route('backend.constants.update', $data->id))
        ->attribute('enctype', 'multipart/form-data')
        ->attribute('data-toggle', 'validator')
        ->attribute('id', 'form-submit')  // Add the id attribute here
        ->class('requires-validation')  // Add the requires-validation class
        ->attribute('novalidate', 'novalidate')  // Disable default browser validation
        ->open()
}}
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-body">
            <div class="row gy-3">
                <!-- Name Field -->
                <div class="col-md-6">
                    {{ html()->label(__('constant.lbl_name') . ' <span class="text-danger">*</span>', 'name')->class('form-control-label') }}
                    {{ html()->text('name')
                             ->value($data->name)
                             ->placeholder(__('constant.lbl_name'))
                             ->class('form-control')
                             ->required() }}
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="name-error">Name field is required</div>
                </div>
        
                <!-- Type Field (Dropdown) -->
                <div class="col-md-6">
                    {{ html()->label(__('constant.lbl_type') . ' <span class="text-danger">*</span>', 'type')->class('form-control-label') }}
                    <select name="type" class="form-control select2" required>
                        <option value="">{{ __('constant.select_type') }}</option>
                        @foreach($types as $type)
                            <option value="{{ $type }}" {{ $data->type == $type ? 'selected' : '' }}>
                                {{ $type == 'video_quality' ? __('constant.video_quality') : ($type == 'movie_language' ? __('constant.movie_language') : ($type == 'upload_type' ? __('constant.UPLOAD_URL_TYPE') : $type)) }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="name-error">Type field is required</div>
                </div>
        
                <!-- Value Field -->
                <div class="col-md-6">
                    {{ html()->label(__('constant.lbl_value') . ' <span class="text-danger">*</span>', 'value')->class('form-control-label') }}
                    {{ html()->text('value')
                             ->value($data->value)
                             ->placeholder(__('constant.lbl_value'))
                             ->class('form-control')
                             ->required() }}
                    @error('value')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="name-error">Value field is required</div>
                </div>
        
                <!-- Status Field -->
                <div class="col-md-6">
                    {{ html()->label(__('plan.lbl_status'), 'status')->class('form-label') }}
                    <div class="d-flex align-items-center justify-content-between form-control">
                        {{ html()->label(__('messages.active'), 'status')->class('form-label mb-0 text-body') }}
                        <div class="form-check form-switch">
                            {{ html()->hidden('status', 0) }}
                            {{
                                html()->checkbox('status', old('status', $data->status ?? 0))
                                    ->class('form-check-input')
                                    ->id('status')
                                    ->value(1)
                            }}
                        </div>
                    </div>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="d-grid d-sm-flex justify-content-sm-end gap-3 mb-5">
   
        <button type="submit" class="btn btn-primary" id="submit-button">Save</button>
    </div>
    {{ html()->form()->close() }}
@endsection
