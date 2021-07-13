<?php

return [

    'api_token'    => env('GATEWAY_TOKEN', ''),

    'sender'       => env('GATEWAY_SENDER', config('app.name')),
];
