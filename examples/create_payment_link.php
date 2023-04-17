<?php 
namespace examples;

require_once '../vendor/autoload.php';

use IntaSend\IntaSendPHP\PaymentLink;

$credentials = [
    'publishable_key' => 'ADD-YOUR-KEY-FROM-SANDBOX.INTASEND.COM',
    'token' => 'ADD-YOUR-SECRET-KEY-FROM-SANDBOX.INTASEND.COM'
];

$paymentLink = new PaymentLink();
$paymentLink->init($credentials);

$title = "Service 1";
$currency = "KES";
$amount = 100;

# Specify who should take care of the charges. Set to BUSINESS_PAYS for business to handle.
$mobile_tarrif =  "CUSTOMER_PAYS";
$card_tarrif =  "CUSTOMER_PAYS";
$is_active = "true";

$response = $paymentLink->create($title, $currency, $amount, $mobile_tarrif, $card_tarrif, $is_active);
print_r($response);