<?php
namespace IntaSend\IntaSendPHP;

use IntaSend\IntaSendPHP\Traits\BaseAPITrait;

class Chagebacks  
{
    use BaseAPITrait;

    public function init($credentials)
    {
        $this->credentials=$credentials;
    }

    public function create($invoice, $amount, $reason, $reason_details=null)
    {
        $payload=[
            'invoice'=> $invoice,
            'amount'=> $amount,
            'reason'=> $reason,
            'reason_details'=> $reason_details
        ];
        $payload=json_encode($payload);
        return $this->send_request('POST','/chargebacks/',$payload);
    }

    public function retrieve($chargeback_id=null){
        if ($chargeback_id) {
           return $this->details($chargeback_id);
        }
        return $this->send_request('GET','/chargebacks/');
    }

    public function details($chargeback_id)
    {
        return $this->send_request('GET','/chargebacks/'.$chargeback_id);
    }
    
}
