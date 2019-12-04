@extends('front.layouts.app', [
    'title' => 'Subscribed!',
])

@section('content')
    <div class="markup">
        <h1>Subscription failed...</h1>
        <p>
            We could not find your subscription to the email list. The link you clicked seems invalid.
        </p>
    </div>
@endsection
