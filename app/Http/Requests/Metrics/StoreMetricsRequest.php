<?php

namespace App\Http\Requests\Metrics;

use Illuminate\Foundation\Http\FormRequest;

class StoreMetricsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'metrics' => 'required|json',
            'site_id' => 'required|exists:sites,id',
        ];
    }
}
