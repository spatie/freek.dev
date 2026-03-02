<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
            'publish_date' => ['nullable', 'date'],
            'published' => ['boolean'],
            'original_content' => ['boolean'],
            'external_url' => ['nullable', 'url', 'max:255'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:255'],
            'send_automated_tweet' => ['boolean'],
            'author_twitter_handle' => ['nullable', 'string', 'max:255'],
            'series_slug' => ['nullable', 'string', 'max:255'],
        ];
    }
}
