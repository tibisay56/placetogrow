<?php

namespace App\Http\Requests\Invoice;

use App\Constants\CurrencyType;
use App\Constants\DocumentTypes;
use App\Constants\PaymentGateway;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => ['required', 'string', 'min:3', 'max:100'],
            'amount' => ['required', 'numeric', 'min:1', 'max:999999999999'],
            'currency' => ['required', Rule::in(CurrencyType::toArray())],
            'name' => ['required', 'string', 'min:3', 'max:20'],
            'last_name' => ['required', 'string', 'min:3', 'max:20'],
            'email' => ['required', 'string', 'email'],
            'document_number' => ['required', 'numeric', 'digits_between:6,20'],
            'document_type' => ['required', Rule::in(DocumentTypes::toArray())],
            'gateway' => ['required', Rule::in(PaymentGateway::toArray())],
            'site_id' => ['required', 'exists:sites,id'],
        ];
    }
}
