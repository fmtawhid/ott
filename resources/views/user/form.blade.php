
@extends('backend.layouts.app')
@section('content')
<form method="POST" id="form" action="{{ isset($data) ? route('backend.taxes.update', $data->id) : route('backend.taxes.store') }}" enctype="multipart/form-data">
    @csrf
    @if (isset($data->id))
        @method('PUT')
    @endif
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <label for="title" class="form-label">Title<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" value="{{ old('title', $data->title ?? '') }}" name="title" id="title" placeholder="Enter title" required>
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="type" class="form-label">Type<span class="text-danger">*</span></label>
                    <select class="form-control" name="type" id="type" required>
                        <option value="fixed" {{ old('type', $data->type ?? '') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                        <option value="percentage" {{ old('type', $data->type ?? '') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                    </select>
                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="value" class="form-label">Value<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" value="{{ old('value', $data->value ?? '') }}" name="value" id="value" placeholder="Enter value" required>
                    @error('value')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <div class="form-check form-switch">
                        <input type="hidden" name="status" value="0"> <!-- Hidden input field -->
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status', $data->status ?? '') == 1 ? 'checked' : '' }}>
                    </div>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer">
            {{-- <a href="{{ route('backend.taxes.index') }}" class="btn btn-secondary">Close</a> --}}
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </div>
</form>

@endsection

