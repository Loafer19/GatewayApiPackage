<?php

namespace Loafer\GatewayApi;

use Illuminate\Support\ServiceProvider;

class GatewayApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/gatewayapi.php' => config_path('gatewayapi.php'),
        ]);
    }
}
