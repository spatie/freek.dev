@extends('front.layouts.app', [
    'title' => 'Submit a link',
])

@section('content')
    <div class="markup mb-8">
        <h1>Submit a link</h1>

        <div
            class="-mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-gray-100 border-b-5 border-grey-200 text-sm text-gray-700 markup">
            After you submitted a link, I need a little time to check it out. If I think it's something my
            audience is interested in, I'll publish it and you'll get notified via mail.
        </div>

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
                @include('front.components.button', ['label' => 'Submit link'])


            </div>
        </form>
    </div>
@endsection
