<?php

return [
    'username' => env('CLICKSEND_USERNAME'),
    'password' => env('CLICKSEND_API_KEY'),
    'api_endpoint' => env('CLICKSEND_API_ENDPOINT', 'https://rest.clicksend.com/v3'),

    'ignored_error_codes' => [],
];