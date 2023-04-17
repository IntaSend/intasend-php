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

    public function create($amount, $phone_number, $currency="KES", $method="MPESA_STK_PUSH", $api_ref="API Request", $name=null, $email=null)
    {
        if ($method == 'MPESA_STK_PUSH') {
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
            return $this->send_request('POST','/payment/mpesa-stk-push/',$payload);
        }
        throw new Exception('Not implemented for method '.$method);
    }

    /**
     * Shortcut method to send MPesa STK Push request
     */
    public function mpesa_stk_push($amount, $phone_number, $api_ref="API Request", $name=null, $email=null) {
        return $this->create($amount, $phone_number, "KES", "MPESA_STK_PUSH", $api_ref, $name, $email);
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
