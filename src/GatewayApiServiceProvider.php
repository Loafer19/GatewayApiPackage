<?php

namespace Loafer\GatewayApi;

use Illuminate\Support\ServiceProvider;

class GatewayApiServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind('gatewayapi', function ($app) {
            return new GatewayApi();
        });
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/gatewayapi.php' => config_path('gatewayapi.php'),
        ]);
    }
}
