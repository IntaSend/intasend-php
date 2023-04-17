<?php 
namespace examples;

require_once '../vendor/autoload.php';

use IntaSend\IntaSendPHP\Wallet;

$credentials = [
    'publishable_key' => 'ADD-YOUR-KEY-FROM-SANDBOX.INTASEND.COM',
    'token' => 'ADD-YOUR-SECRET-KEY-FROM-SANDBOX.INTASEND.COM'
];

$wallet = new Wallet();
$wallet->init($credentials);

$currency = "KES";
$label = "WALLET-1";
$response = $wallet->create($currency, $label);
print_r($response);