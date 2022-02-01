<?php

namespace IntaSend\IntaSendPHP\Traits;

use GuzzleHttp\Client;

trait BaseAPITrait
{
    private $credentials;

    private function base_url()
    {
        if ($this->credentials['test'] === true) {
            return 'https://sandbox.intasend.com/api/v1';
        }
        return 'https://payment.intasend.com/api/v1';
    }

    private function send_request($method, $url, $payload = null)
    {
        $headers = [
            'Content-Type' => 'application/json'
        ];
        if (isset($this->credentials['token'])) {
            $headers = [
                'Authorization' => 'Bearer ' . $this->credentials['token'],
                'Content-Type' => 'application/json'
            ];
        }

        $client = new Client();

        $response = $client->request($method, $this->base_url() . $url, [
            'body' => $payload,
            'headers' => $headers
        ]);

        $response = json_decode($response->getBody()->getContents());
        return $response;
    }
}
