@extends('backend.layouts.app')
@section('content')

<form method="POST" id="form"
    action="{{ isset($data) ? route('backend.planlimitation.update', $data->id) : route('backend.planlimitation.store') }}"
    data-toggle="validator">
    @csrf
    @if (isset($data->id))
    @method('PUT')
    @endif
    <div class="row">
        <div class="col-sm-6 mb-3">
            <label for="title" class="form-label">{{ __('plan_limitation.lbl_title') }}<span class="text-danger">*</span></label>
            <input type="text" class="form-control" value="{{ old('title', $data->title ?? '') }}" name="title" id="title"
                placeholder="Enter Title">
            @error('title')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>


        <div class="col-sm-6 mb-3">
            <label for="description" class="form-label">{{ __('plan.lbl_description') }}</label>
            <textarea class="form-control" name="description" id="description"
                placeholder="Enter Description">{{ old('description', $data->description ?? '') }}</textarea>
            @error('description')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-sm-6 mb-3">
            <label for="status" class="form-label"> {{ __('plan.lbl_status') }}</label>
            <div class="form-check form-switch">
                <input type="hidden" name="status" value="0"> <!-- Hidden input field -->
                <input class="form-check-input" type="checkbox" id="status" name="status" value="1"
                    {{ old('status', $data->status ?? '') == 1 ? 'checked' : '' }}>
            </div>
            @error('status')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <a href="{{ route('backend.users.index') }}"><button type="button" class="btn btn-secondary">Close</button></a>
    <button type="submit" class="btn btn-primary">Save changes</button>
</form>

@section('scripts')
<script>
$(document).ready(function() {
    $('.select2').select2();
});
</script>
@endsection

@endsection