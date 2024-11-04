<?php

return [
    // api version
    'api_version' => env('API_VERSION', 'v1'),

    // personal client
    'personal_client_id' => env('PERSONAL_CLIENT_ID', 1),
    'personal_client_key' => env('PERSONAL_CLIENT_SECRET', ''),

    // password client
    'password_client_id' => env('PASSWORD_CLIENT_ID', 2),
    'password_client_secret' => env('PASSWORD_CLIENT_SECRET', ''),

    'coop_base_uri' => env('COOP_BASE_URI', ''),
    'coop_api_version' => env('COOP_API_VERSION', ''),
    'coop_api_key' => env('COOP_API_KEY', ''),
    'coop_client_id' =>   env('COOP_CLIENT_ID', ''),
    'coop_client_secret' =>   env('COOP_CLIENT_SECRET', ''),
];
