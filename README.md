# IntaSend Payments Gateway - PHP SDK

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/1706c482fda1458b97f5ba50f0566a3b)](https://app.codacy.com/gh/IntaSend/intasend-php?utm_source=github.com&utm_medium=referral&utm_content=IntaSend/intasend-php&utm_campaign=Badge_Grade_Settings)

## Official documentation

PHP SDK for [IntaSend Payment Gateway](https://intasend.com). IntaSend enables you to easily add payments to your application with a few lines of code.

Follow the instruction below to install and get started.

Visit our [sandbox/developers](https://sandbox.intasend.com) test for your API Keys.

Checkout our [API documentation](https://developers.intasend.com/) for more details and for payload references.

## How to install

    composer require intasend/intasend-php

## How to authenticate

IntaSend-php supports various IntaSend's payment features. Below are the credentials needed for authentication.

**token** - Is the API token and is required for status checks, chargeback request, send money, and wallet services.
**publishable_key** - Also know as the public key is required during payment collections/checkout only.
**private_key** - Is required for PSD2 requests i.e during send money requests.

If you want to only collect funds and verify its status, you do not need to generate and include the private key.

### How to pass your credentials

Add your credentials from the `.env` (recommended) in an array and include it in your requests. Example:

    $credentials = [
        'token'=>'<YOUR-TOKEN-HERE>',
        'publishable_key'=>'<YOUR-PUBLISHABLE_KEY-HERE>',
        'private_key'=><<<EOD
        <YOUR-PRIVATE_KEY>
        EOD,
        'test'=>true,
    ];

    $checkout = new Checkout();
    $checkout->init($credentials);

In the credentials array, remember to set `test` to `true` for the sandbox environment. Set this flag to `false` when going live

## How to receive payments using Checkout URL

With IntaSend, you can generate a secure checkout page where you redirect your users to complete payments.

Below is a basic example on how to set up. Check full example in your [Laravel playground](examples/laravel-setup/).

        use IntaSend\IntaSendPHP\Checkout;
        use IntaSend\IntaSendPHP\Customer;

        function charge() {
            $credentials = [
                'publishable_key' =>  env('INTASEND_PUBLISHABLE_KEY'),
                'token' =>  env('INTASEND_API_KEY'),
                'test' =>  env('INTASEND_TEST_ENVIRONMENT', true),
            ];

            $customer = new Customer();
            $customer->first_name = "Joe";
            $customer->last_name = "Doe";
            $customer->email = "joe@doe.com";
            $customer->country = "KE";
            $customer->city = "Nairobi";
            $customer->address = "Apt 123, Westland road";
            $customer->zipcode = "0100";
            $customer->state = "Nairobi";

            $amount = 10;
            $currency = "KES";

            // Add your website and redirect url where the user will be redirected on success
            $host = "https://example.com";
            $redirect_url = "https://example.com/callback";
            $ref_order_number = "test-order-10";

            $checkout = new Checkout();
            $checkout->init($credentials);
            $resp = $checkout->create($amount = $amount, $currency = $currency, $customer = $customer, $host=$host, $redirect_url = $redirect_url, $api_ref = $ref_order_number, $comment = null, $method = null);

            print_r($resp->url);
        }

## Working with Wallets

Example on how to create a new wallet, list wallets and other details

### Create a new wallet

    use IntaSend\IntaSendPHP\Wallet;

    $wallet = new Wallet();
    $wallet->init($credentials);
    
    $response = $wallet->create("<currency>", "<label>");
    print_r(response);

### List all wallets in your account

    $response = $wallet->retrieve();
    print_r(response);

### View wallet details and transactions

    $response = $wallet->details('<wallet_id>');
    print_r(response);

    $response = $wallet->transactions('<wallet_id>');
    print_r(response);

### Direct deposit to wallet using M-Pesa STK Push

    $response = $wallet->fund(<phone_number>, <email>, <amount>, <method>, <currency>, $api_ref>, <name>);
    print_r(response);

### Wallet to wallet transfers (Intra-transfer)

Transfer funds between wallets you own

    $response = $wallet->intra_transfer(<origin_wallet_id>, <destination_wallet_id>, <amount>, <narrative>);
    print_r(response);
    
## Chargebacks Management

Examples on how to process refunds using the API

### Raise new refund request

    use IntaSend\IntaSendPHP\Chagebacks;

    $chagebacks = new Chagebacks();
    $hagebacks->init($credentials);

    $response = $chagebacks->create(<invoice_id>, <amount>, <reason>);
    print_r(response);

### Retrieve list of refunds/chargebacks in your account

    $response = $chagebacks->retrieve()
    print_r(response);

### Get details of a chargeback/refund request

    $response = $chagebacks->details(<chagebacks_id>)
    print_r(response);

## How to Send money

    use IntaSend\IntaSendPHP\Transfer;

    $transactions = [
        ['account'=>'254723890353','amount'=>'20'],
        ['account'=>'254723890260','amount'=>'15']
    ];

    $transfer = new Transfer();
    $transfer->init($credentials);

***device_id - Note device id is the PSD2 device id from the dashboard - <https://developers.intasend.com/apis/extra-payment-authentication>**
 
    $response=$transfer->mpesa('<DEVICE-ID>', "KES",$transactions);

    //call approve() method for approving last transaction
    $response = $transfer->approve($response);
    print_r($response);

## How to create Payment links

Payment links are free forms that you can share with your customers on email and social media. Unlike Checkout URL, payment links do not required/include customer details when creating them. The customer is expected to put all the details required.

### Create a payment link

    use IntaSend\IntaSendPHP\PaymentLink;

    $paymentLink = new PaymentLink();
    $paymentLink->init($credentials);

    $response = $paymentLink->create(<title>, <currency>, <amount>,<mobile_tarrif>, <card_tarrif>, <is_active>);
    print_r(response);

### List or retrive details of payment links

    $response = $paymentLink->retrieve()
    print_r(response);

    $response = $paymentLink->details(<link_id>)
    print_r(response);

## Addition - How to send M-Pesa STK-Push (Express)

Checkout API generates a URL that enables you to do M-Pesa collection and other payment methods. In case you want to leverage only the M-Pesa STK-Push option, you might want to consider this the `collection->create()` option.

    use IntaSend\IntaSendPHP\Collection;

    $collection = new Collection();
    $collection->init($credentials);

    $response = $collection->create(<currency>,<method>,<amount>,<phone_number>,<api_ref>,<name>,<email>);
    print_r(response);

    $response = $collection->status(<invoice_id>)
    print_r(response);

## Documentation and Resources

1. [Developers Documentation](https://developers.intasend.com)
2. [Test and sandbox environment](https://sandbox.intasend.com)
3. [Support](https://support.intasend.com)
4. [Telegram](https://t.me/joinchat/2vIT1nrYvkc0MWQ0)
