<?php

namespace Loafer\GatewayApi;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;

use GuzzleHttp\Subscriber\Oauth\Oauth1;

use GuzzleHttp\Exception\ClientException;

use InvalidArgumentException;

class GatewayApi
{
    private $client;

    private $sender_name;
    private $callback_url = false;

    private $sms_label = false;
    private $sms_class = self::SMS_CLASS_STANDART;

    public const SMS_CLASS_STANDART = 'standard';
    public const SMS_CLASS_PREMIUM = 'premium';
    public const SMS_CLASS_SECRET = 'secret';

    public function __construct()
    {
        $stack = HandlerStack::create();

        $middleware = new Oauth1([
            'consumer_key'    => config('gatewayapi.api_key'),
            'consumer_secret' => config('gatewayapi.api_secret'),
        ]);

        $stack->push($middleware);

        $this->client = new Client([
            'base_uri' => 'https://gatewayapi.com',
            'handler' => $stack,
            RequestOptions::AUTH => 'oauth',
        ]);

        $this->setSenderName(config('gatewayapi.sender_name'));

        if (config('gatewayapi.callback_url')) {
            $this->setCallbackUrl(config('gatewayapi.callback_url'));
        }
    }

    public function setSenderName(string $name)
    {
        if (!preg_match("/^[[:alnum:] ]{1,11}$|^[[:digit:]]{1,15}$/", $name, $matches)) {
            throw new InvalidArgumentException('The sender\'s name must contain up to 11 alphanumeric characters or up to 15 digits, ' . $name);
        };

        $this->sender_name = $name;

        return $this;
    }

    public function setCallbackUrl(string $url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('The callback URL is invalid, ' . $url);
        };

        $this->callback_url = $url;

        return $this;
    }

    public function setSmsLabel(string $label)
    {
        if (strlen($label) > 255) {
            throw new InvalidArgumentException('The SMS label must contain up to 255 characters, ' . $label);
        };

        $this->sms_label = $label;

        return $this;
    }

    public function setSmsClass(string $class)
    {
        if (!in_array($class, [self::SMS_CLASS_STANDART, self::SMS_CLASS_PREMIUM, self::SMS_CLASS_SECRET])) {
            throw new InvalidArgumentException('The SMS class must be standard, premium or secret, ' . $class);
        };

        $this->sms_class = $class;

        return $this;
    }

    public function sendSimpleSms(string $message, array $recipients)
    {
        $body = [
            'class' => $this->sms_class,
            'message' => $message,
            'recipients' => [],
            'sender' => $this->sender_name
        ];

        if ($this->sms_label) {
            $body['label'] = $this->sms_label;
        }

        if ($this->callback_url) {
            $body['callback_url'] = $this->callback_url;
        }

        foreach ($recipients as $recipient) {
            $body['recipients'][] = ['msisdn' => $recipient];
        }

        $this->sendRequest('POST', '/rest/mtsms', $body);
    }

    private function sendRequest(string $method, string $endpoint, array $body = [])
    {
        try {
            return $this->client->request(
                $method,
                $endpoint,
                [RequestOptions::JSON => $body]
            );
        } catch (ClientException $exception) {
            throw $exception;
        }
    }
}
