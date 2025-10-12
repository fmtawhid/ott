@extends('backend.layouts.app')

@section('content')
<div class="card">
  <div class="card-body">
  {{ html()->form('POST' ,route('backend.country.update', $data->id))->attribute('enctype', 'multipart/form-data')->attribute('data-toggle', 'validator')->open() }}
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-sm-6 mb-3">
                {{ html()->label(__('plan.lbl_name') . ' <span class="text-danger">*</span>', 'name')->class('form-control-label') }}
            {{ html()->text('name')
                        ->attribute('value', $data->name)  ->placeholder(__('placeholder.lbl_plan_name'))
                        ->class('form-control')
                    }}
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-sm-6 mb-3">
                {{ html()->label(__('plan.lbl_status'), 'status')->class('form-label') }}
                <div class="form-check form-switch">
                    {{ html()->hidden('status', 0) }}
                    {{
                    html()->checkbox('status',$data->status)
                        ->class('form-check-input')
                        ->id('status')
                }}
                </div>
                @error('status')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <a href="{{ route('backend.country.index') }}" class="btn btn-secondary">Close</a>
        {{ html()->submit(trans('messages.save'))->class('btn btn-md btn-primary float-right') }}
        {{ html()->form()->close() }}
  </div>
</div>
@endsection
