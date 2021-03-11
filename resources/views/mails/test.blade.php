@component('mail::message')
# Test mail

Your order has been shipped!

@component('mail::button', ['url' => 'https://spatie.be'])
    View Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
