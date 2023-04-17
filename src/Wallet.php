<?php
namespace IntaSend\IntaSendPHP;

use IntaSend\IntaSendPHP\Traits\BaseAPITrait;

class Wallet  
{
    use BaseAPITrait;

    public function init($credentials)
    {
        $this->credentials=$credentials;
    }

    public function details($wallet_id)
    {
        return $this->send_request('GET','/wallets/'.$wallet_id.'/');
    }

    public function create($currency, $label, $can_disburse=false)
    {
        $payload=[
            'wallet_type'=> 'WORKING',
            'currency'=> $currency,
            'label'=> $label,
            'can_disburse'=> $can_disburse
        ];
        $payload=json_encode($payload);
        return $this->send_request('POST','/wallets/',$payload);
    }

    public function retrieve($wallet_id=null){
        if ($wallet_id) {
           return $this->details($wallet_id);
        }
        return $this->send_request('GET','/wallets/');
    }

    public function transactions($wallet_id)
    {
        return $this->send_request('GET','/wallets/'.$wallet_id.'/transactions/');
    }

    public function intra_transfer( $origin_id, $destination_id, $amount, $narrative)
    {
        $payload = [
            "wallet_id"=> $destination_id,
            "amount"=> $amount,
            "narrative"=> $narrative
        ];
        $payload=json_encode($payload);
        return $this->send_request('POST','/wallets/'.$origin_id.'/intra_transfer/',$payload);
    }

    public function fund($phone_number, $email=null, $amount, $method="MPESA_STK_PUSH", $currency="KES", $api_ref="API Request", $name=null)
    {
        $collection=new Collection();
        $collection->init($this->credentials);
        return $collection->create($amount, $phone_number, $currency, $method, $api_ref, $name, $email);
    }

}
