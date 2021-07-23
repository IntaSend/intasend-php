<?php
namespace IntaSend\IntaSendPHP\Traits;

trait BaseAPITrait
{
    private $credentials;

    private function base_url()
    {
        if ($this->credentials['test']===true) {
            return 'https://sandbox.intasend.com/api/v1';
        }
        return 'https://payment.intasend.com/api/v1';
    }

    private function send_request($method,$url,$payload = null)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->base_url().$url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS =>$payload,
        CURLOPT_HTTPHEADER => array(
            "Authorization:Bearer ".$this->credentials['token'],
            "Content-Type: application/json"
        ),
        ));

        try {
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            $response=json_decode($response);
            return $response;
        } catch (\Throwable $th) {
            return $th;
        }
    }
}