@extends('front.layouts.app', [
    'title' => 'Links',
])


@section('content')
    {{ $links->links() }}

    <ul>
    @foreach($links as $link)
        <li><a href="{{ $link->url }}}">{{ $link->title }}</a></li>
    @endforeach
    </ul>

    {{ $links->links() }}
@endsection
