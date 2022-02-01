<?php
use Illuminate\Http\Request;
use IntaSend\IntaSendPHP\Checkout;
use IntaSend\IntaSendPHP\Customer;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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

/**
 * When using the redirect URL, IntaSend will append additional parameters to your URL to help you verify the 
 * request and update your records. The signature expires after 10 mins, consider updating your record once you
 * receive it.
 * 
 * Example: How to returned signature and payment status
 */
Route::get('/callback', function (Request $request) {
    $signature = $request->input('signature');
    $checkout_id = $request->input('checkout_id');
    $tracking_id = $request->input('tracking_id');

    $credentials = [
        'publishable_key' =>  env('INTASEND_PUBLISHABLE_KEY'),
        'token' =>  env('INTASEND_API_KEY'),
        'test' =>  env('INTASEND_TEST_ENVIRONMENT', true),
    ];
    $checkout = new Checkout();
    $checkout->init($credentials);
    $resp = $checkout->check_status($signature, $checkout_id, $tracking_id);

    // Check the returned api_ref, verify state, amount, currency etc, and update your records accordingly
    print_r($resp);
    return $resp->invoice->state;
});
