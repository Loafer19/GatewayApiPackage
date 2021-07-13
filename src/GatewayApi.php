<?php

namespace Loafer\GatewayApi;


use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

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
        // TODO: Up to 11 alphanumeric characters, or 15 digits
        $this->sender_name = substr($name, 0, 15);

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

        $this->makeRequest('POST', '/rest/mtsms', $body);
    }

    private function makeRequest(string $method, string $end_point, ?array $body)
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
