<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'site_id' => 'required|exists:sites,id',
            'roles_id' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ];
    }
}
