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

    public function fund_mpesa_stk_push($wallet_id, $phone_number, $email=null, $amount, $api_ref="API Request")
    {
        $collection=new Collection();
        $collection->init($this->credentials);
        return $collection->create($amount=$amount, $phone_number=$phone_number, $currency="KES", $method="MPESA_STK_PUSH", $api_ref=$api_ref, $email=null, $wallet_id=$wallet_id);
    }

    public function fund_checkout($wallet_id, $currency, $customer, $amount, $host, $redirect_url=null, $api_ref="API Request", $card_tarrif = "BUSINESS-PAYS", $mobile_tarrif = "BUSINESS-PAYS"){
        $checkout = new Checkout();
        $checkout->init($this->credentials);

        return $checkout->create($amount = $amount, $currency = $currency, $customer = $customer, $host=$host, $redirect_url = $redirect_url, $api_ref = $api_ref, $comment = null, $method = null, $card_tarrif = "BUSINESS-PAYS", $mobile_tarrif = "BUSINESS-PAYS", $wallet_id=$wallet_id);

    }

}
