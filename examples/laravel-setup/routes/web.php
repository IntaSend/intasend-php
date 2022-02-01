<?php

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

Route::get('/', function () {
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
    $redirect_url = "https://example.com";
    $ref_order_number = "test-order-10";


    $checkout = new Checkout();
    $checkout->init($credentials);
    $resp = $checkout->create($amount, $currency, $customer, $redirect_url = $redirect_url, $api_ref = $ref_order_number);

    return redirect($resp->url);
});
