@extends('backend.layouts.app')
@section('content')
<x-back-button-component route="backend.planlimitation.index" />
{{ html()->form('POST' ,route('backend.planlimitation.store'))
                                    ->attribute('enctype', 'multipart/form-data')
                                    ->attribute('data-toggle', 'validator')
                                    ->attribute('id', 'form-submit')  // Add the id attribute here
                                    ->class('requires-validation')  // Add the requires-validation class
                                    ->attribute('novalidate', 'novalidate')  // Disable default browser validation
                                    ->open()
                                }}
<div class="card">
    <div class="card-body">
        <div class="row gy-3">
            <div class="col-md-6">
                {{ html()->label(__('plan_limitation.lbl_title') . ' <span class="text-danger">*</span>', 'title')->class('form-label') }}
                {{ html()->text('title')
                            ->attribute('value', old('title'))  ->placeholder(__('placeholder.lbl_plan_limit_title'))
                            ->class('form-control')
                            ->attribute('required','required')
                        }}
                @error('title')
                <span class="text-danger">{{ $message }}</span>
                @enderror
                <div class="invalid-feedback" id="name-error">Title field is required</div>
            </div>
            <div class="col-md-6">
                {{ html()->label(__('plan.lbl_status'), 'status')->class('form-label') }}
                <div class="d-flex justify-content-between align-items-center form-control">
                    {{ html()->label(__('messages.active'), 'status')->class('form-label mb-0 text-body') }}
                    <div class="form-check form-switch">
                        {{ html()->hidden('status', 1) }}
                        {{
                        html()->checkbox('status', 1)
                            ->class('form-check-input')
                            ->id('status')
                    }}
                    </div>
                </div>
                @error('status')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-12">
                {{ html()->label(__('plan.lbl_description') . ' <span class="text-danger">*</span>', 'description')->class('form-label') }}
                {{ html()->textarea('description')
                            ->attribute('value', old('description'))->placeholder(__('placeholder.lbl_plan_limit_description'))
                            ->class('form-control')->rows('6')
                            ->attribute('required','required')
                        }}
                @error('description')
                <span class="text-danger">{{ $message }}</span>
                @enderror
                <div class="invalid-feedback" id="name-error">Description field is required</div>
            </div>
        </div>
    </div>
</div>
<div class="d-grid d-sm-flex justify-content-sm-end gap-3 mb-5">
 
    {{ html()->submit(trans('messages.save'))->class('btn btn-md btn-primary float-right')->id('submit-button') }} 
</div>
{{ html()->form()->close() }}

@endsection
