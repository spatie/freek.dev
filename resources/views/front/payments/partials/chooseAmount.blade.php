<p>
    Payments can be made with credit cards and are handled securely with Stripe. Which amount in EUR would you like to pay?
</p>
<form action="/payments/set-amount" method="POST">
    @csrf
    <div class="p-4 bg-green-100 border border-green-200 text-sm text-gray-700">
        <div class="flex items-stretch">
            <input class="flex-1 px-3 py-2 bg-white focus:outline-none focus:border-gray-400 border-y-2 border-t-transparent" required name="amount" type="number" placeholder="Amount in EUR">
            <input type="submit" name="submit" id="submit" value="Proceed" class="px-3 text-sm text-white bg-green-500 font-semibold border-y-2 border-green-700 border-t-transparent">
        </div>
    </div>
</form>
