@extends('front.layouts.app', [
    'title' => 'Links',
])


@section('content')
    @guest
        <a href="{{ route('login') }}" class="button">Log in</a>
    @endguest
    @auth
        <a href="{{ route('links.create') }}" class="button">Submit a link</a>
    @endauth

    {{ $links->links() }}

    <ul>
    @foreach($links as $link)
        <li><a href="{{ $link->url }}}">{{ $link->title }}</a></li>
    @endforeach
    </ul>

    {{ $links->links() }}
@endsection
