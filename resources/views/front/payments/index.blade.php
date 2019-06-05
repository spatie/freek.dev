@extends('front.layouts.app', [
    'title' => 'Payments',
])

@section('content')
    <div class="markup">
        <h1>Make a payment to freek.dev</h1>
        @if (! session()->has('amount'))
            @include('front.payments.partials.chooseAmount')
        @else
            @include('front.payments.partials.stripePayment')
        @endif
    </div>
@endsection
