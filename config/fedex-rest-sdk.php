<?php

return [
    'client_id' => env('FEDEX_CLIENT_ID'),
    'client_secret' => env('FEDEX_CLIENT_SECRET'),
    'account_number' => env('FEDEX_ACCOUNT_NUMBER'),

    'grant_type' => env('FEDEX_GRANT_TYPE', 'client_credentials'),
    'child_key' => env('FEDEX_CHILD_KEY'),
    'child_secret' => env('FEDEX_CHILD_SECRET'),

    'base_url' => env('FEDEX_BASE_URL', 'https://apis.fedex.com'),
    'document_base_url' => env('FEDEX_DOCUMENT_BASE_URL', 'https://documentapi.prod.fedex.com'),

    'verify_ssl' => env('FEDEX_VERIFY_SSL', true),
];
