<?php
namespace examples;

require_once '../vendor/autoload.php';

use IntaSend\IntaSendPHP\Collection;

$credentials = [
    'publishable_key' =>  'ISPubKey_test_91ffc81a-8ac4-419e-8008-7091caa8d73f',
    'token' => 'ISSecretKey_test_adb0c1be-b608-4934-8882-b203929ea8f9'
];

$collection = new Collection();
$collection->init($credentials);

$amount = 10;
$phone_number = "254723890353";
$api_ref = "ORDER-1";
$response = $collection->mpesa_stk_push($amount, $phone_number, $api_ref);
print_r($response);

$invoice = $response->invoice;
$invoice_id = $invoice->invoice_id;
$response = $collection->status($invoice_id);
print_r($response);