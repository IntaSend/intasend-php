# IntaSend Laravel Playground

## How to install

    composer require intasend/intasend-php

## How to collect payments

Example on how to generate payment secure URL and handle payment confirmation and redirection.

Navigate to `routes/web.php` for full code example

Include IntaSend Checkout service

    use IntaSend\IntaSendPHP\Checkout;

Use it in route i.e where users can generate the check-out url

    Route::get('/', function () {
        $credentials = [
            'publishable_key' => 'ISPubKey_test_d798a963-fdbc-48aa-aeaa-6b14345a10d8',
            'token' => "129e5c9c765db4b42d0b5a25ad8ed626c6642bd7ce9697368529cb2b3fa0e1ea",
            'test' => true,
        ];

        $checkout = new Checkout();

        $checkout->init($credentials);

        $amount = 10;
        $currency = "KES";
        $email = "joe@doe.com";
        $redirect_url = "https://example.com";
        $resp = $checkout->create($amount = $amount, $currency, $email = $email, $first_name = null, $last_name = null, $country = null, $redirect_url, $phone_number = null, $api_ref = null, $comment = null, $address = null, $city = null, $state = null, $method = null, $card_tarrif = "BUSINESS-PAYS", $mobile_tarrif = "BUSINESS-PAYS");
    
        return redirect($resp->url);
    });
