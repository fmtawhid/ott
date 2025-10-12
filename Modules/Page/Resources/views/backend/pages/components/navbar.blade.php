@section('navbar')
<!-- Example Navbar HTML Structure -->
<nav
class="nav navbar navbar-expand-xl navbar-light iq-navbar header-hover-menu left-border {{ !empty(getCustomizationSetting('navbar_show')) ? getCustomizationSetting('navbar_show') : '' }} {{ getCustomizationSetting('header_navbar') }}">
    <div class="container-fluid navbar-inner">
    <a href="{{ route('backend.home') }}" class="navbar-brand">
            <div class="logo-main">
                <div class="logo-mini d-none">

                    @php
                       $mini_logo=GetSettingValue('mini_logo') ??  asset(setting('mini_logo'));
                    @endphp

                    <img src="{{  $mini_logo }}" height="30" alt="{{ app_name() }}">
                </div>

                <div class="logo-dark">
                    @php
                    $dark_logo=GetSettingValue('dark_logo') ??  asset(setting('dark_logo'));
                 @endphp
                    <img src="{{ asset(setting('dark_logo')) }}" height="30" alt="{{ app_name() }}">
                </div>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                {{-- YIELD NAV-ITEMS --}}
                @yield('nav-item')

            </ul>
        </div>
    </div>
</nav>

@endsection
