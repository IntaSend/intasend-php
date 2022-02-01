<?php

namespace IntaSend\IntaSendPHP;

use IntaSend\IntaSendPHP\Traits\BaseAPITrait;
use IntaSend\IntaSendPHP\Customer;

class Checkout
{
    use BaseAPITrait;

    public function init($credentials)
    {
        $this->credentials = $credentials;
    }

    public function create($amount, $currency, Customer $customer, ?string $redirect_url, ?string $api_ref , ?string $comment, ?string $method, $card_tarrif = "BUSINESS-PAYS", $mobile_tarrif = "BUSINESS-PAYS",)
    {
        $payload = [
            "public_key" => $this->credentials['publishable_key'],
            "amount" => $amount,
            "currency" => $currency,
            "email" => $customer->email,
            "first_name" => $customer->first_name,
            "last_name" => $customer->last_name,
            "country" => $customer->country,
            "phone_number" => $customer->phone_number,
            "address" => $customer->address,
            "city" => $customer->city,
            "state" => $customer->state,
            "zipcode" => $customer->zipcode,
            "redirect_url" => $redirect_url,
            "method" => $method,
            "api_ref" => $api_ref,
            "comment" => $comment,
            "card_tarrif" => $card_tarrif,
            "mobile_tarrif" => $mobile_tarrif
        ];
        $payload = json_encode($payload);
        return $this->send_request('POST', '/checkout/', $payload);
    }
}
