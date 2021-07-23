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

    public function create($public_key, $currency="KES", $method, $amount, $phone_number, $api_ref="API Request", $name=null, $email=null)
    {
        $payload=[
            'public_key'=> $public_key,
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

    public function status($public_key, $invoice_id)
    {
        $payload=[
            'public_key'=> $public_key,
            'invoice_id'=> $invoice_id,
        ];
        $payload=json_encode($payload);
        return $this->send_request('POST','/payment/status/',$payload);
    }

}
