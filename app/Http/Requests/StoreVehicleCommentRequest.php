<?php

namespace App\Http\Requests;

use App\Models\Car;
use App\Services\CustomerVehicleEligibility;
use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleCommentRequest extends FormRequest
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
            'comment' => 'required|string|min:2|max:2000',
        ];
    }
}
