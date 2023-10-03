<div class="markup mb-8">
    <h2 id="comments">
        Comments
        <a href="#comments" class="permalink">#</a>
    </h2>
</div>

@php
    $noCommentsText = 'What are your thoughts on "' . $post->title . '"?'
@endphp

@guest
    <livewire:comments read-only :no-comments-text="$noCommentsText" :model="$post"/>

    <div class="text-xs mt-4 text-gray-400">
        Comments powered by <a class="underline" href="https://laravel-comments.com">Laravel Comments</a>
    </div>

    <div class="mt-4 -mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-gray-100 border-b-5 border-gray-200 text-sm text-gray-700">
        Want to join the conversation? <a class="underline" href="{{ route('login') }}">Log in</a> or <a
            class="underline" href="{{ route('register') }}">create an account</a> to post a comment.
    </div>
@endguest

@auth
    @if (auth()->user()->hasVerifiedEmail())
        <livewire:comments :no-comments-text="$noCommentsText" :model="$post"/>

        <div class="text-xs mt-4 text-gray-400">
            Comments powered by <a class="underline" href="https://laravel-comments.com">Laravel Comments</a>
        </div>
    @else
        <livewire:comments read-only :no-comments-text="$noCommentsText" :model="$post"/>

        <div class="text-xs mt-4 text-gray-400">
            Comments powered by <a class="underline" href="https://laravel-comments.com">Laravel Comments</a>
        </div>

        <div class="mt-4 -mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-gray-100 border-b-5 border-gray-200 text-sm text-gray-700">
            Want to join the conversation? <a class="underline" href="{{ route('verification.notice') }}">Verify your
                email address</a> to post a comment.
        </div>
    @endif
@endauth
