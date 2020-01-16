@extends('front.layouts.app', [
    'title' => 'Submit a link',
])


@section('content')

    <form method="POST">
        @csrf
        <div>
            <label for="title">Title</label>
            <input name="title" type="text" required value="{{ old('title') }}">
            @error('title')
            <span role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div>
            <label for="url">Url</label>
            <input name="url" type="url" required value="{{ old('url') }}">
            @error('url')
            <span role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div>
            <label for="text">Description</label>
            <textarea name="text" type="text" required>
                {{ old('text') }}
            </textarea>
            @error('text')
            <span role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit">Submit</button>
    </form>
@endsection
