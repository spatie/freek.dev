<form
    action="https://sendy.murze.be/subscribe"
    method="post"
    accept-charset="utf-8"
    class="p-8 bg-indigo-100 text-sm text-gray-700 {{ $class ?? '' }}"
>
    <p class="font-black text-2xl leading-tight mb-4 text-black">
        Stay up to date with all things Laravel, PHP, and JavaScript.
    </p>
    <p class="mb-2">
        Every two weeks I send out a newsletter containing lots of interesting stuff for the modern PHP developer.
    </p>
    <p class="mb-3">
        Expect quick tips & tricks, interesting tutorials, opinions and packages. Because I work with Laravel every day there is an emphasis on that framework.
    </p>
    <div class="flex items-stretch mb-3">
        <input type="email" id="email" name="email" placeholder="Your e-mail address" class="p-2 pr-0 flex-1 focus:outline-none focus:border-indigo-900 bg-white border border-indigo-200 mr-2" required>
        <input type="submit" name="submit" id="submit" value="Subscribe" class="px-3 text-sm text-white bg-indigo-300 font-semibold">
    </div>
    <p>
        Rest assured that I will only use your email address to send you the newsletter and will not use it for any other purposes.
    </p>
    <input type="hidden" name="list" value="SGDpioFb8i8923zG5xWPFw5A">
</form>
