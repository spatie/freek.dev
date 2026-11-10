<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TweetUrl implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! preg_match('~^https://(?:www\.)?(?:x|twitter)\.com/[a-zA-Z0-9_]{1,15}/status/[0-9]+(?:[/?#][^\s]*)?$~D', $value)) {
            $fail('Use a tweet URL such as https://x.com/username/status/123.');
        }
    }
}
