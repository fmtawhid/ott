@extends('backend.layouts.app')

@section('content')
<div class="card">
 <div class="card-body">
    {{ html()->form('POST' ,route('backend.currencies.store'))->attribute('enctype', 'multipart/form-data')->attribute('data-toggle', 'validator')->open() }}
        @csrf
        <div class="row">
            <div class="col-sm-6 mb-3">
                {{ html()->label(__('plan.lbl_name') . ' <span class="text-danger">*</span>', 'name')->class('form-control-label') }}
                {{ html()->text('name')
                        ->attribute('value', old('name'))  ->placeholder(__('placeholder.lbl_plan_name'))
                        ->class('form-control')
                    }}
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <a href="{{ route('backend.currencies.index') }}" class="btn btn-secondary">Close</a>
        {{ html()->submit(trans('messages.save'))->class('btn btn-md btn-primary float-right') }}
    {{ html()->form()->close() }}
  </div>
</div>
@endsection
