<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FavoriteToggleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'customer';
    }

    public function rules(): array
    {
        return [];
    }

    /**
     * Return JSON for AJAX favorite toggle (fetch expects application/json).
     */
    protected function failedAuthorization()
    {
        throw new HttpResponseException(
            response()->json(['message' => 'Only customers can use favorites.', 'favorited' => false], 403)
        );
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['message' => $validator->errors()->first(), 'errors' => $validator->errors()], 422)
        );
    }
}
