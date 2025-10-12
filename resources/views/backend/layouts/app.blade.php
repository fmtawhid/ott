<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-bs-theme="dark" dir="{{ language_direction() }}" class="theme-fs-sm" data-bs-theme-color={{ getCustomizationSetting('theme_color') }}>



<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ GetSettingValue('favicon') ?? asset('img/logo/favicon.png')   }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ GetSettingValue('favicon') ?? asset('img/logo/favicon.png')  }}">
    <meta name="setting_options" content="{{ setting('customization_json') }}">
    <meta name="base-url" content="{{ env('APP_URL') }}">

    @include('seo::layouts.header')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app_name" content="{{ app_name() }}">
    <meta name="data_table_limit" content="{{ setting('data_table_limit') }}">
    <meta name="auth_user_roles" content="{{ auth()->user()->roles->pluck('name') }}">

    <link rel="stylesheet" href="{{ mix('css/icon.min.css') }}">

    @stack('before-styles')
    <link rel="stylesheet" href="{{ mix('css/libs.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/backend.css') }}">
    <link rel="stylesheet" href="{{ mix('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('custom-css/dashboard.css') }}">

    @if (language_direction() == 'rtl')
        <link rel="stylesheet" href="{{ asset('css/rtl.css') }}">
    @endif

    <link rel="stylesheet" href="{{ asset('css/customizer.css') }}">
