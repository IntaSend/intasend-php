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

    public function create($amount=null, $currency, $email=null, $first_name=null, $last_name=null, $country=null, $redirect_url, $phone_number=null, $api_ref=null, $comment=null, $address=null, $city=null, $state=null, $method=null, $card_tarrif="BUSINESS-PAYS", $mobile_tarrif="BUSINESS-PAYS")
    {
        $payload=[
            "public_key"=>$this->credentials['publishable_key'],
            "amount"=> $amount,
            "currency"=> $currency,
            "email"=> $email,
            "first_name"=> $first_name,
            "last_name"=> $last_name,
            "country"=> $country,
            "redirect_url"=> $redirect_url,
            "phone_number"=> $phone_number,
            "api_ref"=> $api_ref,
            "comment"=> $comment,
            "address"=> $address,
            "city"=> $city,
            "state"=> $state,
            "method"=> $method,
            "card_tarrif"=> $card_tarrif,
            "mobile_tarrif"=> $mobile_tarrif
        ];
        $payload=json_encode($payload);
        return $this->send_request('POST','/checkout/',$payload);
    }
}
