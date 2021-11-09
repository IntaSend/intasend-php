<?php
namespace IntaSend\IntaSendPHP;

class AuthenticateService
{

    public function sign_message($private_key,$data)
    {

        $binary_signature = "";
        $pkeyid = openssl_get_privatekey($private_key);
        openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA256);
        return bin2hex($binary_signature);
    }

    public function generate_keys()
    {
        $new_key_pair = openssl_pkey_new(array(
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ));
        openssl_pkey_export($new_key_pair, $private_key_pem);
        
        $details = openssl_pkey_get_details($new_key_pair);
        $public_key_pem = $details['key'];
        return [
            'private_key'=>$private_key_pem,
            'public_key'=>$public_key_pem
        ];
    }
}
