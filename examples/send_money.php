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

$requires_approval = 'YES'; // Set to 'NO' if you want the transaction to go through without calling the approve method

$transfer = new Transfer();
$transfer->init($credentials);

$response=$transfer->mpesa("KES", $transactions, $requires_approval=$requires_approval);

//call approve method for approving last transaction if requires_approval = 'YES
if( $requires_approval === 'YES' ){
    $response = $transfer->approve($response);
    print_r($response);
};

// Check status
$response = $transfer->status($response->tracking_id);
print_r($response);