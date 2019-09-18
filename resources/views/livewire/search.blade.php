<input wire:model="query"
       type="text"
       class="bg-gray-100 px-3 pb-2 pt-3 w-full focus:outline-none border-gray-200 focus:border-gray-300 border-y-4 border-t-transparent"
>

@if (count($results))
    <ul>
        @foreach($results as $post)
            <li>
                <strong className="text-lg">
                    <a href={{ $post->url }}>{{ $post->title }}</a>
                </strong>
                <br/>
                <a href="{{ $post->url }}" className="text-sm text-gray-700">
                    {{ $post->formatted_type }}
                </a>
            </li>
        @endforeach
    </ul>
@else
    <p class="mt-2 text-gray-700">Nothing here…</p>
@endif
