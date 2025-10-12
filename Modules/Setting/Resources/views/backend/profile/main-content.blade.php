{{-- resources/views/partials/main-content.blade.php --}}
<div class="col-md-8 col-lg-9 navbar-expand-md">
    <div class="card card-accent-primary mb-0">
        <div class="card-body">
            @yield('profile-content')
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggle() {
        const formOffcanvas = document.getElementById('offcanvas');
        formOffcanvas.classList.remove("show");
    }
</script>
@endpush
