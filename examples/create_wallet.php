<?php 
namespace examples;

require_once '../vendor/autoload.php';

use IntaSend\IntaSendPHP\Wallet;

$credentials = [
    'publishable_key' => 'ISPubKey_test_91ffc81a-8ac4-419e-8008-7091caa8d73f',
    'token' => 'ISSecretKey_test_adb0c1be-b608-4934-8882-b203929ea8f9'
];

$wallet = new Wallet();
$wallet->init($credentials);

$currency = "KES";
$label = "WALLET-1";
$response = $wallet->create($currency, $label);
print_r($response);