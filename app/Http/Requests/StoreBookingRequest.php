<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $bodyType = strtoupper((string) $this->route('car')->body_type);

        return [
            'customer_name'    => ['required', 'string', 'max:255'],
            'customer_email'   => ['required', 'email', 'max:255'],
            'customer_phone'   => ['required', 'string', 'max:20'],
            'pickup_date'      => ['required', 'date', 'after:today'],
            'pickup_time'      => ['required'],
            'return_date'      => $bodyType === 'BUY' ? ['nullable'] : ['required', 'date', 'after:pickup_date'],
            'return_time'      => $bodyType === 'BUY' ? ['nullable'] : ['required'],
            'pickup_location'  => ['nullable', 'string', 'max:500'],
            'notes'            => ['nullable', 'string', 'max:1000'],
            'delivery_required'=> ['nullable', 'boolean'],
            'delivery_address' => ['nullable', 'required_if:delivery_required,1', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'delivery_address.required_if' => 'Please enter a delivery address.',
        ];
    }
}
