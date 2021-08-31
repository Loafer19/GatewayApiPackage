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
        $this->app->bind('gatewayapi', function ($app) {
            return new GatewayApi();
        });
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