</head>

    <style>
        :root {
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
 @endphp
 <script>
   window.localMessagesUpdate = {
     ...window.localMessagesUpdate,
     "{{ $fileName }}": @json($arr)
   }
 </script>
@endforeach

     @php
    $role = !empty(auth()->user()) ? auth()->user()->getRoleNames() : null;
    $permissions = auth()->user()->getAllPermissions()->pluck('name')->toArray()
    @endphp
    <script>
        window.auth_role = @json($role);
        window.auth_permissions = @json($permissions)
    </script>
    <!-- Google Font -->

    <link rel="stylesheet" href="{{ asset('iconly/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('phosphor-icons/regular/style.css') }}">
    <link rel="stylesheet" href="{{ asset('phosphor-icons/fill/style.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
   @stack('after-styles')

    <x-google-analytics />

    <style>
        {!! setting('custom_css_block') !!}
    </style>
</head>

<body
    class="{{ !empty(getCustomizationSetting('card_style')) ? getCustomizationSetting('card_style') : '' }}">
    <!-- Loader Start -->
    <div id="loading">
        <x-partials._body_loader />
    </div>
    <!-- Loader End -->
    <!-- Sidebar -->
    @if (!isset($noLayout) || !$noLayout)

        @include('backend.includes.sidebar')
    @endif

    <!-- /Sidebar -->

    @yield('navbars')

    <div class="main-content wrapper">
        @if (!isset($noLayout) || !$noLayout)

        <div class="position-relative pr-hide
{{ !isset($isBanner) ? 'iq-banner' : '' }} default">
            <!-- Header -->
            @include('backend.includes.header')
            <!-- /Header -->
            @if (!isset($isBanner))
                <!-- Header Banner Start-->

                    @include('components.partials.sub-header')

                <!-- Header Banner End-->
            @endif
        </div>
        @endif

        <div class="conatiner-fluid content-inner pb-0" id="page_layout">
            <!-- Main content block -->
            @yield('content')
            <!-- / Main content block -->
            @if (isset($export_import) && $export_import)


                <div data-render="import-export">
                    <export-modal export-url="{{ $export_url }}"
                        :module-column-prop="{{ json_encode($export_columns) }}"
                        module-name="{{ $module_name }}" casttype="{{ $type ?? '' }}"></export-modal>
                    <import-modal></import-modal>
                </div>
            @endif
        </div>



    </div>
     <!-- Footer block -->
     @if (!isset($noLayout) || !$noLayout)

    @include('backend.includes.footer')
    @include('backend.layouts._dynamic_script')

    @endif
    <!-- / Footer block -->

    <!-- Modal -->
    <div class="modal fade" data-iq-modal="renderer" id="renderModal" tabindex="-1" aria-labelledby="renderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" data-iq-modal="content">
                <div class="modal-header">
                    <h5 class="modal-title" data-iq-modal="title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" data-iq-modal="body">
                    <p>Modal body text goes here.</p>
                </div>
            </div>
        </div>
    </div>





    @stack('before-scripts')
    <script src="{{ mix('js/backend.js') }}"></script>
    <script src="{{ asset('js/iqonic-script/utility.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/vue.js') }}"></script>


    <script src="{{ mix('js/import-export.min.js') }}"></script>
    @if (isset($assets) && (in_array('textarea', $assets) || in_array('editor', $assets)))
        <script src="{{ asset('vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ asset('vendor/tinymce/js/tinymce/jquery.tinymce.min.js') }}"></script>
    @endif

    @stack('after-scripts')
    <!-- / Scripts -->
    <script>
        $('.notification_list').on('click', function() {
            notificationList();
        });

        $(document).on('click', '.notification_data', function(event) {
            event.stopPropagation();
        })

        function notificationList(type = '') {
            var url = "{{ route('notification.list') }}";
            $.ajax({
                type: 'get',
                url: url,
                data: {
                    'type': type
                },
                success: function(res) {
                    $('.notification_data').html(res.data);
                    getNotificationCounts();
                    if (res.type == "markas_read") {
                        notificationList();
                    }
                    $('.notify_count').removeClass('notification_tag').text('');
                }
            });
        }

        function setNotification(count) {
            if (Number(count) >= 100) {
                $('.notify_count').text('99+');
            }
        }

        function getNotificationCounts() {
            var url = "{{ route('notification.counts') }}";

            $.ajax({
                type: 'get',
                url: url,
                success: function(res) {
                    if (res.counts > 0) {
                        $('.notify_count').addClass('notification_tag').text(res.counts);
                        setNotification(res.counts);
                        $('.notification_list span.dots').addClass('d-none')
                        $('.notify_count').removeClass('d-none')
                    } else {
                        $('.notify_count').addClass('d-none')
                        $('.notification_list span.dots').removeClass('d-none')
                    }

                    if (res.counts <= 0 && res.unread_total_count > 0) {
                        $('.notification_list span.dots').removeClass('d-none')
                    } else {
                        $('.notification_list span.dots').addClass('d-none')
                    }
                }
            });
        }

        getNotificationCounts();
    </script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const seoImageInput = document.getElementById('seo_image');
    const chooseImageButton = document.getElementById('seo-image-url-button');

    function updateButtonText() {
        chooseImageButton.innerHTML = seoImageInput.value.trim()
            ? '<i class="ph ph-image"></i>'
            : '<i class="ph ph-image"></i> {{ __("messages.lbl_choose_image") }}';
    }

    // Run on load
    updateButtonText();

    // Check every 300ms if value changes (works even if set programmatically)
    let lastValue = seoImageInput.value;
    setInterval(() => {
        if (seoImageInput.value !== lastValue) {
            lastValue = seoImageInput.value;
            updateButtonText();
        }
    }, 300);
});
    document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('form-submit');
            const submitButton = document.getElementById('submit-button');
            const seoCheckbox = document.getElementById('enableSeoIntegration');
            const metaTitle = document.getElementById('meta_title');
            const metaTitleError = document.getElementById('meta_title_error');
            const hiddenInputsContainer = document.getElementById('meta_keywords_hidden_inputs');
            const errorMsg = document.getElementById('meta_keywords_error');
            const tagifyInput = document.getElementById('meta_keywords_input');
            const tagifyWrapper = tagifyInput.closest('.tagify');
            const keywordInputs = hiddenInputsContainer.querySelectorAll('input[name="meta_keywords[]"]');
            const googleVerification = document.getElementById('google_site_verification');
            const canonicalUrl = document.getElementById('canonical_url');
            const shortDescription = document.getElementById('short_description');
            const seoImage = document.getElementById('seo_image');
            const seoImagePreview = document.getElementById('selectedSeoImage');
            const seoImageError = document.querySelector('#seo_image_input + .invalid-feedback');

    const metaKeywordsError = document.getElementById('meta_keywords_error');
            let formSubmitted = false;
        if(form){
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                field.addEventListener('input', () => validateField(field));
                field.addEventListener('change', () => validateField(field));
            });
            form.addEventListener('submit', function(event) {
                if (formSubmitted) {
                    event.preventDefault();
                    return;
                }

                let isValid = validateForm();

                if (seoCheckbox.checked) {
                    if (!validateSeoImage()) {
                        event.preventDefault(); // stop form submit
                    }
                    if(metaTitle.value === ''){
                        isValid = false;
                        metaTitle.classList.add('is-invalid');
                        metaTitleError.style.display = 'block';
                    }else{
                        metaTitle.classList.remove('is-invalid');
                        metaTitleError.style.display = 'none';
                    }
                    // Tagify validation: check if it has tags
                    if (tagifyInput.value === '') {
                        if (keywordInputs.length === 0) {
                            isValid = false;

                            // Show error message
                            errorMsg.style.display = 'block';

                            // Add visual error indication to Tagify input
                            if (tagifyWrapper) {
                                tagifyWrapper.classList.add('is-invalid');
                            }
                        } else {
                            const tagifyInputValue = tagifyInput.value;
                            const keywordValues = tagifyInputValue.map(item => item.value);
                            document.getElementById('meta_keywords_input').value = JSON.stringify(keywordValues);
                            // Hide error if input is valid
                            errorMsg.style.display = 'none';
                            if (tagifyWrapper) {
                                tagifyWrapper.classList.remove('is-invalid');
                            }
                        }
                    }else {

                        errorMsg.style.display = 'none';
                        if (tagifyWrapper) {
                            tagifyWrapper.classList.remove('is-invalid');
                        }
                    }
                }





                if (!isValid) {
                    event.preventDefault();
                    submitButton.disabled = false;
                    formSubmitted = false; // Reset the flag
                    return;
                }

                submitButton.disabled = true;
                submitButton.innerText = 'Loading...';
                formSubmitted = true;
            });
        }
        function validateSeoImage() {
            const seoImageValue = document.getElementById('seo_image').value;
            const errorDiv = document.getElementById('seo_image_error');

            if (!seoImageValue) {
                errorDiv.style.display = 'block';
                return false;
            } else {
                errorDiv.style.display = 'none';
                return true;
            }
        }
        function validateForm() {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!validateField(field)) {
                    isValid = false;
                }
            });

            const trailerType = document.getElementById('trailer_url_type')?.value;
            if (['YouTube', 'Vimeo', 'URL', 'HLS', 'x265'].includes(trailerType)) {
                const isTrailerValid = validateTrailerUrlInput();
                if (!isTrailerValid) {
                    isValid = false;
                }
            }

            const videoType = document.getElementById('video_upload_type')?.value;
            if (['YouTube', 'Vimeo', 'URL', 'HLS', 'x265'].includes(videoType)) {
                const isVideoValid = validateVideoUrlInput();
                if (!isVideoValid) {
                    isValid = false;
                }
            }
            // Optional: Check for URL pattern validation
            const urlInput = form.querySelector('input[name="video_url_input"]');
            // console.log(urlInput);
            if (urlInput && urlInput.required && urlInput.value.trim() && !/^https?:\/\/.+/.test(urlInput.value)) {
                isValid = false;
            }
            const emailInput = form.querySelector('input[type="email"]');
            if (emailInput && emailInput.required && emailInput.value.trim() && !isValidEmail(emailInput.value)) {
                isValid = false;
                showValidationError(emailInput, 'Enter a valid Email Address.');
            }
            const mobileInput = form.querySelector('input[name="mobile"]',);
            if (mobileInput && mobileInput.required && mobileInput.value.trim() && !validatePhoneNumber(mobileInput.value)) {
                isValid = false;
                showValidationError(mobileInput, 'Enter a valid contact number.');
            }

            const helplineInput = form.querySelector('input[name="helpline_number"]');
            if (helplineInput && helplineInput.required && helplineInput.value.trim() && !validatePhoneNumber(helplineInput.value)) {
                isValid = false;
                showValidationError(helplineInput, 'Enter a valid helpline number.');
            }

            const inquiryemailInput = form.querySelector('input[name="inquriy_email"]');
            if (inquiryemailInput && inquiryemailInput.required && inquiryemailInput.value.trim() && !isValidEmail(inquiryemailInput.value)) {
                isValid = false;
                showValidationError(inquiryemailInput, 'Enter a valid Inquiry email address.');
            }
            console.log(isValid)
            return isValid;
        }

        function validateTrailerUrlInput() {
            var URLInput = document.querySelector('input[name="trailer_url"]');
            var urlPatternError = document.getElementById('trailer-pattern-error');
            selectedValue = document.getElementById('trailer_url_type').value;
            if (selectedValue === 'YouTube') {
                urlPattern = /^(https?:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/;
                urlPatternError.innerText = '';
                urlPatternError.innerText='Please enter a valid Youtube URL'
            } else if (selectedValue === 'Vimeo') {
                urlPattern = /^(https?:\/\/)?(www\.)?(vimeo\.com\/(channels\/[a-zA-Z0-9]+\/|groups\/[^/]+\/videos\/)?\d+)(\/.*)?$/;
                urlPatternError.innerText = '';
                urlPatternError.innerText='Please enter a valid Vimeo URL'
            } else {
                // General URL pattern for other types
                urlPattern = /^https?:\/\/.+$/;
                urlPatternError.innerText='Please enter a valid URL'
            }
            if (!urlPattern.test(URLInput.value)) {
                urlPatternError.style.display = 'block';
                return false;
            } else {
                urlPatternError.style.display = 'none';
                return true;
            }
        }

        function validateVideoUrlInput() {
            var videourl = document.querySelector('input[name="video_url_input"]');
            var urlError = document.getElementById('url-error');
            var urlPatternError = document.getElementById('url-pattern-error');

            if (videourl.value === '') {
                urlError.style.display = 'block';
                urlPatternError.style.display = 'none';
                return false;
            } else {
                urlError.style.display = 'none';
                selectedValue = document.getElementById('video_upload_type').value;

                if (selectedValue === 'YouTube') {
                    urlPattern = /^(https?:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/;
                    urlPatternError.innerText = '';
                    urlPatternError.innerText='Please enter a valid Youtube URL'
                } else if (selectedValue === 'Vimeo') {
                    urlPattern = /^(https?:\/\/)?(www\.)?(vimeo\.com\/(channels\/[a-zA-Z0-9]+\/|groups\/[^/]+\/videos\/)?\d+)(\/.*)?$/;
                    urlPatternError.innerText = '';
                    urlPatternError.innerText='Please enter a valid Vimeo URL'
                } else {
                    // General URL pattern for other types
                    urlPattern = /^https?:\/\/.+$/;
                    urlPatternError.innerText='Please enter a valid URL starting with http:// or https://.'
                } // Simple URL pattern validation
                if (!urlPattern.test(videourl.value)) {
                    urlPatternError.style.display = 'block';
                    return false;
                } else {
                    urlPatternError.style.display = 'none';
                    return true;
                }
            }
        }
        function showValidationError(input, message) {
            const errorFeedback = input.nextElementSibling;
            if (errorFeedback && errorFeedback.classList.contains('invalid-feedback')) {
                errorFeedback.textContent = message;
                input.classList.add('is-invalid');
            }
        }
        function validateField(field) {
            const fieldId = field.id; // Use id for error message display
            const fieldError = document.getElementById(`${fieldId}-error`);
            let isValid = true;

            if (!field.value.trim()) {
                if (fieldError) {
                    fieldError.style.display = 'block';
                }
                isValid = false;
            } else {
                if (fieldError) {
                    fieldError.style.display = 'none';
                }
            }

            return isValid;
        }

        function isValidEmail(email) {
            // Simple regex for email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
        function validatePhoneNumber(phoneNumber) {
            const phonePattern = /^[\d\s\-,+]+$/;  // Allows digits, spaces, hyphens, commas, and plus signs
            return phonePattern.test(phoneNumber);
        }

    });
</script>
<script>
(function () {
    'use strict';
    const forms = document.querySelectorAll('.requires-validation');
    Array.from(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            // Check if TinyMCE is defined before calling triggerSave
            if (typeof tinymce !== 'undefined') {
                tinymce.triggerSave();
            }

            // Check form validity
            let isValid = form.checkValidity();

            if (!isValid) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    });

})();





</script>
    <script>
        {!! setting('custom_js_block') !!}
        @if (\Session::get('error'))
            Swal.fire({
                title: 'Error',
                text: '{{ session()->get('error') }}',
                icon: "error",
                showClass: {
                    popup: 'animate__animated animate__zoomIn'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut'
                }
            })
        @endif

          // dark and light mode code
    const theme_mode = sessionStorage.getItem('theme_mode')
    const element = document.querySelector('html');
    if(theme_mode === null ){
        element.setAttribute('data-bs-theme', 'dark')
    } else {
        document.documentElement.setAttribute('data-bs-theme', theme_mode)
    }
    </script>
<script src="{{ asset('vendor/flatpickr/flatpicker.min.js') }}"></script>
<script src={{mix('js/media/media.min.js')}}></script>
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

    const clearCacheConfigUrl = '{{ route("backend.config_clear") }}'; // Use named route helper

    fetch(clearCacheConfigUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => console.log(data.message))
    .catch(error => console.error('Error:', error));
</script>

</body>

</html>
