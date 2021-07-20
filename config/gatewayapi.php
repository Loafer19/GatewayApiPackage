<?php

return [

    'api_key' => env('GATEWAY_API_KEY', ''),

    'api_secret' => env('GATEWAY_API_SECRET', ''),

    'sender_name' => env('GATEWAY_SENDER_NAME', config('app.name')),
];
