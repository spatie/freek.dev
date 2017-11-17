@extends('back.layouts.master')

@section('content')

    <h1>Newsletter</h1>

    <form class="form" action="{{ action('Back\NewsletterGeneratorController@generate') }}" method="POST">
        {{ csrf_field() }}

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
            <button type="submit" class="btn btn-blue">Generate newsletter html</button>
        </div>
    </form>


    <h2>Newsletter html</h2>
    @if ($newsletterHtml)
        <textarea rows="10" class="form-text-input">
        {{ $newsletterHtml }}
    </textarea>
    @endif

@endsection