@extends('backend.layouts.app')

@section('content')
<div class="card">
 <div class="card-body">
    {{ html()->form('POST' ,route('backend.city.store'))->attribute('enctype', 'multipart/form-data')->attribute('data-toggle', 'validator')->open() }}
      @csrf
      <div class="row">
        <div class="col-sm-6 mb-3">
            {{ html()->label('State <span class="text-danger">*</span>', 'state_id')->class('form-label') }}
            {{ html()->select('state_id', $states->pluck('name', 'id'), old('state_id',))
                    ->placeholder('Enter name')
                    ->class('form-control')
                    ->required()}}
            @error('state_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-sm-6 mb-3">
            {{ html()->label('Name <span class="text-danger">*</span>', 'name')->class('form-label') }}
            {{ html()->text('name')
                    ->value(old('name', $data->name ?? ''))
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


      <a href="{{ route('backend.city.index') }}" class="btn btn-secondary">Close</a>
      {{ html()->submit(trans('messages.save'))->class('btn btn-md btn-primary float-right') }}
    {{ html()->form()->close() }}
  </div>
</div>
@endsection
