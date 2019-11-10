<form
    action="{{ action(\App\Http\Controllers\NewsletterSubscription\SubscribeToNewsletterController::class) }}"
    method="post"
    accept-charset="utf-8"
    class="flex flex-col md:flex-row items-stretch {{ $class ?? '' }}"
>
    @csrf
    <input type="email" id="email" name="email" placeholder="Your e-mail address" class="flex-1 px-3 py-2 bg-white focus:outline-none focus:border-gray-400 border-y-3 border-t-transparent mb-2 md:mb-0" aria-label="E-mail" required>
    <input type="submit" name="submit" id="submit" value="Subscribe" class="px-3 py-2 text-sm text-white bg-orange-500 font-semibold border-y-3 border-orange-700 border-t-transparent">
</form>
