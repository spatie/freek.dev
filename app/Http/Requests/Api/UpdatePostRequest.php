<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'text' => ['sometimes', 'required', 'string'],
            'publish_date' => ['sometimes', 'nullable', 'date'],
            'published' => ['sometimes', 'boolean'],
            'original_content' => ['sometimes', 'boolean'],
            'external_url' => ['sometimes', 'nullable', 'url', 'max:255'],
            'tags' => ['sometimes', 'array'],
            'tags.*' => ['string', 'max:255'],
            'send_automated_tweet' => ['sometimes', 'boolean'],
            'author_twitter_handle' => ['sometimes', 'nullable', 'string', 'max:255'],
            'series_slug' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }
}
