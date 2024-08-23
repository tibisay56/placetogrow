<?php

namespace App\Http\Requests\Subscription;

use App\Constants\BillingFrecuency;
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

            'name' => 'required|max:100',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required',
            'description' => 'nullable|string',
            'subscription_expiration' => 'required|integer|min:1|max:1440',
            'site_id' => 'required|exists:sites,id',
            'billing_frequency' => 'required|in:'.implode(',', BillingFrecuency::toArray()),
        ];
    }
}
