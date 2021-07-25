# IntaSend Payments Gateway - PHP SDK

## Official documentation

Checkout our [API documentation](https://developers.intasend.com/) for more details and for payload references.

## How to install

    composer require intasend/intasend-php

## How to use

    # Remember to switch of test when going live by set it to False

    # Wallets Management
    use IntaSend\IntaSendPHP\Wallet;

    $credentials = [
        'token'=>'<YOUR-TOKEN-HERE>',
        'publishable_key'=>'<YOUR-PUBLISHABLE_KEY-HERE>',
        'private_key'=><<<EOD
        <YOUR-PRIVATE_KEY>
        EOD,
        'test'=>true,
    ];

    $wallet = new Wallet();
    $wallet->init($credentials);

    $response = $wallet->retrieve()
    print_r(response);

    $response = $wallet->details('<wallet_id>')
    print_r(response);

    $response = $wallet->transactions('<wallet_id>')
    print_r(response);
    
    $response = $wallet->create("<currency>")
    print_r(response);

    # Fund specific wallet
    $response = $wallet->fund(<phone_number>, <email>, <amount>, <method>, <currency>, $api_ref>, <name>)
    print_r(response);

    # Wallet to wallet transfers
    $response = $wallet->intra_transfer(<origin_wallet_id>, <destination_wallet_id>, <amount>, <narrative>)
    print_r(response);
    
    # Chargebacks Management

    use IntaSend\IntaSendPHP\Chagebacks;

    $credentials = [
        'token'=>'<YOUR-TOKEN-HERE>',
        'publishable_key'=>'<YOUR-PUBLISHABLE_KEY-HERE>',
        'private_key'=><<<EOD
        <YOUR-PRIVATE_KEY>
        EOD,
        'test'=>true,
    ];
    $chagebacks = new Chagebacks();
    $hagebacks->init($credentials);

    $response = $chagebacks->retrieve()
    print_r(response);

    $response = $chagebacks->details(<chagebacks_id>)
    print_r(response);

    $response = $chagebacks->create(<invoice_id>, <amount>, <reason>);
    print_r(response);

    # Send money

    use IntaSend\IntaSendPHP\Transfer;

    $credentials = [
        'token'=>'<YOUR-TOKEN-HERE>',
        'publishable_key'=>'<YOUR-PUBLISHABLE_KEY-HERE>',
        'private_key'=><<<EOD
        <YOUR-PRIVATE_KEY>
        EOD,
        'test'=>true,
    ];

    $transactions = [
        ['account'=>'254723890353','amount'=>'20'],
        ['account'=>'254723890260','amount'=>'15']
    ];

    $transfer = new Transfer();
    $transfer->init($credentials);

    ## device_id - Note device id is the PSD2 device id from the dashboard - https://developers.intasend.com/apis/extra-payment-authentication
    $response=$transfer->mpesa('<DEVICE-ID>', "KES",$transactions);
    //call approve() method for approving last transaction
    $response = $transfer->approve($response);
    print_r($response);

    # Create payment link
    use IntaSend\IntaSendPHP\PaymentLink;

    $credentials=[
        'token'=>'<YOUR-TOKEN-HERE>',
        'publishable_key'=>'<YOUR-PUBLISHABLE_KEY-HERE>',
        'private_key'=><<<EOD
        <YOUR-PRIVATE_KEY>
        EOD,
        'test'=>true,
    ];

    $paymentLink = new PaymentLink();
    $paymentLink->init($credentials);

    $response = $paymentLink->create(<title>, <currency>, <amount>,<mobile_tarrif>, <card_tarrif>, <is_active>);
    print_r(response);

    $response = $paymentLink->retrieve()
    print_r(response);

    $response = $paymentLink->details(<link_id>)
    print_r(response);

    # Payment Collection(M-Pesa)
    use IntaSend\IntaSendPHP\Collection;

    $credentials=[
        'token'=>'<YOUR-TOKEN-HERE>',
        'publishable_key'=>'<YOUR-PUBLISHABLE_KEY-HERE>',
        'private_key'=><<<EOD
        <YOUR-PRIVATE_KEY>
        EOD,
        'test'=>true,
    ];

    $collection = new Collection();
    $collection->init($credentials);

    $response = $collection->create(<publishable_key>,<currency>,<method>,<amount>,<phone_number>,<api_ref>,<name>,<email>);
    print_r(response);

    $response = $collection->status(<public_key>, <invoice_id>)
    print_r(response);