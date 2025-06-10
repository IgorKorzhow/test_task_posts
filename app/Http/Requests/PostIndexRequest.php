<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostIndexRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sort_field' => [
                'sometimes',
                Rule::in(['id', 'header', 'content', 'hotness', 'created_at']),
            ],
            'sort_order' => [
                'sometimes',
                Rule::in(['asc', 'desc']),
            ],
        ];
    }
}
