<?php

namespace App\Http\Requests\Form;

use App\Constants\CurrencyType;
use App\Constants\DocumentTypes;
use App\Constants\PaymentGateway;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'site_id' => 'required|exists:sites,id',
            'fields' => 'required|array',
            'fields.*.label' => 'required|string|max:255',
            'fields.*.input_type' => 'required|string|max:255',
        ];
    }
}
