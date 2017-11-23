@extends('back.layouts.master')

@section('content')

    <div class="bg-white rounded border-2 max-w-xl mx-auto flex-1 my-8 pb-4">
        <div class="bg-grey-lighter mb-2 px-8 py-2 text-grey-darker font-bold">
            <h1 class="p-0 text-grey-darker">Newsletter</h1>
        </div>

        <form class="mx-8" action="{{ action('Back\NewsletterGeneratorController@generate') }}" method="POST">
            {{ csrf_field() }}
            
            <div class="text-sm mt-4">
                Fill out the form and click the "Generate" button to generate the newsletter HTML.
            </div>

            <div class="form-line">
                <label class="form-label" for="edition_number">Edition number:</label>
                <input class="form-text-input" name="edition_number" value="{{ old('edition_number') }}">
                @if($errors->has('edition_number'))
                    <div class="validation-error">{{ $errors->first('edition_number') }}</div>
                @endif
            </div>

            <div class="form-line">
                <label class="form-label" for="end_date">End date (Y-m-d):</label>
                <input class="form-text-input" name="end_date" value="{{ old('end_date') }}">
                @if($errors->has('end_date'))
                    <div class="validation-error">{{ $errors->first('end_date') }}</div>
                @endif
            </div>

            <div class="form-line">
                <button type="submit" class="btn btn-blue">Generate</button>
            </div>
        </form>


        @if ($newsletterHtml)
            <div class="mt-4 mx-8 border-grey-light border-b"></div>

            <div class="mx-8">
                <h2 class="text-grey-darker py-4">Generated HTML</h2>
                <textarea rows="10" class="form-text-input">
                    {{ $newsletterHtml }}
                </textarea>
            </div>
        @endif
        
    </div>

@endsection