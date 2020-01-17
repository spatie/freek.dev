@extends('front.layouts.app', [
    'title' => 'Submit a link',
])

@section('content')
    <div class="markup mb-8">
        <h1>Submit a link</h1>

        <form method="POST">
            @csrf
            @include('front.components.inputField', ['label' => 'Title', 'name' => 'title'])

            @include('front.components.inputField', [
                'label' => 'URL',
                'name' => 'url',
                'placeholder' => 'https://'
            ])

            @include('front.components.textArea', [
                'label' => 'Description',
                'name' => 'text',
                'placeholder' => 'Describe the content in one or two sentences. You can use markdown.',
             ])

            <div class="mt-4">
                @include('front.components.button', ['label' => 'Submit'])
            </div>
        </form>
    </div>
@endsection
