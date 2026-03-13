@php
    $linkBuffer = collect();
@endphp

@foreach($posts as $post)
    @if($loop->index === 2)
        <div class="mb-12 md:mb-24 md:-mt-4">
            @include('front.newsletter.partials.block')
        </div>
    @endif

    @if($post->isOriginal())
        {{-- Flush any buffered link posts before showing an original --}}
        @if($linkBuffer->isNotEmpty())
            @include('front.posts.partials.link-cluster', ['links' => $linkBuffer])
            @php $linkBuffer = collect(); @endphp
        @endif

        <x-post-header
            :post="$post"
            class="mb-12 md:mb-24"
            :url="$post->url"
            heading="h2"
            :showTags="true"
        >
            {!! $post->excerpt !!}

            <p class="mt-6">
                <a href="{{ $post->url }}">
                    Read more
                </a>
            </p>
        </x-post-header>
    @else
        @php $linkBuffer->push($post); @endphp
    @endif
@endforeach

{{-- Flush remaining buffered links --}}
@if($linkBuffer->isNotEmpty())
    @include('front.posts.partials.link-cluster', ['links' => $linkBuffer])
@endif
