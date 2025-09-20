<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],
    'allowed_origins' => [
    'http://localhost:3000',
    'http://localhost:3001',
    'https://greengodelivery-ge-main.vercel.app',
    'https://app-greengo-delivery-main-n7t9.vercel.app',
    'https://greengo-api-production.up.railway.app',
    
],

    'allowed_origins_patterns' => [
      '/^https:\/\/.*\.vercel\.app$/',
      '/^https:\/\/.*\.railway\.app$/',
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
