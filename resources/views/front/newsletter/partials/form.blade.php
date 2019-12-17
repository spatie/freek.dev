<form
    action="{{ action([\App\Http\Controllers\NewsletterSubscriptionController::class, 'subscribe']) }}"
    method="post"
    accept-charset="utf-8"
    class="flex flex-col md:flex-row items-stretch {{ $class ?? '' }}"
>
    @csrf
    @honeypot
    <input type="email" id="email" name="email" placeholder="Your e-mail address" class="flex-1 px-3 py-2 bg-white focus:outline-none focus:border-gray-400 border-y-3 border-t-transparent mb-2 md:mb-0" aria-label="E-mail" required>

    <input type="submit" name="submit" id="submit" value="Subscribe" class="px-3 py-2 text-sm text-white bg-orange-500 font-semibold border-y-3 border-orange-700 border-t-transparent">

</form>

@error('email')
<div class="mt-2 py-2 px-2 flex-1 bg-red-500 focus:outline-none md:mb-0 text-white text-2xs">{{ $message }}</div>
@enderror
