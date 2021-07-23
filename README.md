# IntaSend Payments Gateway - PHP SDK

## Official documentation

Checkout our [API documentation](https://developers.intasend.com/) for more details and for payload references.

## How to install

    composer require intasend/intasend-php


## Examples

    # Remember to switch of test when going live by set it to False

    # Wallets Management
    use IntaSend\IntaSendPHP\Wallet;

    $credentials=[
        'token'=>'<YOUR-TOKEN-HERE>',
        'publishable_key'=>'<YOUR-PUBLISHABLE_KEY-HERE>',
        'private_key'=>'<YOUR-PRIVATE_KEY-HERE>',
        'test'=>true,
    ];
    $wallet=new Wallet();
    $wallet->init($credentials);

    $response = $wallet->retrieve()
    print_r(response);

    $response = $wallet->details(<WALLET-ID>)
    print_r(response);

    $response = $wallet->transactions(<WALLET-ID>)
    print_r(response);
    
    $response = $wallet->create("GBP")
    print_r(response);

    # Fund specific wallet
    $response = $wallet->fund(<wallet_id>, <phone_number>, <email>, <amount>, <narrative>, <currency>, $api_ref>, <name>)
    print_r(response);

    # Wallet to wallet transfers
    $response = $wallet->intra_transfer(<WALLET-ID-1>, <WALLET-ID-2>, 1, "Charge capture")
    print_r(response);

