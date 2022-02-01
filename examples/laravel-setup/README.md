# IntaSend Laravel Playground

## How to install IntaSend

Use the command below to install the latest version of intasend-php plugin to your app.

    composer require intasend/intasend-php

## How to run Playground and examples

    composer update

    php artisan serve

## How to collect payments

Example on how to generate payment secure URL and handle payment confirmation and redirection.

Navigate to `routes/web.php` for full code example

Include IntaSend Checkout and Customer class

    use IntaSend\IntaSendPHP\Checkout;
    use IntaSend\IntaSendPHP\Customer;

Use it in route i.e where users can generate the check-out url

    Route::get('/checkout', function () {
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

        return redirect($resp->url);
    });

## How to handle returned callback on success

Successful transactions will return a callback with extra parameters if a `$redirect_url` is specified during the checkout  request. Below is an example of how to use the returned values to verify the transaction before updating your record.

    Route::get('/callback', function (Request $request) {
        $signature = $request->input('signature');
        $checkout_id = $request->input('checkout_id');
        $tracking_id = $request->input('tracking_id');

        $checkout = new Checkout();
        $resp = $checkout->check_status($signature, $checkout_id, $tracking_id);

        // Check the returned api_ref, verify state, amount, currency etc, and update your records accordingly
        print_r($resp);
        return $resp;
    });

See the example in `routes/web.php` for more details.
