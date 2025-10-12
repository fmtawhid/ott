@extends('backend.layouts.app')

@section('content')

    <p class="text-danger" id="error_message"></p>

    <form action="{{ route('backend.settings.fcm.store') }}" method="POST" enctype="multipart/form-data" class="requires-validation" id="form-submit" novalidate>
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row gy-3">

                    <div class="col-md-6">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Enter title" value="{{ old('title') }}" required>
                        <div class="invalid-feedback" id="title-error">Title field is required</div>
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    
                    <div class="col-md-6">
                        <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                        <input type="text" name="message" id="message" class="form-control" placeholder="Enter message" value="{{ old('message') }}" required>
                        <div class="invalid-feedback" id="message-error">Message field is required</div>
                        @error('message')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- <div class="col-md-6">
                        <label for="image" class="form-label">Image (optional)</label>
                        <div class="input-group">
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        @if(old('image'))
                            <div class="mt-2">
                                <img src="{{ old('image') }}" alt="Selected Image" class="img-fluid" style="max-width:100px;">
                            </div>
                        @endif
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div> -->

                </div>
            </div>
        </div>

        <div class="d-grid d-sm-flex justify-content-sm-end gap-3 mt-3">
            <button type="submit" class="btn btn-md btn-primary" id="submit-button">Create Notification</button>
        </div>
    </form>

@endsection

@push('after-scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK'
        });
    @endif
</script>
@endpush
