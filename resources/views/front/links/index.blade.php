@extends('front.layouts.app', [
    'title' => 'Links',
])


@section('content')
    <a href="{{ route('login') }}" class="button">Log in</a>

    {{ $links->links() }}

    <ul>
    @foreach($links as $link)
        <li><a href="{{ $link->url }}}">{{ $link->title }}</a></li>
    @endforeach
    </ul>

    {{ $links->links() }}
@endsection
