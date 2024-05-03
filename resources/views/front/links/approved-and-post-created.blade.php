<x-app-layout title="Link approved">
    <div class="markup">
        <h1>Link approved!</h1>
        <p>The link has been approved and a post has been created. It will be published on {{ $publishDate->format('l j F Y \a\t H:i')  }}</p>
    </div>
</x-app-layout>
