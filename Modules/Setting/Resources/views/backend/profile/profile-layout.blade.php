@extends('backend.layouts.app')


@section('content')
    <div class="card">
        <div class="row">
            @include('setting::backend.profile.sidebar-panel')
            @include('setting::backend.profile.main-content')
        </div>
    </div>
    @if(session('success'))
<div class="snackbar" id="snackbar">

    <div class="d-flex justify-content-around align-items-center">
        <p class="mb-0">{{ session('success') }}</p>
        <a href="#" class="dismiss-link text-decoration-none text-success" onclick="dismissSnackbar(event)">Dismiss</a>
    </div>
</div>
@endif

@push('after-scripts')
<script src="{{ asset('js/form-modal/index.js') }}" defer></script>
<script src="{{ asset('js/form/index.js') }}" defer></script>

@endpush
@endsection




@push ('after-styles')


@endpush
