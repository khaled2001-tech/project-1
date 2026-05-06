<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDeliveryStatusRequest;
use App\Models\Reservation;

class DeliveryRequestController extends Controller
{
    public function index()
    {
        $reservations = Reservation::query()
            ->where('delivery_required', true)
            ->with(['car.brand', 'car.model', 'customer'])
            ->latest()
            ->paginate(20);

        return view('back.deliveries.index', compact('reservations'));
    }

    public function updateStatus(UpdateDeliveryStatusRequest $request, Reservation $reservation)
    {
        if (! $reservation->delivery_required) {
            abort(404);
        }

        $reservation->update([
            'delivery_status' => $request->validated('delivery_status'),
        ]);

        return redirect()
            ->route('deliveries.index')
            ->with('success', 'Delivery status updated.');
    }
}
