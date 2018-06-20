<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;

class PaymentsController extends Controller
{
    public function index()
    {
        dump(session()->has('amount'));
        return view('front.payments.index');
    }

    public function setAmount(Request $request)
    {
        session()->flash('amount', $request->amount * 100);

        return redirect()->action('Front\PaymentsController@index');
    }

    public function handlePayment(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $customer = Customer::create([
            'email' => $request->stripeEmail,
            'source' => $request->stripeToken,
        ]);

        Charge::create([
            'customer' => $customer->id,
            'amount' => $request->amount,
            'currency' => 'EUR',
        ]);

        flash()->info('Your payment was successfull! Thank you!');

        return redirect()->action('Front\PaymentsController@index');
    }
}
