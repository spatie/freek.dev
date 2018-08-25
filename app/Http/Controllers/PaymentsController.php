<?php

namespace App\Http\Controllers;

use App\Mail\PaymentFailed;
use App\Mail\PaymentSuccessfulMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;

class PaymentsController extends Controller
{
    public function index()
    {
        return view('front.payments.index');
    }

    public function setAmount(Request $request)
    {
        $request->validate([
            'amount' => 'numeric|between:1,9999',
        ]);

        session()->flash('amount', $request->amount * 100);

        return redirect()->action('PaymentsController@index');
    }

    public function handlePayment(Request $request)
    {
        try {
            $this->performPayment($request);
        } catch (Exception $exception) {
            flash()->error('There was a problem processing your payment.');

            Mail::to('freek@spatie.be')->queue(new PaymentFailed(
                $request->stripeEmail,
                $request->amount,
                $exception->getMessage()
            ));

            return redirect()->action('PaymentsController@index');
        }

        Mail::to('freek@spatie.be')->queue(new PaymentSuccessfulMail(
            $request->stripeEmail,
            $request->amount
        ));

        flash()->success('Your payment was successful! Thank you!');

        return redirect()->action('PaymentsController@index');
    }

    protected function performPayment(Request $request)
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
    }
}
