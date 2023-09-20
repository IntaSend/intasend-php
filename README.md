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

### How to pass your credentials

Add your credentials from the `.env` (recommended) in an array and include it in your requests. Example:

    $credentials = [
        'token'=>'<YOUR-SECRET-TOKEN-HERE>',
        'publishable_key'=>'<YOUR-PUBLISHABLE_KEY-HERE>'
    ];

    $checkout = new Checkout();
    $checkout->init($credentials);


## How to receive payments using Checkout URL

With IntaSend, you can generate a secure checkout page where you redirect your users to complete payments.

Below is a basic example on how to set up. Check full example in your [Laravel playground](examples/laravel-setup/).

    use IntaSend\IntaSendPHP\Checkout;
    use IntaSend\IntaSendPHP\Customer;

    $credentials = [
    'publishable_key' =>  env('INTASEND_PUBLISHABLE_KEY'),
    'test' =>  env('INTASEND_TEST_ENVIRONMENT', true),
    ];

    $customer = new Customer();
    $customer->first_name = "Joe";
    $customer->last_name = "Doe";
    $customer->email = "joe@doe.com";
    $customer->country = "KE";

    $amount = 10;
    $currency = "KES";

    // Add your website and redirect url where the user will be redirected on success
    $host = "https://example.com";
    $redirect_url = "https://example.com/callback";
    $ref_order_number = "test-order-10";

    $checkout = new Checkout();
    $checkout->init($credentials);
    $resp = $checkout->create($amount = $amount, $currency = $currency, $customer = $customer, $host=$host, $redirect_url = $redirect_url, $api_ref = $ref_order_number, $comment = null, $method = null);

    // Redirect the user to the URL to complete payment
    print_r($resp->url);

## Send M-Pesa STK-Push

Checkout API generates a URL that enables you to do M-Pesa collection and other payment methods. In case you want to leverage only the M-Pesa STK-Push option, you might want to consider this the `collection->mpesa_stk_push()` option.

    use IntaSend\IntaSendPHP\Collection;
    $credentials = [
    'publishable_key' =>  env('INTASEND_PUBLISHABLE_KEY'),
    'test' =>  env('INTASEND_TEST_ENVIRONMENT', true),
    ];


    $collection = new Collection();
    $collection->init($credentials);

    $response = $collection->create($amount=10, $phone_number="2547...", $currency="KES", $method="MPESA_STK_PUSH", $api_ref="Your API Ref", $name="", $email="john@example.com");
    print_r($response);

## How to create Payment links

Payment links are free forms that you can share with your customers on email and social media. Unlike Checkout URL, payment links do not required/include customer details when creating them. The customer is expected to put all the details required.

### Create a payment link

    use IntaSend\IntaSendPHP\PaymentLink;

    $credentials = [
        'token'=>'<YOUR-SECRET-TOKEN-HERE>',
        'publishable_key'=>'<YOUR-PUBLISHABLE_KEY-HERE>'
    ];

    $paymentLink = new PaymentLink();
    $paymentLink->init($credentials);

    $title = "Service 1";
    $currency = "KES";
    $amount = 100;

    # Specify who should take care of the charges. Set to BUSINESS_PAYS for business to handle.

    $mobile_tarrif =  "CUSTOMER_PAYS";
    $card_tarrif =  "CUSTOMER_PAYS";
    $is_active = "true";

    $response = $paymentLink->create($title, $currency, $amount, $mobile_tarrif, $card_tarrif, $is_active);
    print_r($response);

### List or retrive details of payment links by ID

    $response = $paymentLink->retrieve()
    print_r($response);

    $link_id = "AKSL1O1";
    $response = $paymentLink->details($link_id);
    print_r($response);

