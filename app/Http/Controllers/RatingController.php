<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRatingRequest;
use App\Models\Car;
use App\Models\Rating;

class RatingController extends Controller
{
    public function store(StoreRatingRequest $request, Car $vehicle)
    {
        $data = $request->validated();

        Rating::query()->updateOrCreate(
            [
                'user_id' => auth()->id(),
                'vehicle_id' => $vehicle->id,
            ],
            [
                'rating' => $data['rating'],
                'review' => $data['review'] ?? null,
            ]
        );

        return redirect()
            ->route('front.vehicle.show', $vehicle)
            ->with('success', 'Thank you for rating this vehicle.');
    }
}
