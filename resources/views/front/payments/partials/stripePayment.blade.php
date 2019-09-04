<p>Pay with Stripe:</p>

<form action="/payments" method="POST">
    <input type="hidden" name="amount" value="{{ session()->get('amount') }}">
    @csrf
    <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="{{ config('settings.stripe.key') }}"
        data-amount="{{ session()->get('amount') }}"
        data-name="freek.dev ads"
        data-locale="auto"
        data-label="Pay {{ session()->get('amount') / 100 }} EUR to freek.dev"
        data-zip-code="true"
        data-currency="eur">
    </script>
</form>

<a href="/payments" class="font-semibold text-gray-700 pb-1 border-b-2">
    Change amount
</a>
