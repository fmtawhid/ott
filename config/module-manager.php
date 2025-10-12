<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Module Config
    |--------------------------------------------------------------------------
    |
    */

    'namespace' => 'Modules',

    'stubs' => [
        'path' => base_path('stubs/laravel-starter-stubs'),
    ],

    'module' => [
        'files' => [
            'composer' => ['composer.stub', 'composer.json'],
            'json' => ['module.stub', 'module.json'],
            'config' => ['Config/config.stub', 'Config/config.php'],
            'database' => ['database/migrations/stubMigration.stub', 'database/migrations/stubMigration.php', 'rename'],
            'seeders' => ['database/seeders/stubSeeders.stub', 'database/seeders/stubSeeders.php', 'rename'],
            'models' => ['Models/stubModel.stub', 'Models/stubModel.php'],
            'providersRoute' => ['Providers/RouteServiceProvider.stub', 'Providers/RouteServiceProvider.php'],
            'providers' => ['Providers/stubServiceProvider.stub', 'Providers/stubServiceProvider.php'],
            'route_web' => ['routes/web.stub', 'routes/web.php'],
            'route_api' => ['routes/api.stub', 'routes/api.php'],
            'controller_backend' => ['Http/Controllers/Backend/stubBackendController.stub', 'Http/Controllers/Backend/stubBackendController.php'],
            'controller_api' => ['Http/Controllers/API/stubAPIController.stub', 'Http/Controllers/API/stubAPIController.php'],
            'http_requests'=>['Http/Requests/stubRequest.stub', 'Http/Requests/stubRequest.php'],
            'assets_sass_app' => ['Resources/assets/sass/app.scss', 'Resources/assets/sass/app.scss'],
            'views_index' => ['Resources/views/index.blade.stub', 'Resources/views/backend/{{module}}/index.blade.php'],
            'views_action' => ['Resources/views/action.blade.stub', 'Resources/views/backend/{{module}}/action.blade.php'],
            'views_create' => ['Resources/views/create.blade.stub', 'Resources/views/backend/{{module}}/create.blade.php'],
            'views_edit' => ['Resources/views/edit.blade.stub', 'Resources/views/backend/{{module}}/edit.blade.php'],
            'package.json' => ['package.json', 'package.json'],
            'webpack.mix.js' => ['webpack.mix.js', 'webpack.mix.js'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Module Composer
    |--------------------------------------------------------------------------
    |
    | Config for the composer.json file
    |
    */

    'composer' => [
        'vendor' => 'iqonicdesign',
        'author' => [
            'name' => 'Iqonic Design',
            'email' => 'hello@iqonic.design',
        ],
    ],
];
