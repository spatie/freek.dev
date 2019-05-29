<form
    action="https://sendy.freek.dev/subscribe"
    method="post"
    accept-charset="utf-8"
    class="p-8 bg-purple-100 text-sm text-gray-700 {{ $class ?? '' }}"
>
    <p class="font-extrabold text-2xl leading-tight mb-4 text-black">
        Stay up to date with all things Laravel, PHP, and JavaScript.
    </p>
    <p class="mb-2">
        Every two weeks I send out a newsletter containing lots of interesting stuff for the modern PHP developer.
    </p>
    <p class="mb-3">
        Expect quick tips & tricks, interesting tutorials, opinions and packages. Because I work with Laravel every day there is an emphasis on that framework.
    </p>
    <div class="flex items-stretch mb-3">
        <input type="email" id="email" name="email" placeholder="Your e-mail address" class="flex-1 px-3 py-2 bg-white focus:outline-none focus:border-gray-400 border-y-2 border-t-transparent" required>
        <input type="submit" name="submit" id="submit" value="Subscribe" class="px-3 text-sm text-white bg-purple-600 font-semibold border-y-2 border-purple-700 border-t-transparent">
    </div>
    <p>
        Rest assured that I will only use your email address to send you the newsletter and will not use it for any other purposes.
    </p>
    <input type="hidden" name="list" value="SGDpioFb8i8923zG5xWPFw5A">
</form>
