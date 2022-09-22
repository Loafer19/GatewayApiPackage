<?php

return [

    //
    // The API key & secret is used to sign your requests.
    //
    // You can find it in the API section of your account.
    // 
    // https://gatewayapi.com/app/settings/api-oauth
    //

    'api_key' => env('GATEWAY_API_KEY', ''),

    'api_secret' => env('GATEWAY_API_SECRET', ''),

    //
    // Will be shown as the sender of the SMS.
    //
    // Up to 11 alphanumeric characters, or 15 digits.
    //
    // If not set, the app.name will be used as sender name.
    //

    'sender_name' => env('GATEWAY_SENDER_NAME', config('app.name')),

    //
    // The callback URL is used to receive notifications status.
    //

    'callback_url' => env('GATEWAY_CALLBACK_URL', false),
];
