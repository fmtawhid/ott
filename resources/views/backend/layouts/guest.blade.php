<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-bs-theme="dark" dir="{{ language_direction() }}" class="theme-fs-sm" data-bs-theme-color={{ getCustomizationSetting('theme_color') }}>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ GetSettingValue('favicon') ?? asset('img/logo/favicon.png')   }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ GetSettingValue('favicon') ?? asset('img/logo/favicon.png')  }}">
    <meta name="keyword" content="{{ setting('meta_keyword') }}">
    <meta name="description" content="{{ setting('meta_description') }}">
    <meta name="setting_options" content="{{ setting('customization_json') }}">

    <!-- Shortcut Icon -->


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app_name" content="{{ app_name() }}">

    <title>@yield('title') | {{ app_name() }}</title>

    <link rel="stylesheet" href="{{ mix('css/icon.min.css') }}">
    @stack('before-styles')
    <link rel="stylesheet" href="{{ mix('css/libs.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/backend.css') }}">
    <link rel="stylesheet" href="{{ asset('custom-css/dashboard.css') }}">

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
        body {
            font-family: Inter, Arial, Helvetica, sans-serif
        }
    </style>

    @stack('after-styles')

    <style>
      {!! setting('custom_css_block') !!}
    </style>

</head>

<body>
    <!-- Loader Start -->
    <div id="loading">
        <x-partials._body_loader />
    </div>
    <!-- Loader End -->
    <div class="main-content wrapper">
        <div class="conatiner-fluid content-inner pb-0" id="page_layout" data-render="app">

            @include('flash::message')

            <!-- Errors block -->
            @include('backend.includes.errors')
            <!-- / Errors block -->

            <!-- Main content block -->
            @yield('content')
            <!-- / Main content block -->
        </div>
    </div>

    <!-- Scripts -->
    @stack('before-scripts')
    <script src="{{ mix('js/backend.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    @if (isset($assets) && (in_array('textarea', $assets) || in_array('editor', $assets)))
        <script src="{{ asset('vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ asset('vendor/tinymce/js/tinymce/jquery.tinymce.min.js') }}"></script>
    @endif

    @stack('after-scripts')
    <!-- / Scripts -->

    <script>
      {!! setting('custom_js_block') !!}
    </script>

</body>

</html>
