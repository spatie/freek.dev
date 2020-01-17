@extends('front.layouts.app', [
    'title' => 'Submit a link',
])


@section('content')

    <div class="markup mb-8">
        <h1>Submit a link</h1>

        <form method="POST">
            @csrf
            <div class="mt-4">
                <label class="text-gray-700" for="title">
                    <span class="text-gray-700">Title</span>
                    <input class="form-input mt-1 block w-full" name="title" type="text" value="{{ old('title') }}">
                </label>
                @error('title')
                <div
                    class="mt-2 py-2 px-2 flex-1 bg-red-500 focus:outline-none md:mb-0 text-white text-2xs">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <label class="text-gray-700" for="url">
                    <span class="text-gray-700">URL</span>
                    <input class="form-input mt-1 block w-full" name="url" type="text" required
                           value="{{ old('title') }}"
                           placeholder="https://"
                    >
                </label>
                @error('url')
                <div
                    class="mt-2 py-2 px-2 flex-1 bg-red-500 focus:outline-none md:mb-0 text-white text-2xs">{{ $message }}</div>

                @enderror
            </div>

            <div class="mt-4">
                <label class="text-gray-700" for="text">
                    <span class="text-gray-700">Description</span>
                    <textarea
                        placeholder="Describe the content in one or two sentences"
                        class="form-textarea mt-1 block w-full" name="text" type="text"
                              required>{{ old('text') }}</textarea>
                </label>
                @error('text')
                <div
                    class="mt-2 py-2 px-2 flex-1 bg-red-500 focus:outline-none md:mb-0 text-white text-2xs">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <button
                    class="button button-orange"
                    type="submit">Submit
                </button>
            </div>
        </form>
    </div>
@endsection
