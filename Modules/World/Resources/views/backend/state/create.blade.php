@extends('backend.layouts.app')

@section('content')
<div class="card">
 <div class="card-body">
    {{ html()->form('POST' ,route('backend.state.store'))->attribute('enctype', 'multipart/form-data')->attribute('data-toggle', 'validator')->open() }}
      @csrf
      <div class="row">
        <div class="col-sm-6 mb-3">
            {{ html()->label('Country <span class="text-danger">*</span>', 'country_id')->class('form-label') }}
            {{ html()->select('country_id', $countries
            ->pluck('name', 'id'), old('country_id'))
            ->placeholder('Select Country')
            ->class('form-control')
            ->required()
            }}
            @error('country_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-sm-6 mb-3">
            {{ html()->label('Name <span class="text-danger">*</span>', 'name')->class('form-label') }}
            {{ html()->text('name')
                    ->value(old('name'))
                    ->placeholder('Enter name')
                    ->class('form-control')
                    ->required()
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
                html()->checkbox('status',old('status', false))
                    ->class('form-check-input')
                    ->id('status')
                }}
            </div>
            @error('status')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

      <a href="{{ route('backend.state.index') }}" class="btn btn-secondary">Close</a>
      {{ html()->submit(trans('messages.save'))->class('btn btn-md btn-primary float-right') }}
    {{ html()->form()->close() }}
  </div>
</div>
@endsection
