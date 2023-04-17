<?php 
namespace examples;

require_once '../vendor/autoload.php';

use IntaSend\IntaSendPHP\Transfer;

$credentials = [
    'publishable_key' => 'ISPubKey_test_91ffc81a-8ac4-419e-8008-7091caa8d73f',
    'token' => 'ISSecretKey_test_adb0c1be-b608-4934-8882-b203929ea8f9'
];

$transfer = new Transfer();
$transfer->init($credentials);

$transactions = [
    ['account'=>'254723890353','amount'=>'2000', 'narrative'=>'Salary'],
    ['account'=>'254723890260','amount'=>'15000', 'narrative'=>'Dividends']
];

$transfer = new Transfer();
$transfer->init($credentials);

$response=$transfer->mpesa("KES", $transactions);

//call approve method for approving last transaction
$response = $transfer->approve($response);
print_r($response);

// Check status
$response = $transfer->status($response->tracking_id);
print_r($response);