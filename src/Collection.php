<?php
namespace IntaSend\IntaSendPHP;

use IntaSend\IntaSendPHP\Traits\BaseAPITrait;

class Collection
{
    use BaseAPITrait;

    public function init($credentials)
    {
        $this->credentials=$credentials;
    }

    public function create($currency="KES", $method, $amount, $phone_number, $api_ref="API Request", $name=null, $email=null)
    {
        $payload=[
            'public_key'=> $this->credentials['publishable_key'],
            'currency'=> $currency,
            'method'=> $method,
            'amount'=> $amount,
            'api_ref'=> $api_ref,
            'name'=> $name,
            'phone_number'=> $phone_number,
            'email'=> $email,
        ];
        $payload=json_encode($payload);
        return $this->send_request('POST','/payment/collection/',$payload);
    }

    public function status($invoice_id)
    {
        $payload=[
            'public_key'=> $this->credentials['publishable_key'],
            'invoice_id'=> $invoice_id,
        ];
        $payload=json_encode($payload);
        return $this->send_request('POST','/payment/status/',$payload);
    }

}
