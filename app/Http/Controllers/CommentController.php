<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleCommentRequest;
use App\Models\Car;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(StoreVehicleCommentRequest $request, Car $vehicle)
    {
        Comment::query()->create([
            'user_id' => auth()->id(),
            'vehicle_id' => $vehicle->id,
            'comment' => $request->validated('comment'),
        ]);

        return redirect()
            ->route('front.vehicle.show', $vehicle)
            ->with('success', 'Your comment was posted.');
    }
}
