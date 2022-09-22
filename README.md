# Laravel Package for Gateway API

## Unofficial package for [Gateway Api](https://gatewayapi.com)

## Installation

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

## Usage

Import on top of the file
```
use Loafer\GatewayApi\Facades\GatewayApi;
```

Simpliest way to send SMS
```
GatewayApi::sendSimpleSms('smooth', [+380987654321]);
```

Complex way and available methods:
```
GatewayApi::setLabel(string)
    ->setSmsClass(string)
    ->setSenderName(string)
    ->setCallbackUrl(string)
    ->sendSimpleSms(string, array);
```

### Sender Name

You can easily specify the sender's name:

In .env or in config/gatewayapi.php
```
GATEWAY_SENDER="Milky Way"
```

On the fly
```
GatewayApi::setSenderName('Elon Musk')
    ->sendSimpleSms('Doggy to moon', [+380987654321])
```

Up to 11 alphanumeric characters or 15 digits

By default, the sender's name is the name of the app

### Callback Url

You can easily specify the callback url:

In .env or in config
```
GATEWAY_CALLBACK_URL="https://some-url.com"
```

On the fly
```
GatewayApi::setCallbackUrl('https://test-dev.com/callbacks/sms')
    ->sendSimpleSms('test', [+380987654321])
```

By default, the callback url is not specified

### SMS Label

You can easily specify the sms label:
```
GatewayApi::setSmsLabel('registration')
    ->sendSimpleSms('Welcome...', [+380987654321])
```

By default, the label is not specified

### SMS Class

You can easily specify the SMS Class:

Available values: `standart`, `premium`, `secret`

```
GatewayApi::setSmsClass('premium')
    ->sendSimpleSms('money is honey', [+380987654321])
```

You can use the constants as well:

```
GatewayApi::SMS_CLASS_STANDART
GatewayApi::SMS_CLASS_PREMIUM
GatewayApi::SMS_CLASS_SECRET
```

By default, the SMS Class is `standart`

## Additional info

[Official Docs](https://gatewayapi.com/docs/apis/rest)
