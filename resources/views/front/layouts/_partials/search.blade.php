<div
    id="search-posts"
    data-app-id="{{ config('scout.algolia.id') }}"
    data-api-key="{{ config('scout.algolia.public_key') }}"
    data-index-name="{{ config('scout.algolia.index') }}"
>
    <input placeholder="Search blogposts…" type="text" class="search-input">
</div>
