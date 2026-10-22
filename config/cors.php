<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Handled by Laravel's built-in \Illuminate\Http\Middleware\HandleCors.
    | Set CORS_ALLOWED_ORIGINS to a comma separated list of origins,
    | or leave it empty to allow all origins.
    |
    */

    'paths' => ['api/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => env('CORS_ALLOWED_ORIGINS') ? explode(',', env('CORS_ALLOWED_ORIGINS')) : ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization'],

    'exposed_headers' => [],

    'max_age' => 864000,

    'supports_credentials' => true,

];
