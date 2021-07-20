<?php

namespace Loafer\GatewayApi;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

use InvalidArgumentException;

class GatewayApi
{
    private $client;

    private $sender_name;

    public function __construct()
    {
        $stack = HandlerStack::create();

        $middleware = new Oauth1([
            'consumer_key'    => config('gatewayapi.api_key'),
            'consumer_secret' => config('gatewayapi.api_secret'),
            'token'           => '',
            'token_secret'    => '',
        ]);

        $stack->push($middleware);

        $this->client = new Client([
            'base_uri' => 'https://gatewayapi.com',
            'handler' => $stack,
            RequestOptions::AUTH => 'oauth',
        ]);

        $this->setSenderName(config('gatewayapi.sender_name'));
    }

    public function setSenderName(string $name)
    {
        if (!preg_match("/^[[:alnum:] ]{1,11}$|^[[:digit:]]{1,15}$/", $name, $matches)) {
            throw new InvalidArgumentException('The sender\'s name must contain up to 11 alphanumeric characters or up to 15 digits, ' . $name);
        };

        $this->sender_name = $name;

        return $this;
    }

    public function sendSimpleSMS(string $message, array $recipients)
    {
        $body = [
            'message' => $message,
            'recipients' => [],
            'sender' => $this->sender_name
        ];

        foreach ($recipients as $recipient) {
            $body['recipients'][] = ['msisdn' => $recipient];
        }

        $this->sendRequest('POST', '/rest/mtsms', $body);
    }

    private function sendRequest(string $method, string $end_point, ?array $body)
    {
        try {
            return $this->client->request(
                $method,
                $end_point,
                $body !== null ? [RequestOptions::JSON => $body] : []
            );
        } catch (ClientException $exception) {
            throw $exception;
        }
    }
}
