<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ app_name() }}</title>

    <link rel="icon" type="image/png" href="{{ GetSettingValue('favicon') ?? asset('img/logo/favicon.png')   }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ GetSettingValue('favicon') ?? asset('img/logo/favicon.png')  }}">
    <meta name="setting_options" content="{{ setting('customization_json') }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/backend.css') }}">
    <link rel="stylesheet" href="{{ asset('custom-css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customizer.css') }}">
    @if (isset($styles))
        {{ $styles }}
    @endif

    <style>
      {!! setting('custom_css_block') !!}
    </style>
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
</head>

<body>
    <!-- Loader Start -->
    <div id="loading">
        <x-partials._body_loader />
    </div>
    <!-- Loader End -->
    <div>
        {{ $slot }}
    </div>
    <!-- Scripts -->
    <script src="{{ mix('js/backend.js') }}"></script>

    @if (isset($scripts))
        {{ $scripts }}
    @endif

    <script>
      {!! setting('custom_js_block') !!}
    </script>
</body>

</html>
