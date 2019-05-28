<div>
    Press this button to pay via Stripe.
</div>

<form action="/payments" method="POST" class="pt-2 pb-2">
    <input type="hidden" name="amount" value="{{ session()->get('amount') }}">
    @csrf
    <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="{{ config('services.stripe.key') }}"
            data-amount="{{ session()->get('amount') }}"
            data-name="freek.dev ads"
            data-locale="auto"
            data-label="Pay {{ session()->get('amount') / 100 }} EUR to freek.dev"
            data-zip-code="true"
            data-currency="eur">
    </script>
</form>

<a href="/payments" class="pt-8 text-sm">change amount</a>