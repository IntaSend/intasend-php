<?php
namespace IntaSend\IntaSendPHP;

use IntaSend\IntaSendPHP\Traits\BaseAPITrait;

class PaymentLink  
{
    use BaseAPITrait;

    public function init($credentials)
    {
        $this->credentials=$credentials;
    }

    public function create($title, $currency, $amount=0, $mobile_tarrif="BUSINESS-PAYS", $card_tarrif="BUSINESS-PAYS", $is_active=True)
    {
        $payload=[
            'title'=> $title,
            'currency'=> $currency,
            'amount'=> $amount,
            'mobile_tarrif'=> $mobile_tarrif,
            'card_tarrif'=> $card_tarrif,
            'is_active'=> $is_active
        ];
        $payload=json_encode($payload);
        return $this->send_request('POST','/paymentlinks/',$payload);
    }

    public function retrieve($link_id=null){
        if ($link_id) {
           return $this->details($link_id);
        }
        return $this->send_request('GET','/paymentlinks/');
    }

    public function details($link_id)
    {
        return $this->send_request('GET','/paymentlinks/'.$link_id);
    }
}
