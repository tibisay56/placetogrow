<?php

namespace App\Http\Requests\Plan;

use App\Constants\BillingFrequency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
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
            'amount' => 'required|numeric|min:0',
            'currency' => 'required',
            'description' => 'required|string',
            'site_id' => 'required|exists:sites,id',
            'billing_frequency' => 'required|in:'.implode(',', BillingFrequency::toArray()),
        ];
    }
}
