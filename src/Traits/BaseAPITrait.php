<?php
namespace IntaSend\IntaSendPHP\Traits;

use Exception;
use GuzzleHttp\Client;

trait BaseAPITrait
{
    private $credentials;
    private $env;

    private function base_url()
    {
        if ($this->env == 'test') {
            return 'https://sandbox.intasend.com/api/v1';
        }
        if ($this->env == 'live') {
            return 'https://payment.intasend.com/api/v1';
        }
    }

    private function get_env_call($payload) {
        $token = "";
        $publishable_key = "";
        if (isset($this->credentials['token'])) {
            $token = $this->credentials['token'];
        }

        if (isset($this->credentials['publishable_key'])) {
            $publishable_key = $this->credentials['publishable_key'];
        }
        
        if (isset($payload['public_key'])) {
            $publishable_key = $payload['public_key'];
        }
        if (substr( $publishable_key, 0, 13 ) === "ISPubKey_test") {
            $this->env ='test';
            return;
        }

        if (substr( $token, 0, 16 ) === "ISSecretKey_test") {
            $this->env ='test';
            return;
        }
        if (substr( $publishable_key, 0, 13 ) === "ISPubKey_live") {
            $this->env ='live';
            return;
        }

        if (substr( $token, 0, 16 ) === "ISSecretKey_live") {
            $this->env ='live';
            return;
        }
        throw new \Exception('Invalid tokens provided. We could not identify the target enviroment for this request');
    }

    private function send_request($method, $url, $payload = null, $auth= true)
    {
        $headers = [
            'Content-Type' => 'application/json'
        ];
        if (isset($this->credentials['token']) && $auth) {
            $headers = [
                'Authorization' => 'Bearer ' . $this->credentials['token'],
                'Content-Type' => 'application/json'
            ];
        }

        $this->get_env_call($payload);
        $client = new Client();
        $response = $client->request($method, $this->base_url() . $url, [
            'body' => $payload,
            'headers' => $headers
        ]);

        $response = json_decode($response->getBody()->getContents());
        return $response;
    }
}
