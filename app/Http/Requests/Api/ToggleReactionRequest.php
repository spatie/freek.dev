<?php

namespace App\Http\Requests\Api;

use App\Enums\Emoji;
use App\Models\Commenter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ToggleReactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        return [
            'emoji' => ['required', 'string', new Enum(Emoji::class)],
        ];
    }

    public function commenter(): Commenter
    {
        return $this->attributes->get('commenter');
    }
}
