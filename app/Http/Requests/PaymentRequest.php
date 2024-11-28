<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|integer',
            'payment_period' => 'required|string',
            'method' => [
                'required',
                Rule::in(['wave', 'orange-money']),
            ],
        ];
    }
}
