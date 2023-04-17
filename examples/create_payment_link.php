<?php 
namespace examples;

require_once '../vendor/autoload.php';

use IntaSend\IntaSendPHP\PaymentLink;

$credentials = [
    'publishable_key' => 'ISPubKey_test_91ffc81a-8ac4-419e-8008-7091caa8d73f',
    'token' => 'ISSecretKey_test_adb0c1be-b608-4934-8882-b203929ea8f9'
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