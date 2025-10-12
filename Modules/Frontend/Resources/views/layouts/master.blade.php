<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark" dir="{{ session()->has('dir') ? session()->get('dir') : 'ltr' }}" data-bs-theme-color={{ getCustomizationSetting('theme_color') }}>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="baseUrl" content="{{url('/')}}" />
    <link rel="icon" type="image/png" href="{{ GetSettingValue('favicon') ?? asset('img/logo/favicon.png')   }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ GetSettingValue('favicon') ?? asset('img/logo/favicon.png')  }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    @include('frontend::layouts.head')

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300&amp;display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('modules/frontend/style.css') }}">

    <link rel="stylesheet" href="{{ asset('iconly/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('phosphor-icons/regular/style.css') }}">
    <link rel="stylesheet" href="{{ asset('phosphor-icons/fill/style.css') }}">

    <link rel="stylesheet" href="{{ asset('css/customizer.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    
    @include('frontend::components.partials.head.plugins')
    @stack('after-styles')
    {{-- Vite CSS --}}
    {{-- {{ module_vite('build-frontend', 'resources/assets/sass/app.scss') }} --}}
</head>

<body class="d-flex flex-column min-vh-100 {{ Route::currentRouteName() == 'search' ? 'search-page' : '' }}">
    @include('frontend::layouts.header')

    <main class="flex-fill">
        @yield('content')
    </main>

    @include('frontend::layouts.footer')

    @include('frontend::components.partials.back-to-top')
    @include('frontend::components.partials.scripts.plugins')

    @if(session('success'))
    <script>
document.addEventListener('DOMContentLoaded', function() {
     document.body.setAttribute('data-swal2-theme', 'dark');
    Swal.fire({
        icon: 'success',
        title: "{{ session('success.title') }}",
        html: `
            <div class="text-center">
                <p>{{ session('success.message') }}</p>
                <div class="mt-3">
                    <p><strong>Plan:</strong> {{ session('success.plan_name') }}</p>
                    <p><strong>Amount:</strong> {{ session('success.amount') }}</p>
                    <p><strong>Valid Until:</strong> {{ session('success.valid_until') }}</p>
                </div>
            </div>
        `,
        showConfirmButton: true,
        confirmButtonText: 'Continue',
        confirmButtonColor: '#e50914', // Changed to Bootstrap's danger red
        iconColor: '#e50914', // Added to make the success icon red
        customClass: {
            icon: 'swal2-icon-red' // Added custom class for icon color
        }
    });
});
</script>

<style>
.swal2-icon-red {
    border-color: #e50914 !important;
    color: #e50914 !important;
}
</style>
    @endif

    @if(session('error'))
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
            confirmButtonColor: '#dc3545'
        });
    });
    </script>
    @endif

    @if(session('purchase_success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            html: `
                <div style="text-align: center; padding: 20px;">
                    <div style="font-size: 60px; color: #e50914;">&#10004;</div>
                    <h2 class=="text-heading" style="margin: 15px 0 10px; font-size: 21px;">Purchase Successful!</h2>
                    <p class="text-body" style="font-size: 16px;">You have successfully purchased access to this content.</p>
                    <p class="text-body" style="font-size: 14px;">Enjoy until {{ session('view_expiry') }}.</p>
                </div>
            `,
            showConfirmButton: true,
            confirmButtonText: 'Begin Watching',
            confirmButtonColor: 'var(--bs-gray-800)',
            background: 'var(--bs-body-bg)',
            color: 'var(--bs-heading-color)',
            customClass: {
                popup: 'swal2-custom-popup',
            },
            icon: undefined, // disables default icon
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('unlock.videos') }}";
            }
        });
    });
</script>
@endif

    <script src="{{ mix('modules/frontend/script.js') }}"></script>
    <script src="{{ mix('js/backend-custom.js') }}"></script>

    <!--- chrome cast  --->
    <script type="text/javascript" src="https://www.gstatic.com/cv/js/sender/v1/cast_sender.js?loadCastFramework=1"></script>
    <script type="text/javascript" src="https://www.gstatic.com/cv/js/sender/v1/cast_sender.js"></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    {{-- Vite JS --}}
    {{-- {{ module_vite('build-frontend', 'resources/assets/js/app.js') }} --}}
    @stack('after-scripts')
    <script>

const currencyFormat = (amount) => {
        const DEFAULT_CURRENCY = JSON.parse(@json(json_encode(Currency::getDefaultCurrency(true))))
         const noOfDecimal = DEFAULT_CURRENCY.no_of_decimal
         const decimalSeparator = DEFAULT_CURRENCY.decimal_separator
         const thousandSeparator = DEFAULT_CURRENCY.thousand_separator
         const currencyPosition = DEFAULT_CURRENCY.currency_position
         const currencySymbol = DEFAULT_CURRENCY.currency_symbol
        return formatCurrency(amount, noOfDecimal, decimalSeparator, thousandSeparator, currencyPosition, currencySymbol)
      }

      window.currencyFormat = currencyFormat
      window.defaultCurrencySymbol = @json(Currency::defaultSymbol())

    </script>
    <script>
        window.translations = {
    otp_send_success: @json(__('frontend.otp_send_success')),
    otp_send_error: @json(__('frontend.otp_send_error')),
    send_otp: @json(__('Send OTP')),
    sending: @json(__('frontend.sending')),
     send_otp: @json(__('frontend.send_otp')),
        }
</script>
</body>
</html>