## How to Send Money to M-Pesa B2C

    use IntaSend\IntaSendPHP\Transfer;

    $credentials = [
        'token'=>'<YOUR-SECRET-TOKEN-HERE>',
        'publishable_key'=>'<YOUR-PUBLISHABLE_KEY-HERE>'
    ];

    $transactions = [
        ['account'=>'254723890353','amount'=>'20'],
        ['account'=>'254723890260','amount'=>'15']
    ];

    $transfer = new Transfer();
    $transfer->init($credentials);

    $response=$transfer->mpesa("KES", $transactions);

    //call approve method for approving last transaction
    $response = $transfer->approve($response);
    print_r($response);

    // How to check or track the transfer status
    $response = $transfer->status($response->tracking_id);
    print_r($response);

## How to Send Money to M-Pesa PayBill

To send money to M-Pesa PayBills, specify business number under account and an account reference as shown below.

    use IntaSend\IntaSendPHP\Transfer;

    $credentials = [
        'token'=>'<YOUR-SECRET-TOKEN-HERE>',
        'publishable_key'=>'<YOUR-PUBLISHABLE_KEY-HERE>'
    ];

    $transactions = [
        ['account'=>'247247', 'account_type'=>'PayBill', 'account_reference'=>'1001200010',  'amount'=>'2000', 'narrative'=>'Trip']
    ];

    $transfer = new Transfer();
    $transfer->init($credentials);
 
    $response=$transfer->mpesa("KES", $transactions);

    //call approve method for approving last transaction
    $response = $transfer->approve($response);
    print_r($response);

## How to Send Money to M-Pesa Till Number or PayBill

To send money to Till Numbers, simply specify the account number. No account reference is requred.

    use IntaSend\IntaSendPHP\Transfer;

    $credentials = [
        'token'=>'<YOUR-SECRET-TOKEN-HERE>',
        'publishable_key'=>'<YOUR-PUBLISHABLE_KEY-HERE>'
    ];

    $transactions = [
        ['name' => 'Business A','account'=>'524311','amount'=>'200', 'account_type'=>'PayBill', 'account_reference'=>'29822182', 'narrative'=> 'Bill Payment'],
        ['name' => 'Business B','account'=>'17626','amount'=>'150', 'account_type'=>'TillNumber', 'narrative'=> 'Purchase']
    ];

    $transfer = new Transfer();
    $transfer->init($credentials);

    $response=$transfer->mpesa_b2b("KES", $transactions);

    //call approve method for approving last transaction
    $response = $transfer->approve($response);
    print_r($response);

## How to Send to Bank

You'll need a bank code and account numbers to send bank payments. Here is a [list of bank codes](https://developers.intasend.com/docs/bank#list-of-bank-codes) for your reference

    use IntaSend\IntaSendPHP\Transfer;

    $credentials = [
        'token'=>'<YOUR-SECRET-TOKEN-HERE>',
        'publishable_key'=>'<YOUR-PUBLISHABLE_KEY-HERE>'
    ];

    $transactions = [
        ['name' => 'Joe Doe','account'=>'0129292920202','amount'=>'200', 'bank_code'=>'2', 'narrative'=> 'Bill Payment'],
        ['name' => 'Mary Doe','account'=>'525623632321','amount'=>'150', 'bank_code'=>'11', 'narrative'=> 'Purchase']
    ];

    $transfer = new Transfer();
    $transfer->init($credentials);

    $response=$transfer->bank("KES", $transactions);

    //call approve method for approving last transaction
    $response = $transfer->approve($response);
    print_r($response);

## How to Send Airtime

    use IntaSend\IntaSendPHP\Transfer;

    $credentials = [
        'token'=>'<YOUR-SECRET-TOKEN-HERE>',
        'publishable_key'=>'<YOUR-PUBLISHABLE_KEY-HERE>'
    ];

    $transactions = [
        ['account'=>'254723890353','amount'=>'20', 'narrative'=>'Airtime'],
        ['account'=>'254723890260','amount'=>'15', 'narrative'=>'Airtime']
    ];

    $transfer = new Transfer();
    $transfer->init($credentials);
 
    $response=$transfer->airtime("KES", $transactions);

    //call approve method for approving last transaction
    $response = $transfer->approve($response);
    print_r($response);


