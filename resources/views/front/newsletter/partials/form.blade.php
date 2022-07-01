<form
    action="{{ route('newsletter.subscribe') }}"
    method="post"
    accept-charset="utf-8"
    class="flex flex-col md:flex-row items-stretch {{ $class ?? '' }}"
>
    @csrf
    <input class="mb-2 md:mb-0" type="email" autocomplete="off" id="email" name="email" placeholder="Your e-mail address" aria-label="E-mail" required>

    <input type="submit" name="submit" id="submit" value="Subscribe" class="px-3 py-2 text-sm text-white bg-yellow-500 font-semibold border-t-3 border-b-3 border-yellow-700 border-t-transparent">

</form>

@error('email')
<div class="mt-2 py-2 px-2 flex-1 bg-red-500 focus:outline-none md:mb-0 text-white text-2xs">{{ $message }}</div>
@enderror
