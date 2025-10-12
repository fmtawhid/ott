<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"  data-bs-theme="dark" dir="{{ language_direction() }}" class="theme-fs-md">
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
    <link rel="shortcut icon" href="{{ asset(setting('favicon')) }}">
    <link rel="icon" type="image/ico" href="{{ asset(setting('favicon')) }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app_name" content="{{ app_name() }}">

    <meta name="data_table_limit" content="{{ setting('data_table_limit') }}">

    @if(auth()->check())
    <meta name="auth_user_roles" content="{{auth()->user()->roles->pluck('name')}}">
    @endif


    <title>@yield('title') | {{ app_name() }}</title>

    <link rel="stylesheet" href="{{ mix('css/icon.min.css') }}">
    @if ($isNoUISlider ?? '')
        <!-- NoUI Slider css -->
        <link rel="stylesheet" href="{{ asset('vendor/noUiSilder/style/nouislider.min.css') }}">
    @endif

    @stack('before-styles')
    <link rel="stylesheet" href="{{ mix('css/libs.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/backend.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dark.css') }}">
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
      @endphp
      <script>
        window.localMessagesUpdate = {
          ...window.localMessagesUpdate,
          "{{ $fileName }}": @json(require($filePath))
        }
      </script>
    @endforeach

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap" rel="stylesheet">
    {{-- <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca&display=swap" rel="stylesheet"> --}}

    @stack('after-styles')

    <x-google-analytics />

    <style>
      {!! setting('custom_css_block') !!}
    </style>
</head>

<body class="{{ !empty(getCustomizationSetting('card_style')) ? getCustomizationSetting('card_style') : '' }} {{ auth()->user()->user_setting['theme_scheme'] ?? '' }}">
    <!-- Loader Start -->
    <div id="loading">
        <x-partials._body_loader />
    </div>
    <!-- Loader End -->
    <!-- Sidebar -->

    <!-- /Sidebar -->
    <div class="main-content wrapper">
        <div class="position-relative  {{ !isset($isBanner) ? 'iq-banner' : '' }} default ">
            <!-- Header -->
            <nav class="nav navbar navbar-expand-xl navbar-light iq-navbar header-hover-menu left-border {{ !empty(getCustomizationSetting('navbar_show')) ? getCustomizationSetting('navbar_show') : '' }} {{ getCustomizationSetting('header_navbar') }}">
                <div class="container-fluid navbar-inner">
                        <a href="{{route('backend.home')}}" class="navbar-brand">
                            <div class="logo-main">
                                <div class="logo-mini d-none">
                                    <img src="{{asset(setting('mini_logo'))}}" height="30" alt="{{ app_name() }}">
                                </div>
                                <div class="logo-normal">
                                    <img src="{{ asset(setting('mini_logo')) }}" height="30" alt="{{ app_name() }}">
                                    {{-- <h4 class="logo-title d-none d-sm-block">{{app_name()}}</h4> --}}
                                </div>
                            </div>
                        </a>
                        @php
                        $get_pages = \Modules\Page\Models\Page::get();
                        @endphp
                        <!-- <div class="menu">
                            <ul class="list-inline d-flex align-items-center m-0">
                                @foreach($get_pages as $page)
                                <li>{{ $page->name}}</li>
                                @endforeach
                            </ul>
                        </div> -->

                        <div class="right-data">
                            <div class="d-flex align-items-center">
                                <button id="navbar-toggle" class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                                    aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon">
                                        <span class="navbar-toggler-bar bar1 mt-1"></span>
                                        <span class="navbar-toggler-bar bar2"></span>
                                        <span class="navbar-toggler-bar bar3"></span>
                                    </span>
                                </button>
                            </div>
                            <div class="collapse navbar-collapse header-right-panel" id="navbarSupportedContent">
                                <ul class="iq-nav-menu list-unstyled">

                                    @foreach($get_pages as $page)
                                    <li class="nav-item"><a class="nav-link" href="{{route('backend.copyurl', $page->slug)}}">{{ $page->name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                </div>
            </nav>
            <!-- /Header -->
            @if (!isset($isBanner))
            <!-- Header Banner Start-->



            <!-- Header Banner End-->
            @endif
        </div>

        <div class="conatiner-fluid content-inner pb-0" id="page_layout">

            {{-- @include('flash::message') --}}

            <!-- Errors block -->
            {{-- @include('backend.includes.errors') --}}
            <!-- / Errors block -->
            <!-- Main content block -->
            @yield('content')
            <!-- / Main content block -->
        </div>


    </div>

</body>

</html>
