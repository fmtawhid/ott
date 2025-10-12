<?php

return [
    'app' => [
        'title' => 'General',
        'desc' => 'All the general settings for application.',
        'icon' => 'fas fa-cube',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'bussiness', // data type, string, int, boolean
                'name' => 'app_name', // unique name for field
                'label' => 'Bussiness Name', // you know what label it is
                'rules' => 'required|min:2', // validation rule of laravel
                'class' => '', // any class for input
                'value' => config('app.name'), // default value if you want
                'datatype' => 'bussiness',
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'bussiness', // data type, string, int, boolean
                'name' => 'user_app_name', // unique name for field
                'label' => 'User App Name', // you know what label it is
                'rules' => 'required|min:2|max:50', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Streamit', // default value if you want
                'datatype' => 'bussiness',
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'bussiness', // data type, string, int, boolean
                'name' => 'user_app_name', // unique name for field
                'label' => 'User App Name', // you know what label it is
                'rules' => 'required|min:2', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Streamit', // default value if you want
                'datatype' => 'bussiness',
            ],

            [
                'type' => 'text', // input fields type
                'data' => 'bussiness', // data type, string, int, boolean
                'name' => 'helpline_number', // unique name for field
                'label' => 'Contact Number', // you know what label it is
                'rules' => 'required|min:2', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '1234567890', // default value if you want
                'datatype' => 'bussiness',
            ],

            [
                'type' => 'text', // input fields type
                'data' => 'bussiness', // data type, string, int, boolean
                'name' => 'inquriy_email', // unique name for field
                'label' => 'Email', // you know what label it is
                'rules' => 'required|min:2', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'admin@streamit.com', // default value if you want
                'datatype' => 'bussiness',
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'bussiness', // data type, string, int, boolean
                'name' => 'short_description', // unique name for field
                'label' => 'Short Description', // you know what label it is
                'rules' => 'required|min:2', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Dummy Text ', // default value if you want
                'datatype' => 'bussiness',
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'bussiness', // data type, string, int, boolean
                'name' => 'google_analytics', // unique name for field
                'label' => 'Google Analytics', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'datatype' => 'misc',
            ],
            [
                'type' => 'file', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'logo', // unique name for field
                'label' => 'Logo', // you know what label it is
                'rules' => 'nullable|image|mimes:jpg,png,gif', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'img/logo/logo.png', // default value if you want
                'help' => '', // Help text for the input field.
                'display' => 'raw', // Help text for the input field.
                'datatype' => 'bussiness',
            ],
            [
                'type' => 'file', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'mini_logo', // unique name for field
                'label' => 'Mini Logo', // you know what label it is
                'rules' => 'nullable|image|mimes:jpg,png,gif', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'img/logo/mini_logo.png', // default value if you want
                'help' => '', // Help text for the input field.
                'display' => 'raw', // Help text for the input field.
                'datatype' => 'bussiness',
            ],
            [
                'type' => 'file', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'dark_logo', // unique name for field
                'label' => 'Dark Logo', // you know what label it is
                'rules' => 'nullable|image|mimes:jpg,png,gif', // validation rule of laravel
                'class' => '', // any class for input
                'imageClass' => 'bg-dark',
                'value' => 'img/logo/dark_logo.png', // default value if you want
                'help' => '', // Help text for the input field.
                'display' => 'raw', // Help text for the input field.
                'datatype' => 'bussiness',
            ],
            [
                'type' => 'file', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'light_logo', // unique name for field
                'label' => 'Lignt Logo', // you know what label it is
                'rules' => 'nullable|image|mimes:jpg,png,gif', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'img/logo/light_logo.png', // default value if you want
                'help' => '', // Help text for the input field.
                'display' => 'raw', // Help text for the input field.
                'datatype' => 'bussiness',
            ],
            [
                'type' => 'file', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'favicon', // unique name for field
                'label' => 'Favicon', // you know what label it is
                'rules' => 'nullable|image|mimes:jpg,png,gif,ico', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'img/logo/favicon.png', // default value if you want
                'help' => '', // Help text for the input field.
                'display' => 'raw', // Help text for the input field.
                'datatype' => 'bussiness',
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'bussiness_address_line_1', // unique name for field
                'rules' => 'nullable|min:2|max:199', // validation rule of laravel
                'value' => '', // default value if you want
                'datatype' => 'bussiness',
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'bussiness_address_line_2', // unique name for field
                'rules' => 'nullable|min:2|max:199', // validation rule of laravel
                'value' => '', // default value if you want
                'datatype' => 'bussiness',
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'country', // unique name for field
                'rules' => '', // validation rule of laravel
                'value' => '', // default value if you want
                'datatype' => 'bussiness',
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'state', // unique name for field
                'rules' => '', // validation rule of laravel
                'value' => '', // default value if you want
                'datatype' => 'bussiness',
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'city', // unique name for field
                'rules' => '', // validation rule of laravel
                'value' => '', // default value if you want
                'datatype' => 'bussiness',
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'bussiness_address_postal_code', // unique name for field
                'rules' => 'nullable|min:2|max:199', // validation rule of laravel
                'value' => '', // default value if you want
                'datatype' => 'bussiness',
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'bussiness_address_latitude', // unique name for field
                'rules' => 'nullable|min:2|max:199', // validation rule of laravel
                'value' => '', // default value if you want
                'datatype' => 'bussiness',
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'bussiness_address_longitude', // unique name for field
                'rules' => 'nullable|min:2|max:199', // validation rule of laravel
                'value' => '', // default value if you want
                'datatype' => 'bussiness',
            ],
        ],
    ],
    'module_setting' => [
        'title' => 'Module Settings',
        'desc' => 'Module Settings',
        'icon' => 'fas fa-chart-line',

        'elements' => [
            [
                'type' => 'checkbox', // input fields type
                'data' => 'module_settings', // data type, string, int, boolean
                'name' => 'movie', // unique name for field
                'label' => 'Movie', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '1', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'module_settings', // data type, string, int, boolean
                'name' => 'tvshow', // unique name for field
                'label' => 'TV Shows', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '1', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'module_settings', // data type, string, int, boolean
                'name' => 'livetv', // unique name for field
                'label' => 'Live TV', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '1', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],

            [
                'type' => 'checkbox', // input fields type
                'data' => 'module_settings', // data type, string, int, boolean
                'name' => 'video', // unique name for field
                'label' => 'Video', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '1', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],

            [
                'type' => 'checkbox',
                'data' => 'module_settings',
                'name' => 'enable_tmdb_api',
                'label' => 'Import Data From TMDB',
                'rules' => 'boolean',
                'class' => '',
                'value' => '0',
                'help' => 'Enable Import TMDB Date.',
            ],
            [
                'type' => 'text',
                'data' => 'module_settings',
                'name' => 'tmdb_api_key',
                'label' => 'TMDB Api Key',
                'rules' => 'required_if:enable_tmdb_api,true',
                'class' => '',
                'value' => '',
                'help' => 'Paste your Firebase server key here.',
            ],


        ],

    ],

    'social' => [
        'title' => 'Social Profiles',
        'desc' => 'Link of all the social profiles.',
        'icon' => 'fas fa-users',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'facebook_url', // unique name for field
                'label' => 'Facebook Page URL', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'twitter_url', // unique name for field
                'label' => 'Twitter Profile URL', // you know what label it is
                'rules' => 'required|nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'instagram_url', // unique name for field
                'label' => 'Instagram Account URL', // you know what label it is
                'rules' => 'required|nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'linkedin_url', // unique name for field
                'label' => 'LinkedIn URL', // you know what label it is
                'rules' => 'required|nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'youtube_url', // unique name for field
                'label' => 'Youtube Channel URL', // you know what label it is
                'rules' => 'required|nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],
        ],

    ],
    'misc' => [
        'title' => 'Misc ',
        'desc' => 'Application Data',
        'icon' => 'fas fa-globe-asia',

        'elements' => [

            [
                'type' => 'text', // input fields type
                'data' => 'misc', // data type, string, int, boolean
                'name' => 'default_language', // unique name for field
                'label' => 'Language', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'en', // default value if you want
                'datatype' => 'misc',
            ],

            [
                'type' => 'text', // input fields type
                'data' => 'misc', // data type, string, int, boolean
                'name' => 'default_time_zone', // unique name for field
                'label' => 'Time Zone', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Asia/Kolkata', // default value if you want
                'datatype' => 'misc',
            ],

            [
                'type' => 'text', // input fields type
                'data' => 'misc', // data type, string, int, boolean
                'name' => 'data_table_limit', // unique name for field
                'label' => 'Datatable Limit', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '10', // default value if you want
                'datatype' => 'misc',
            ],



            [
                'type' => 'text', // input fields type
                'data' => 'misc', // data type, string, int, boolean
                'name' => 'is_enable_all', // unique name for field
                'label' => 'All', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '1', // default value if you want
            ],




        ],
    ],

    'notificationconfig' => [
    'title' => 'Notification Configuration',
    'desc' => 'Notification settings for various features',
    'icon' => 'fas fa-bell',

    'elements' => [

        [
            'type' => 'number', // input fields type
            'data' => 'notificationconfig', // data type, string, int, boolean
            'name' => 'expiry_plan', // unique name for field
            'label' => 'Expiry Plan', // you know what label it is
            'rules' => 'required|integer|min:0', // validation rule of laravel
            'class' => '', // any class for input
            'value' => '1', // default value if you want
            'datatype' => 'notificationconfig',
        ],

        [
            'type' => 'number', // input fields type
            'data' => 'notificationconfig', // data type, string, int, boolean
            'name' => 'upcoming', // unique name for field
            'label' => 'Upcoming', // you know what label it is
            'rules' => 'required|integer|min:0', // validation rule of laravel
            'class' => '', // any class for input
            'value' => '1', // default value if you want
            'datatype' => 'notificationconfig',
        ],

        [
            'type' => 'number', // input fields type
            'data' => 'notificationconfig', // data type, string, int, boolean
            'name' => 'continue_watch', // unique name for field
            'label' => 'Continue Watch', // you know what label it is
            'rules' => 'required|integer|min:0', // validation rule of laravel
            'class' => '', // any class for input
            'value' => '1', // default value if you want
            'datatype' => 'notificationconfig',
        ],
    ],
],

    'analytics' => [
        'title' => 'Analytics',
        'desc' => 'Application Analytics',
        'icon' => 'fas fa-chart-line',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'google_analytics', // unique name for field
                'label' => 'Google Analytics (gtag)', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
                'datatype' => 'misc',
            ],
        ],

    ],

    'appconfig' => [
        'title' => 'App Configuration',
        'desc' => 'Settings for app configuration',
        'icon' => 'fas fa-chart-line',
        'elements' => [
            [
                'type' => 'checkbox',
                'data' => 'appconfig',
                'name' => 'is_social_login',
                'label' => 'Social Login',
                'rules' => 'boolean',
                'class' => '',
                'value' => '0',
                'help' => 'Enable social media login.',
            ],
            [
                'type' => 'checkbox',
                'data' => 'appconfig',
                'name' => 'is_google_login',
                'label' => 'Google Login',
                'rules' => 'boolean',
                'class' => '',
                'value' => '0',
                'help' => 'Enable login using Google accounts.',
            ],
            [
                'type' => 'text',
                'data' => 'appconfig',
                'name' => 'google_client_id',
                'label' => 'Google Client ID',
                'rules' => 'required_if:appconfig.is_google_login,1|nullable|string|max:255',
                'class' => '',
                'value' => '',
                'help' => 'Enter the Google Client ID for Google Login.',
            ],
            [
                'type' => 'text',
                'data' => 'appconfig',
                'name' => 'google_client_secret',
                'label' => 'Google Client Secret',
                'rules' => 'required_if:appconfig.is_google_login,1|nullable|string|max:255',
                'class' => '',
                'value' => '',
                'help' => 'Enter the Google Client Secret for Google Login.',
            ],
            [
                'type' => 'text',
                'data' => 'appconfig',
                'name' => 'google_redirect_uri',
                'label' => 'Google Redirect URI',
                'rules' => 'required_if:appconfig.is_google_login,1|nullable|url',
                'class' => '',
                'value' => '',
                'help' => 'Enter the Redirect URI for Google Login.',
            ],
            [
                'type' => 'checkbox',
                'data' => 'appconfig',
                'name' => 'is_otp_login',
                'label' => 'OTP Login',
                'rules' => 'boolean',
                'class' => '',
                'value' => '0',
                'help' => 'Enable login via OTP verification.',
            ],
            [
                'type' => 'text',
                'data' => 'appconfig',
                'name' => 'apiKey',
                'label' => 'OTP API Key',
                'rules' => '',
                'class' => '',
                'value' => '',
                'help' => 'Enter the API Key for OTP login.',
            ],
            [
                'type' => 'text',
                'data' => 'appconfig',
                'name' => 'authDomain',
                'label' => 'OTP Auth Domain',
                'rules' => 'required_if:appconfig.is_otp_login,1|nullable|string|max:255',
                'class' => '',
                'value' => '',
                'help' => 'Enter the Auth Domain for OTP login.',
            ],
            [
                'type' => 'text',
                'data' => 'appconfig',
                'name' => 'databaseURL',
                'label' => 'OTP Database URL',
                'rules' => 'required_if:appconfig.is_otp_login,1|nullable|url',
                'class' => '',
                'value' => '',
                'help' => 'Enter the Database URL for OTP login.',
            ],
            [
                'type' => 'text',
                'data' => 'appconfig',
                'name' => 'projectId',
                'label' => 'OTP Project ID',
                'rules' => 'required_if:appconfig.is_otp_login,1|nullable|string|max:255',
                'class' => '',
                'value' => '',
                'help' => 'Enter the Project ID for OTP login.',
            ],
            [
                'type' => 'text',
                'data' => 'appconfig',
                'name' => 'storageBucket',
                'label' => 'OTP Storage Bucket',
                'rules' => 'required_if:appconfig.is_otp_login,1|nullable|string|max:255',
                'class' => '',
                'value' => '',
                'help' => 'Enter the Storage Bucket for OTP login.',
            ],
            [
                'type' => 'text',
                'data' => 'appconfig',
                'name' => 'messagingSenderId',
                'label' => 'OTP Messaging Sender ID',
                'rules' => 'required_if:appconfig.is_otp_login,1|nullable|string|max:255',
                'class' => '',
                'value' => '',
                'help' => 'Enter the Messaging Sender ID for OTP login.',
            ],
            [
                'type' => 'text',
                'data' => 'appconfig',
                'name' => 'appId',
                'label' => 'OTP App ID',
                'rules' => 'required_if:appconfig.is_otp_login,1|nullable|string|max:255',
                'class' => '',
                'value' => '',
                'help' => 'Enter the App ID for OTP login.',
            ],
            [
                'type' => 'text',
                'data' => 'appconfig',
                'name' => 'measurementId',
                'label' => 'OTP Measurement ID',
                'rules' => 'required_if:appconfig.is_otp_login,1|nullable|string|max:255',
                'class' => '',
                'value' => '',
                'help' => 'Enter the Measurement ID for OTP login.',
            ],
            // [
            //     'type' => 'checkbox',
            //     'data' => 'appconfig',
            //     'name' => 'is_apple_login',
            //     'label' => 'Apple Login',
            //     'rules' => 'boolean',
            //     'class' => '',
            //     'value' => '0',
            //     'help' => 'Enable login using Apple ID.',
            // ],
            [
                'type' => 'checkbox',
                'data' => 'appconfig',
                'name' => 'is_firebase_notification',
                'label' => 'Firebase Notification',
                'rules' => 'boolean',
                'class' => '',
                'value' => '0',
                'help' => 'Enable notifications via Firebase Cloud Messaging.',
            ],
            [
                'type' => 'text',
                'data' => 'appconfig',
                'name' => 'firebase_key',
                'label' => 'Firebase Key',
                'rules' => 'required_if:is_firebase_notification,1 |nullable|string|max:255',
                'class' => '',
                'value' => '',
                'help' => 'Paste your Firebase server key here.',
            ],
            // [
            //     'type' => 'file',
            //     'data' => 'appconfig',
            //     'name' => 'firebase_json_file',
            //     'label' => 'Firebase JSON File',
            //     'rules' => 'required_if:is_firebase_notification,true',
            //     'class' => '',
            //     'value' => '',
            //     'help' => 'Upload the Firebase JSON file.',
            //     'datatype' => 'appconfig',
            // ],
            [
                'type' => 'checkbox',
                'data' => 'appconfig',
                'name' => 'is_user_push_notification',
                'label' => 'User Push Notification',
                'rules' => 'boolean',
                'class' => '',
                'value' => '0',
                'help' => 'Enable push notifications for users.',
            ],
            [
                'type' => 'checkbox',
                'data' => 'appconfig',
                'name' => 'is_application_link',
                'label' => 'Application Links',
                'rules' => 'boolean',
                'class' => '',
                'value' => '',
                'help' => 'Enter URL for iOS app if applicable.',
            ],
            [
                'type' => 'text',
                'data' => 'appconfig',
                'name' => 'ios_url',
                'label' => 'iOS App URL',
                'rules' => 'nullable|url',
                'class' => '',
                'value' => '',
                'help' => 'Enter URL for iOS app if applicable.',
            ],
            [
                'type' => 'text',
                'data' => 'appconfig',
                'name' => 'android_url',
                'label' => 'Android App URL',
                'rules' => 'nullable|url',
                'class' => '',
                'value' => '',
                'help' => 'Enter URL for Android app if applicable.',
            ],
            [
                'type' => 'checkbox',
                'data' => 'appconfig',
                'name' => 'force_update',
                'label' => 'Force Update',
                'rules' => 'boolean',
                'class' => '',
                'value' => '0',
                'help' => 'Force users to update the app.',
            ],
            [
                'type' => 'checkbox',
                'data' => 'appconfig',
                'name' => 'enter_app_version',
                'label' => 'Enter App Version',
                'rules' => 'required_if:force_update,1',
                'class' => '',
                'value' => '0',
                'help' => 'Force users to update the app.',
            ],
            [
                'type' => 'text',
                'data' => 'appconfig',
                'name' => 'app_version',
                'label' => 'App Version',
                'rules' => 'required_if:force_update,1',
                'class' => '',
                'value' => '',
                'help' => 'Enter the current version of the app.',
            ],

            [
                'type' => 'checkbox',
                'data' => 'appconfig',
                'name' => 'is_ChatGPT_integration',
                'label' => 'ChatGPT integration',
                'rules' => 'boolean',
                'class' => '',
                'value' => '0',
                'help' => 'Enable integration via ChatGPT Cloud Messaging.',
            ],
            [
                'type' => 'text',
                'data' => 'appconfig',
                'name' => 'ChatGPT_key',
                'label' => 'ChatGPT Key',
                'rules' => 'required_if:is_ChatGPT_integration,1',
                'class' => '',
                'value' => '',
                'help' => 'Paste your ChatGPT server key here.',

            ],
        ],
    ],

    'custom_css' => [
        'title' => 'Custom Code',
        'desc' => 'Custom code area',
        'icon' => 'fa-solid fa-file-code',

        'elements' => [
            [
                'type' => 'textarea', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'custom_css_block', // unique name for field
                'label' => 'Custom Css Code', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => '', // Help text for the input field.
                'display' => 'raw', // Help text for the input field.
            ],
            [
                'type' => 'textarea', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'custom_js_block', // unique name for field
                'label' => 'Custom Js Code', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => '', // Help text for the input field.
                'display' => 'raw', // Help text for the input field.
            ],

        ],

    ],
    'customization' => [
        'title' => 'Customization',
        'desc' => 'Setting on admin panel',
        'icon' => 'fa-solid fa-file-code',
        'elements' => [
            [
                'type' => 'hidden', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'customization_json', // unique name for field
                'label' => 'Customization', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '{}', // default value if you want
                'help' => '', // Help text for the input field.
                'display' => 'raw', // Help text for the input field.
            ],
            [
                'type' => 'hidden', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'root_colors', // unique name for field
                'label' => 'root_colors', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '{}', // default value if you want
                'help' => '', // Help text for the input field.
                'display' => 'raw', // Help text for the input field.
            ],
        ],
    ],
    'mobile' => [
        'title' => 'Mobile',
        'desc' => 'Application Mobile',
        'icon' => 'fas fa-chart-line',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'bussiness', // data type, string, int, boolean
                'name' => 'primary', // unique name for field
                'label' => 'Primary', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'bussiness', // data type, string, int, boolean
                'name' => 'secondary', // unique name for field
                'label' => 'Secondary', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
        ],

    ],

    'mail' => [
        'title' => 'Mail Setting',
        'desc' => 'Mail settings',
        'icon' => 'fas fa-envelope',

        'elements' => [
            [
                'type' => 'email', // input fields type
                'data' => 'mail_config', // data type, string, int, boolean
                'name' => 'email', // unique name for field
                'label' => 'Email', // you know what label it is
                'rules' => 'required|email', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'info@example.com', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'mail_config', // data type, string, int, boolean
                'name' => 'mail_driver', // unique name for field
                'label' => 'Mail Driver', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'smtp', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'mail_config', // data type, string, int, boolean
                'name' => 'mail_host', // unique name for field
                'label' => 'Mail Host', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'smtp.gmail.com', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'mail_config', // data type, string, int, boolean
                'name' => 'mail_port', // unique name for field
                'label' => 'Mail Port', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '587', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'mail_config', // data type, string, int, boolean
                'name' => 'mail_encryption', // unique name for field
                'label' => 'Mail Encryption', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'tls', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'mail_config', // data type, string, int, boolean
                'name' => 'mail_username', // unique name for field
                'label' => 'Mail Username', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'youremail@gmail.com', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'mail_config', // data type, string, int, boolean
                'name' => 'mail_password', // unique name for field
                'label' => 'Mail Password', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Password', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'mail_config', // data type, string, int, boolean
                'name' => 'mail_from', // unique name for field
                'label' => 'Mail From', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'youremail@gmail.com', // default value if you wantPassword
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'mail_config', // data type, string, int, boolean
                'name' => 'from_name', // unique name for field
                'label' => 'From Name', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Streamit-Laravel', // default value if you wantPassword
            ],
        ],

    ],
    'payment' => [
        'title' => 'Payment',
        'desc' => 'Payment',
        'icon' => 'fas fa-chart-line',

        'elements' => [
            [
                'type' => 'checkbox', // input fields type
                'data' => 'cashpayment', // data type, string, int, boolean
                'name' => 'cash_payment_method', // unique name for field
                'label' => 'Is Type ', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '0', // default value if you want

            ],
            [
                'type' => 'text', // input fields type
                'data' => 'cash_payment_method', // data type, string, int, boolean
                'name' => 'cash_secretkey', // unique name for field
                'label' => 'cashpayment', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'cash_payment_method', // data type, string, int, boolean
                'name' => 'cash_publickey', // unique name for field
                'label' => 'cashpayment', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'razorpayPayment', // data type, string, int, boolean
                'name' => 'razor_payment_method', // unique name for field
                'label' => 'Is Type', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '0', // default value if you want

            ],
            [
                'type' => 'text', // input fields type
                'data' => 'razor_payment_method', // data type, string, int, boolean
                'name' => 'razorpay_secretkey', // unique name for field
                'label' => 'razorpayPayment', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'razor_payment_method', // data type, string, int, boolean
                'name' => 'razorpay_publickey', // unique name for field
                'label' => 'razorpayPayment', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'stripePayment', // data type, string, int, boolean
                'name' => 'str_payment_method', // unique name for field
                'label' => 'Is Type', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '0', // default value if you want

            ],
            [
                'type' => 'text', // input fields type
                'data' => 'str_payment_method', // data type, string, int, boolean
                'name' => 'stripe_secretkey', // unique name for field
                'label' => 'stripePayment', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'str_payment_method', // data type, string, int, boolean
                'name' => 'stripe_publickey', // unique name for field
                'label' => 'stripePayment', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'paystackPayment', // data type, string, int, boolean
                'name' => 'paystack_payment_method', // unique name for field
                'label' => 'Is Type', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '0', // default value if you want

            ],
            [
                'type' => 'text', // input fields type
                'data' => 'paystack_payment_method', // data type, string, int, boolean
                'name' => 'paystack_secretkey', // unique name for field
                'label' => 'paystackPayment', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'paystack_payment_method', // data type, string, int, boolean
                'name' => 'paystack_publickey', // unique name for field
                'label' => 'paystackPayment', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'paypalPayment', // data type, string, int, boolean
                'name' => 'paypal_payment_method', // unique name for field
                'label' => 'Is Type', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '0', // default value if you want

            ],
            [
                'type' => 'text', // input fields type
                'data' => 'paypal_payment_method', // data type, string, int, boolean
                'name' => 'paypal_secretkey', // unique name for field
                'label' => 'paypalPayment', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'paypal_payment_method', // data type, string, int, boolean
                'name' => 'paypal_clientid', // unique name for field
                'label' => 'paypalPayment', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'flutterwavePayment', // data type, string, int, boolean
                'name' => 'flutterwave_payment_method', // unique name for field
                'label' => 'Is Type', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '0', // default value if you want

            ],
            [
                'type' => 'text', // input fields type
                'data' => 'flutterwave_payment_method', // data type, string, int, boolean
                'name' => 'flutterwave_secretkey', // unique name for field
                'label' => 'flutterwavePayment', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'flutterwave_payment_method', // data type, string, int, boolean
                'name' => 'flutterwave_publickey', // unique name for field
                'label' => 'flutterwavePayment', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            //
            [
                'type' => 'checkbox', // input fields type
                'data' => 'paymentcinet', // data type, string, int, boolean
                'name' => 'cinet_payment_method', // unique name for field
                'label' => 'Is Type', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '0', // default value if you want

            ],
            [
                'type' => 'text', // input fields type
                'data' => 'cinet_payment_method', // data type, string, int, boolean
                'name' => 'cinet_siteid', // unique name for field
                'label' => 'paymentcinet', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'cinet_payment_method', // data type, string, int, boolean
                'name' => 'cinet_api_key', // unique name for field
                'label' => 'paymentcinet', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'cinet_payment_method', // data type, string, int, boolean
                'name' => 'cinet_Secret_key', // unique name for field
                'label' => 'paymentcinet', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            //sadad
            [
                'type' => 'checkbox', // input fields type
                'data' => 'paymentsadad', // data type, string, int, boolean
                'name' => 'sadad_payment_method', // unique name for field
                'label' => 'Is Type', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '0', // default value if you want

            ],
            [
                'type' => 'text', // input fields type
                'data' => 'sadad_payment_method', // data type, string, int, boolean
                'name' => 'sadad_Sadadkey', // unique name for field
                'label' => 'paymentsadad', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'sadad_payment_method', // data type, string, int, boolean
                'name' => 'sadad_id_key', // unique name for field
                'label' => 'paymentsadad', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'sadad_payment_method', // data type, string, int, boolean
                'name' => 'sadad_Domain', // unique name for field
                'label' => 'paymentsadad', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            //airtel_payment
            [
                'type' => 'checkbox', // input fields type
                'data' => 'airtelpayment', // data type, string, int, boolean
                'name' => 'airtel_payment_method', // unique name for field
                'label' => 'Is Type', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '0', // default value if you want

            ],
            [
                'type' => 'text', // input fields type
                'data' => 'airtel_payment_method', // data type, string, int, boolean
                'name' => 'airtel_money_secretkey', // unique name for field
                'label' => 'airtelpayment', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'airtel_payment_method', // data type, string, int, boolean
                'name' => 'airtel_money_client_id', // unique name for field
                'label' => 'airtelpayment', // you know what label it is
                'rules' => 'required|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],

        //phonepe
        [
            'type' => 'checkbox', // input fields type
            'data' => 'phonepepayment', // data type, string, int, boolean
            'name' => 'phonepe_payment_method', // unique name for field
            'label' => 'Is Type', // you know what label it is
            'rules' => '', // validation rule of laravel
            'class' => '', // any class for input
            'value' => '0', // default value if you want

        ],
        [
            'type' => 'text', // input fields type
            'data' => 'phonepe_payment_method', // data type, string, int, boolean
            'name' => 'phonepe_App_id', // unique name for field
            'label' => 'phonepepayment', // you know what label it is
            'rules' => 'required|max:191', // validation rule of laravel
            'class' => '', // any class for input
            'value' => '', // default value if you want
            'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
        ],
        [
            'type' => 'text', // input fields type
            'data' => 'phonepe_payment_method', // data type, string, int, boolean
            'name' => 'phonepe_Merchant_id', // unique name for field
            'label' => 'phonepepayment', // you know what label it is
            'rules' => 'required|max:191', // validation rule of laravel
            'class' => '', // any class for input
            'value' => '', // default value if you want
            'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
        ],
        [
            'type' => 'text', // input fields type
            'data' => 'phonepe_payment_method', // data type, string, int, boolean
            'name' => 'phonepe_salt_key', // unique name for field
            'label' => 'phonepepayment', // you know what label it is
            'rules' => 'required|max:191', // validation rule of laravel
            'class' => '', // any class for input
            'value' => '', // default value if you want
            'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
        ],
        [
            'type' => 'text', // input fields type
            'data' => 'phonepe_payment_method', // data type, string, int, boolean
            'name' => 'phonepe_salt_index', // unique name for field
            'label' => 'phonepepayment', // you know what label it is
            'rules' => 'required|max:191', // validation rule of laravel
            'class' => '', // any class for input
            'value' => '', // default value if you want
            'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
        ],
        //min
        [
            'type' => 'checkbox', // input fields type
            'data' => 'midtranspayment', // data type, string, int, boolean
            'name' => 'midtrans_payment_method', // unique name for field
            'label' => 'Is Type', // you know what label it is
            'rules' => '', // validation rule of laravel
            'class' => '', // any class for input
            'value' => '0', // default value if you want

        ],
        [
            'type' => 'text', // input fields type
            'data' => 'midtrans_payment_method', // data type, string, int, boolean
            'name' => 'midtrans_client_id', // unique name for field
            'label' => 'midtranspayment', // you know what label it is
            'rules' => 'required|max:191', // validation rule of laravel
            'class' => '', // any class for input
            'value' => '', // default value if you want
            'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
        ],
         [
            'type' => 'text', // input fields type
            'data' => 'midtrans_payment_method', // data type, string, int, boolean
            'name' => 'midtrans_server_key', // unique name for field
            'label' => 'midtranspayment', // you know what label it is
            'rules' => 'required|max:191', // validation rule of laravel
            'class' => '', // any class for input
            'value' => '', // default value if you want
            'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
        ],
        [
            'type' => 'checkbox', // input fields type
            'data' => 'inapppurchase', // data type, string, int, boolean
            'name' => 'iap_payment_method', // unique name for field
            'label' => 'In App Purchase', // label for the field
            'rules' => '', // validation rule of laravel
            'class' => '', // any class for input
            'value' => '0', // default value if you want
        ],
        [
            'type' => 'text', // input fields type
            'data' => 'iap_entertainment_id', // data type, string, int, boolean
            'name' => 'entertainment_id', // unique name for field
            'label' => 'Entertainment ID', // label for the field
            'rules' => 'required|max:191', // validation rule of laravel
            'class' => '', // any class for input
            'value' => '', // default value if you want
            'help' => 'Enter the Entitlement ID for the In App Purchase.', // Help text for the input field
        ],
        [
            'type' => 'text', // input fields type
            'data' => 'iap_apple_api_key', // data type, string, int, boolean
            'name' => 'apple_api_key', // unique name for field
            'label' => 'Apple API Key', // label for the field
            'rules' => 'required|max:191', // validation rule of laravel
            'class' => '', // any class for input
            'value' => '', // default value if you want
            'help' => 'Enter the Apple API Key for the In App Purchase.', // Help text for the input field
        ],
        [
            'type' => 'text', // input fields type
            'data' => 'iap_google_api_key', // data type, string, int, boolean
            'name' => 'google_api_key', // unique name for field
            'label' => 'Google API Key', // label for the field
            'rules' => 'required|max:191', // validation rule of laravel
            'class' => '', // any class for input
            'value' => '', // default value if you want
            'help' => 'Enter the Google API Key for the In App Purchase.', // Help text for the input field
        ],


        ],
    ],

    'invoice_setting' => [
        'title' => 'Invoice Setting',
        'desc' => 'Order Related Setting.',
        'icon' => '',
        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'inv_prefix', // unique name for field
                'label' => 'lbl_order_prefix', // you know what label it is
                'rules' => 'nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '# - ORDER', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'int', // data type, string, int, boolean
                'name' => 'order_code_start', // unique name for field
                'label' => 'lbl_order_starts', // you know what label it is
                'rules' => 'nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '10001', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'spacial_note', // unique name for field
                'label' => 'lbl_spacial_note', // you know what label it is
                'rules' => 'nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Thank you for visiting our store and choosing to make a purchase with us.', // default value if you want
            ],
        ],
    ],
    'other_settings' => [
        'title' => 'Other Settings',
        'desc' => 'Other Settings',
        'icon' => 'fas fa-chart-line',

        'elements' => [
            [
                'type' => 'checkbox', // input fields type
                'data' => 'other_settings', // data type, string, int, boolean
                'name' => 'is_event', // unique name for field
                'label' => 'Enable Events', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '0', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'other_settings', // data type, string, int, boolean
                'name' => 'is_blog', // unique name for field
                'label' => 'Enable Blogs', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '0', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ]

        ],

    ],

    'storageconfig' => [
    'title' => 'Storage Settings',
    'desc' => 'Configuration settings for AWS S3 storage.',
    'icon' => 'fas fa-cloud',

    'elements' => [

        [
            'type' => 'checkbox', // input field type
            'data' => 'storage_settings', // data type, boolean
            'name' => 'local', // unique name for the field
            'label' => 'Enable Local Storage', // label for the field
            'rules' => 'boolean', // validation rules
            'class' => '', // any class for input
            'value' => 0, // default value
            'datatype' => 'storageconfig',
        ],
        [
            'type' => 'checkbox', // input field type
            'data' => 'storage_settings', // data type, boolean
            'name' => 's3', // unique name for the field
            'label' => 'Enable S3 Storage', // label for the field
            'rules' => 'boolean', // validation rules
            'class' => '', // any class for input
            'value' => 0, // default value
            'datatype' => 'storageconfig',
        ],

        [
            'type' => 'text', // input field type
            'data' => 'storage_settings', // data type, string
            'name' => 'aws_access_key', // unique name for the field
            'label' => 'AWS Access Key ID', // label for the field
            'rules' => '', // validation rules
            'class' => '', // any class for input
            'value' => '', // default value
            'datatype' => 'storageconfig',
        ],
        [
            'type' => 'text', // input field type
            'data' => 'storage_settings', // data type, string
            'name' => 'aws_secret_key', // unique name for the field
            'label' => 'AWS Secret Access Key', // label for the field
            'rules' => '', // validation rules
            'class' => '', // any class for input
            'value' => '', // default value
            'datatype' => 'storageconfig',
        ],
        [
            'type' => 'text', // input field type
            'data' => 'storage_settings', // data type, string
            'name' => 'aws_region', // unique name for the field
            'label' => 'AWS Default Region', // label for the field
            'rules' => '', // validation rules
            'class' => '', // any class for input
            'value' => '', // default value
            'datatype' => 'storageconfig',
        ],
        [
            'type' => 'text', // input field type
            'data' => 'storage_settings', // data type, string
            'name' => 'aws_bucket', // unique name for the field
            'label' => 'AWS Bucket', // label for the field
            'rules' => '', // validation rules
            'class' => '', // any class for input
            'value' => '', // default value
            'datatype' => 'storageconfig',
        ],
        [
            'type' => 'select', // input field type
            'data' => 'storage_settings', // data type, string
            'name' => 'aws_path_style', // unique name for the field
            'label' => 'AWS Use Path Style Endpoint', // label for the field
            'rules' => '', // validation rules
            'class' => '', // any class for input
            'value' => 'false', // default value
            'options' => ['false' => 'False', 'true' => 'True'], // select options
            'datatype' => 'storageconfig',
        ],
    ],
],



];
