<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250|unique:roles,name,' . $this->role->id,
            'permissions' => 'array',
            'permissions.*' => 'integer|exists:permissions,id',
        ];
    }
}
