<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class FilterSitesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'type' => 'nullable|exists:types,id',
            'search' => 'nullable|string|max:255',
        ];
    }
}
