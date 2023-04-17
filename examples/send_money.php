<?php 
namespace examples;

require_once '../vendor/autoload.php';

use IntaSend\IntaSendPHP\Transfer;

$credentials = [
    'publishable_key' => 'ADD-YOUR-KEY-FROM-SANDBOX.INTASEND.COM',
    'token' => 'ADD-YOUR-SECRET-KEY-FROM-SANDBOX.INTASEND.COM'
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