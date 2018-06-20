@extends('front.layouts.master')

@section('title', 'Payments')

@section('content')


    @if (! session()->has('amount'))
    <form action="/payments/set-amount" method="POST">
        @csrf
        <input name="amount" type="number">
        <input type="submit">
    </form>
    @endif

    @if (session()->has('amount'))

        <a href="/payments">Change amount</a>

        <form action="/payments" method="POST">
            <input type="hidden" name="amount" value="{{ session()->get('amount') }}">
            @csrf
            <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="{{ config('services.stripe.key') }}"
                    data-amount="{{ session()->get('amount') }}"
                    data-name="murze.be ads"
                    data-locale="auto"
                    data-label="Pay {{ session()->get('amount') / 100 }} EUR to murze.be"
                    data-zip-code="true"
                    data-currency="eur">
            </script>
        </form>
    @endif

@endsection