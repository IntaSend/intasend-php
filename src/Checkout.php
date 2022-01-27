<?php
namespace IntaSend\IntaSendPHP;

use IntaSend\IntaSendPHP\Traits\BaseAPITrait;

class Checkout  
{
    use BaseAPITrait;

    public function init($credentials)
    {
        $this->credentials=$credentials;
    }

    public function create($amount=0, $currency, $email, $first_name, $last_name, $country, $redirect_url)
    {
        $payload=[
            "public_key"=>$this->credentials['publishable_key'],
            "amount"=> $amount,
            "currency"=> $currency,
            "email"=> $email,
            "first_name"=> $first_name,
            "last_name"=> $last_name,
            "country"=> $country,
            "redirect_url"=> $redirect_url
        ];
        $payload=json_encode($payload);
        return $this->send_request('POST','/checkout/',$payload);
    }
}
