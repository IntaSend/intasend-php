<?php
namespace IntaSend\IntaSendPHP;

use IntaSend\IntaSendPHP\Traits\BaseAPITrait;

class Transfer  
{
    use BaseAPITrait;

    public function init($credentials)
    {
        $this->credentials=$credentials;
    }

    public function send_money($device_id, $provider, $currency, $transactions, $callback_url=null, $wallet_id=null)
    {
        $payload=[
            'device_id'=> $device_id,
            'provider'=> $provider,
            'currency'=> $currency,
            'transactions'=> $transactions,
            'callback_url'=> $callback_url,
            'wallet_id' => $wallet_id
        ];
        $payload=json_encode($payload);
        return $this->send_request('POST','/send-money/initiate/',$payload);
    }

    public function approve($payload)
    {
        $sign_message=new AuthenticateService();
        
        $nonce = $payload->nonce;
        $signed_nonce = $sign_message->sign_message($this->credentials['private_key'],$nonce);
        $payload->nonce = $signed_nonce;
        $payload=json_encode($payload);
        return $this->send_request('POST','/send-money/approve/',$payload);
    }

    public function status($tracking_id)
    {
        $payload=[
            'tracking_id'=> $tracking_id,
        ];
        return $this->send_request('POST','/send-money/status/',$payload);
    }

    public function mpesa($device_id, $currency, $transactions, $callback_url=null)
    {
        $provider = "MPESA-B2C";
        return $this->send_money($device_id, $provider, $currency, $transactions, $callback_url=null);
    }

    public function mpesa_b2b($device_id, $currency, $transactions, $callback_url=null)
    {
        $provider = "MPESA-B2B";
        return $this->send_money($device_id, $provider, $currency, $transactions, $callback_url=null);
    }

    public function intasend($device_id, $currency, $transactions, $callback_url=null)
    {
        $provider = "INTASEND";
        return $this->send_money($device_id, $provider, $currency, $transactions, $callback_url=null);
    }

    public function bank($device_id, $currency, $transactions, $callback_url=null)
    {
        $provider = "PESALINK";
        return $this->send_money($device_id, $provider, $currency, $transactions, $callback_url=null);
    }

}
