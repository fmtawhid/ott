<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ language_direction() }}" class="theme-fs-sm">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset(setting('favicon')) }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset(setting('favicon')) }}">

    <!-- Shortcut Icon -->
    <link rel="shortcut icon" href="{{ asset(setting('favicon')) }}">
    <link rel="icon" type="image/ico" href="{{ asset(setting('favicon')) }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app_name" content="{{ app_name() }}">

    <title>@yield('title') | {{ app_name() }}</title>

    <!-- <link rel="stylesheet" href="{{ mix('css/icon.min.css') }}"> -->
    @stack('before-styles')
    <!-- <link rel="stylesheet" href="{{ mix('css/libs.min.css') }}"> -->
    <link rel="stylesheet" href="{{asset('vendor/flatpickr/flatpickr.min.css')}}">
    <link rel="stylesheet" href="{{ mix('css/backend.css') }}">

    @if(language_direction() == 'rtl')
      <link rel="stylesheet" href="{{ asset('css/rtl.css') }}">
    @endif

    <link rel="stylesheet" href="{{ asset('css/customizer.css') }}">


    <style>
        :root{
          <?php
            $rootColors = setting('root_colors'); // Assuming the setting() function retrieves the JSON string

            // Check if the JSON string is not empty and can be decoded
            if (!empty($rootColors) && is_string($rootColors)) {
                $colors = json_decode($rootColors, true);

                // Check if decoding was successful and the colors array is not empty
                if (json_last_error() === JSON_ERROR_NONE && is_array($colors) && count($colors) > 0) {
                    foreach ($colors as $key => $value) {
                        echo $key . ': ' . $value . '; ';
                    }
                } else {
                    echo 'Invalid JSON or empty colors array.';
                }
            }
            ?>

        }
    </style>

    <style type="text/css" media="print">
      @page :footer {
        display: none !important;
      }

      @page :header {
        display: none !important;
      }
      @page { size: landscape; }
      /* @page { margin: 0; } */
      button {
        display: none !important;
      }
      .non-printable {
        display: none !important;
      }
      * {
        -webkit-print-color-adjust: none !important;   /* Chrome, Safari 6 – 15.3, Edge */
        color-adjust: none !important;                 /* Firefox 48 – 96 */
        print-color-adjust: none !important;           /* Firefox 97+, Safari 15.4+ */
      }
    </style>

    <!-- Scripts -->
    @php
        $currentLang = App::currentLocale();
        $langFolderPath = base_path("lang/$currentLang");
        $filePaths = \File::files($langFolderPath);
      @endphp

    @foreach ($filePaths as $filePath)
      @php
        $fileName = pathinfo($filePath, PATHINFO_FILENAME);

        $arr = require($filePath);
        $dbLang = Modules\Language\Models\Language::getAllLang()->where('language', app()->getLocale())
            ->where('file', $fileName)
            ->pluck('value', 'key')
            ->toArray();
            if(count($dbLang) > 0) {
              $arr = array_merge($arr, $dbLang);
            }
      @endphp
      <script>
        window.localMessagesUpdate = {
          ...window.localMessagesUpdate,
          "{{ $fileName }}": @json($arr)
        }
      </script>
    @endforeach


    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <style>
        /* width */
        ::-webkit-scrollbar {
          width: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
          background: transparent;
        }

        ::-webkit-scrollbar-thumb {
          background: rgba(var(--bs-white-rgb), .2);
          border-radius: 50rem;
          width: 2px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
          background: rgba(var(--bs-white-rgb), .4);
          width: 2px;
          border-radius: 50rem;
        }
        /* Handle */
        .widget-pannel ::-webkit-scrollbar-thumb {
          background: rgba(var(--bs-primary-rgb), .2);
          border-radius: 50rem;
          width: 2px;
        }

        /* Handle on hover */
        .widget-pannel ::-webkit-scrollbar-thumb:hover {
          background: rgba(var(--bs-primary-rgb), .4);
          width: 2px;
          border-radius: 50rem;
        }
    </style>

    @stack('after-styles')

    <style>
      {!! setting('custom_css_block') !!}
    </style>

</head>

<body>
    <div class="main-content wrapper">
        <div class="" id="page_layout" data-render="app">
          <!-- Main content block -->
          @yield('content')
          <!-- / Main content block -->
        </div>
    </div>

    <!-- Scripts -->
    @stack('before-scripts')
    @stack('after-scripts')
    <!-- / Scripts -->

    <script>
      {!! setting('custom_js_block') !!}
    </script>

    <script>
      function formatCurrency(number, noOfDecimal, decimalSeparator, thousandSeparator, currencyPosition, currencySymbol) {
        // Convert the number to a string with the desired decimal places
        let formattedNumber = number.toFixed(noOfDecimal)

        // Split the number into integer and decimal parts
        let [integerPart, decimalPart] = formattedNumber.split('.')

        // Add thousand separators to the integer part
        integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, thousandSeparator)

        // Set decimalPart to an empty string if it is undefined
        decimalPart = decimalPart || ''

        // Construct the final formatted currency string
        let currencyString = ''

        if (currencyPosition === 'left' || currencyPosition === 'left_with_space') {
          currencyString += currencySymbol
          if (currencyPosition === 'left_with_space') {
            currencyString += ' '
          }
          currencyString += integerPart
          // Add decimal part and decimal separator if applicable
          if (noOfDecimal > 0) {
            currencyString += decimalSeparator + decimalPart
          }
        }

        if (currencyPosition === 'right' || currencyPosition === 'right_with_space') {
          // Add decimal part and decimal separator if applicable
          if (noOfDecimal > 0) {
            currencyString += integerPart + decimalSeparator + decimalPart
          }
          if (currencyPosition === 'right_with_space') {
            currencyString += ' '
          }
          currencyString += currencySymbol
        }

        return currencyString
      }



    </script>

</body>

</html>
