# Laravel Package for Gateway API

## Unofficial package for [Gateway Api](https://gatewayapi.com)
### Installation
```
composer require loafer/laravel-gateway-api
```

Publish config file
```
php artisan vendor:publish --provider=Loafer\GatewayApi\GatewayApiServiceProvider
```

Specify api key and secret in .env
```
GATEWAY_API_KEY=key
GATEWAY_API_SECRET=secret
```

### Sender Name
You can easily specify the sender's name:

In .env
```
GATEWAY_SENDER="Milky Way"
```

On the fly
```
(new GatewayApi())
    ->setSenderName('Elon Musk')
    ->sendSimpleSMS('test message', [+380987654321])
```

By default, the sender's name is the name of the app

Up to 11 alphanumeric characters or 15 digits
