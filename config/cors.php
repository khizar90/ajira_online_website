<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'uploads/*'], // Add your paths here

    'allowed_methods' => ['*'], // Allow all HTTP methods

    'allowed_origins' => ['*'], // Allow all origins

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Allow all headers

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
