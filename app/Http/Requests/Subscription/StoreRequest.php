<?php

namespace App\Http\Requests\Subscription;

use App\Constants\DocumentTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'plan_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:100'],
            'document_number' => ['required', 'numeric', 'digits_between:6,20'],
            'document_type' => ['required', Rule::in(DocumentTypes::toArray())],
            'password' => 'required|string|min:8',
            'site_id' => ['required', 'exists:sites,id'],
        ];
    }
}
