@extends('front.layouts.app', [
    'title' => 'Talks',
])

@section('content')
    <div class="markup">
        <h1>Talks</h1>
    </div>
    @foreach($talks as $title => $talks)
        <article class="mt-6">
            <h2 class="max-w-lg text-lg font-bold leading-tight mb-1">
                {{ $title }}
            </h2>
            <ul class="leading-relaxed">
                @foreach ($talks as $talk)
                    <li class="text-sm text-gray-600">
                        <time datetime="{{ optional($talk->presented_at)->format(DateTime::ATOM) }}">
                            {{ $talk->presented_at->format('M jS Y') }}
                        </time>
                        at {{ $talk->location }}
                        @if($talk->video_link)
                            –
                            <a class="underline" href="{{ $talk->video_link }}">
                                Video</a>
                        @endif
                        @if($talk->slides_link)
                            –
                            <a class="underline" href="{{ $talk->slides_link }}">
                                Slides</a>
                        @endif
                        @if($talk->joindin_link)
                            –
                            <a class="underline" href="{{ $talk->joindin_link }}">
                                Joind.in</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </article>
    @endforeach
@endsection
