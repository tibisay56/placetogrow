<?php

namespace App\Http\Requests\Plan;

use App\Constants\BillingFrequency;
use App\Constants\CurrencyType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'plan_type_id' => 'required|exists:plan_types,id',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'currency' => 'required|in:'.implode(',', CurrencyType::toArray()),
            'billing_frequency' => 'required|in:'.implode(',', BillingFrequency::toArray()),
            'subscription_expiration' => 'required|integer|min:1',
            'site_id' => 'required|exists:sites,id',
        ];
    }
}
