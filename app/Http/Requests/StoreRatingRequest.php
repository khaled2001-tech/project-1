<?php

namespace App\Http\Requests;

use App\Models\Car;
use App\Services\CustomerVehicleEligibility;
use Illuminate\Foundation\Http\FormRequest;

class StoreRatingRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (! auth()->check() || auth()->user()->role !== 'customer') {
            return false;
        }

        /** @var Car $vehicle */
        $vehicle = $this->route('vehicle');

        return CustomerVehicleEligibility::hasCompletedLikeReservation(auth()->user(), $vehicle->id);
    }

    public function rules(): array
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:2000',
        ];
    }
}
