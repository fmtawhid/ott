@extends('backend.layouts.app')

@section('content')
<x-back-button-component route="backend.taxes.index" />
  {{ html()->form('POST' ,route('backend.taxes.update', $data->id))->attribute('enctype', 'multipart/form-data')->attribute('data-toggle', 'validator')
    ->attribute('id', 'form-submit')  // Add the id attribute here
    ->class('requires-validation')  // Add the requires-validation class
    ->attribute('novalidate', 'novalidate')  // Disable default browser validation
    ->open() }}
    <div class="card">
        <div class="card-body">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="row">
                    <div class="col-sm-6 mb-3">
                    {{ html()->label(__('tax.lbl_title') . ' <span class="text-danger">*</span>', 'title')->class('form-label') }}
                    {{ html()->text('title')
                            ->attribute('value', $data->title)
                            ->placeholder(__('tax.lbl_title'))
                            ->class('form-control')
                            ->required() }}
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="name-error">Title field is required</div>
                </div>
                <div class="col-sm-6 mb-3">
                    {{ html()->label(__('tax.lbl_Type') . ' <span class="text-danger">*</span>', 'type')->class('form-label') }}
                    {{ html()->select('type', ['Fixed' => 'Fixed', 'Percentage' => 'Percentage'])
                            ->class('form-control select2')
                            ->value($data->type) 
                            ->required() }}
                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="name-error">Type field is required</div>
                </div>
                <div class="col-sm-6 mb-3">
                    {{ html()->label(__('tax.lbl_value') . ' <span class="text-danger">*</span>', 'value')->class('form-label') }}
                    {{ html()->text('value')
                            ->attribute('value',$data->value)
                            ->placeholder(__('tax.lbl_value'))
                            ->class('form-control')
                            ->required() }}
                    @error('value')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="name-error">Value field is required</div>
                </div>
                <div class="col-sm-6 mb-3">
                    {{ html()->label(__('plan.lbl_status'), 'status')->class('form-label') }}
                        <div class="d-flex align-items-center justify-content-between form-control">
                            {{ html()->label(__('messages.active'), 'status')->class('form-label mb-0 text-body') }}
                            <div class="form-check form-switch">
                                {{ html()->hidden('status', 0) }}
                                {{
                                html()->checkbox('status',$data->status)
                                    ->class('form-check-input')
                                    ->id('status')
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
    </div>
    <div class="d-grid d-sm-flex justify-content-sm-end gap-3 mb-5">
        {{ html()->submit(trans('messages.save'))->class('btn btn-md btn-primary float-right')->id('submit-button') }}
    </div>
        {{ html()->form()->close() }}

@endsection