## Working with Wallets

Example on how to create a new wallet, list wallets and other details

### Create a new wallet

    use IntaSend\IntaSendPHP\Wallet;

    $credentials = [
        'token'=>'<YOUR-SECRET-TOKEN-HERE>',
        'publishable_key'=>'<YOUR-PUBLISHABLE_KEY-HERE>'
    ];

    $wallet = new Wallet();
    $wallet->init($credentials);
    
    $response = $wallet->create($currency='KES', $label='MY-WALLET-ID', $can_disburse=true);
    print_r($response); 

### List all wallets in your account

    $response = $wallet->retrieve();
    print_r($response);

### View wallet details and its transactions

    $response = $wallet->transactions('<wallet_id>');
    print_r($response);

    $response = $wallet->transactions($wallet_id);
    print_r($response);

### Direct deposit to wallet using M-Pesa STK Push

    $response = $wallet->fund_mpesa_stk_push($wallet_id="<wallet_id>", $phone_number='2547...',$email='john@doe.com', $amount=10, $api_ref="API Request");
    print_r($response);

### Direct deposit to wallet with Checkout Method

    use IntaSend\IntaSendPHP\Customer;

    $customer = new Customer();
    $customer->first_name = "Joe";
    $customer->last_name = "Doe";
    $customer->email = "joe@doe.com";
    $customer->country = "KE";

    $host = "https://example.com";
    $redirect_url = "https://example.com";

    $ref_order_number = "fund-wallet-10";

    $response = $wallet->fund_checkout($wallet_id="<wallet_id>", $phone_number='2547..', $currency='USD', $customer=$customer, $amount=10, $host=$host, $redirect_url=$redirect_url, $api_ref=$ref_order_number, $card_tarrif = "BUSINESS-PAYS", $mobile_tarrif = "BUSINESS-PAYS");
    print_r($response->url);

### Wallet to wallet transfers (Intra-transfer)

Transfer funds between wallets in your account

    $origin_wallet_id = "ABSKC10";
    $destination_wallet_id = "DDS0911";
    $amount = 100;
    $narrative = "Commission deduction";

    $response = $wallet->intra_transfer($origin_wallet_id, $destination_wallet_id, $amount, $narrative);
    print_r($response);

### External Wallet Transfer to M-PESA
    use IntaSend\IntaSendPHP\Transfer;

    $transactions = [
                ['account'=>'254...','amount'=>'20'],
                ['account'=>'254...','amount'=>'15']
            ];

    $response=$transfer->mpesa("KES", $transactions=$transactions, $callback_url=null,  $wallet_id='<wallet_id>');
    print_r($response);

    Like all other Send Money APIs, the above request is also a two step. Please go through the send money examples on full implementation for M-Pesa B2C, M-Pesa B2B, Bank Payouts and IntaSend P2P.
    
## Chargebacks Management

Examples on how to process refunds using the API

### Raise new refund request

    use IntaSend\IntaSendPHP\Chagebacks;

    $credentials = [
        'token'=>'<YOUR-SECRET-TOKEN-HERE>',
        'publishable_key'=>'<YOUR-PUBLISHABLE_KEY-HERE>'
    ];

    $chagebacks = new Chagebacks();
    $hagebacks->init($credentials);

    $invoice_id = "INVOS012";
    $amount = 100;
    $reason = "Delayed delivery";

    $response = $chagebacks->create($invoice_id, $amount, $reason);
    print_r($response);

### Retrieve list of refunds/chargebacks in your account

    $response = $chagebacks->retrieve();
    print_r($response);

### Get details of a chargeback/refund request

    $chagebacks_id = "CHSK102";

    $response = $chagebacks->details($chagebacks_id);
    print_r($response);


## Documentation and Resources

1. [Developers Documentation](https://developers.intasend.com)
2. [Test and sandbox environment](https://sandbox.intasend.com)
3. [Support](https://support.intasend.com)
4. [Telegram](https://t.me/joinchat/2vIT1nrYvkc0MWQ0)
