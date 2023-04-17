<?php
namespace examples;

require_once '../vendor/autoload.php';

use IntaSend\IntaSendPHP\Collection;

$credentials = [
    'publishable_key' =>  'ADD-YOUR-KEY-FROM-SANDBOX.INTASEND.COM',
    'token' => 'ADD-YOUR-SECRET-KEY-FROM-SANDBOX.INTASEND.COM'
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