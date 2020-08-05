<x-app-layout title="Payments">
    <div class="markup">
        <h1>Make a payment to freek.dev</h1>
        <div>Payments have been disabled for now</div>
    {{--
        @if (! session()->has('amount'))
            @include('front.payments.partials.chooseAmount')
        @else
            @include('front.payments.partials.stripePayment')
        @endif
    --}}
    </div>
</x-app-layout>
