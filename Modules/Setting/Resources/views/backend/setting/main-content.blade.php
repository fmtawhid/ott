
<div class="col-md-8 col-lg-9 navbar-expand-md">
    <div class="offcanvas offcanvas-end p-md-0" id="offcanvas" data-bs-backdrop="false">
        <div class="offcanvas-header">
            <h4 class="offcanvas-title" id="offcanvasNavbarLabel">Setting</h4>
            <button type="button" class="btn-close" onclick="toggle()"></button>
        </div>
        <div class="card card-accent-primary offcanvas-body mb-0">
            <div class="card-body">
                @yield('settings-content')
            </div>
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
