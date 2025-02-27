<?php

namespace Loafer\GatewayApi\Facades;

use Illuminate\Support\Facades\Facade;

class GatewayApi extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'gatewayapi';
    }
}
