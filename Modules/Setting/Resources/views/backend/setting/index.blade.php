@extends('backend.layouts.app')

@section('content')

        <div class="row mb-5">
            @include('setting::backend.setting.sidebar-panel')
            @include('setting::backend.setting.main-content')
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

<script>
 document.addEventListener('DOMContentLoaded', function () {

    if (window.innerWidth <= 1024) {
        const offcanvas = document.getElementById('offcanvas');
        if (offcanvas) {
            offcanvas.classList.add('show');
            offcanvas.style.visibility = 'visible'; // Ensure visibility is set correctly
            offcanvas.style.transform = 'translateX(0)'; // Optional for proper animation
        }

   function toggle() {
        const formOffcanvas = document.getElementById('offcanvas');
        formOffcanvas.classList.remove("show");
    }
}

    });

    function toggle() {
        const offcanvas = document.getElementById('offcanvas');
        if (offcanvas) {
            if (offcanvas.classList.contains('show')) {
                offcanvas.classList.remove('show');
                offcanvas.style.visibility = 'hidden';
                offcanvas.style.transform = 'translateX(100%)'; // Hide offcanvas
            } else {
                offcanvas.classList.add('show');
                offcanvas.style.visibility = 'visible';
                offcanvas.style.transform = 'translateX(0)'; // Show offcanvas
            }
        }
    }





</script>

@endpush



@endsection


