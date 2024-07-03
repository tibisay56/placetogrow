<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'name' => 'required|max:100',
            'avatar' => 'nullable|mimes:png,jpg,jpeg|max:2040',
            'category' => 'required|max:100',
            'currency' => 'required',
            'payment_expiration_time' => 'required|integer|min:1|max:1440',
            'type_id' => 'required|exists:types,id',
        ];
    }
}
