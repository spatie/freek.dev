<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLinkRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required|url',
            'url' => 'required|unique:links'
        ];
    }
}
