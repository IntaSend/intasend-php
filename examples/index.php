<?php
namespace plugin;

require_once 'vendor/autoload.php';

use IntaSend\IntaSendPHP\Transfer;

$private_key ="
-----BEGIN RSA PRIVATE KEY-----
MIICWwIBAAKBgQCDMRJkZxSBsOX/qjW/+RWRu6RN1oKIYfXBRttA/VytbZ5Y9WVY
pN/iYPsB8EjP/GucRGefJCmrdxDZKBZ6IN8AY0QSmDwOCSEg9XP3lUpGu60tWA5L
LMUPGsS7LweHhyVHZRC1cJgNuAal9+Z6KdJpLbCCfSh3BsC24zV5xDIQVQIDAQAB
AoGAH2wUfKnX1oxZOlg5UYbGbMZlvyL+1s2nwChJgZJtrThRMftsz8OFwEH8POWh
evd5is8zhoFx3ZjCF1EruQrAfo5X9kTlIkEYiCZZFlJyYqt9KQzMhrdiZghqyYTN
JraRP4zHo2oedpHY+jg42igYh7zBfqUCWfrgx7dxGVbPLI0CQQDCQSMqIdCCZsig
gJWuauqBQfJ0FmrmH2G4Jkmj/QD+klRUVnyOWmaKbTiZtyYsxOHC4dKxSibYlxy8
Ff5syqizAkEArORlJlIYgF72alxA8wLUggzTXNLhE5k+PlF/2kqLsRHMO8ebzQZn
W0WAM41oW+0w9ZeGDcXEwJIqMF+DkAUW1wJAA/mLO6h3eMObpVUcOvZrF/v+dwui
YlUQDdGSvi1GIO9jlFo0sED/SiPT/ak2ucHJkNBIHGKVCueEqgCVNSqsawJAVbTD
D8QSsVBiB0fESrNUdUO2Y4WGXhjRakMshiH+LcEM5XWGHpTWF8DUVLn8ydVDN/vt
UFaBupS6pVAz/+kF8QJAX6CTpfTaMJs+lNhr5kPQTNxDt+tHO2pFUrTy4NdG5A06
WKE31n/uyOdhcFnF2EW2NBVICO5MUlf0ZADETOoxug==
-----END RSA PRIVATE KEY-----";

$credentials = [
    'token'=>'130046db2bedc03bcc961878a5ab9fb84b1b0657ab832e14206b81a7e574ec8e',
    'publishable_key'=>'<YOUR-PUBLISHABLE_KEY-HERE>',
    'private_key'=>$private_key,
    'test'=>true,
];

$transactions = [
    ['account'=>'254723890353','amount'=>'20'],
    ['account'=>'254723890260','amount'=>'15']
];

$transfer = new Transfer();
$transfer->init($credentials);


$response=$transfer->mpesa('WVYBVQ4', "KES",$transactions);
print_r($response);
print_r("Call approve");
$response = $transfer->approve($response);
print_r($response);

