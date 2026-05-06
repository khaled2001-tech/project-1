<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeliveryStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = auth()->user();

        return $user && in_array($user->role, ['admin', 'manager', 'employee'], true);
    }

    public function rules(): array
    {
        return [
            'delivery_status' => 'required|in:pending,in_progress,delivered',
        ];
    }
}
