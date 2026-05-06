<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Setteing;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['showBooking', 'storeBooking']);
    }

    public function showBooking(Car $car)
    {
        $setting = Setteing::first();
        $car->load(['brand', 'model']);

        return view('welcome.booking.booking-car', compact('car', 'setting'));
    }

    public function storeBooking(StoreBookingRequest $request, Car $car)
    {
        if (! $car->status) {
            return redirect()->back()->with('error', 'This car is not available for booking.');
        }

        $validated = $request->validated();

        // Find or create customer linked to the logged-in user
        $customer = Customer::firstOrCreate(
            ['customer_id' => auth()->id()],
            [
                'name'     => auth()->user()->name,
                'email'    => auth()->user()->email,
                'phone'    => auth()->user()->phone ?? 'N/A',
                'password' => Hash::make(Str::random(16)),
                'status'   => true,
            ]
        );

        $pickupDateTime = Carbon::parse($validated['pickup_date'] . ' ' . $validated['pickup_time']);
        $bodyType       = strtoupper((string) $car->body_type);

        if ($bodyType === 'BUY') {
            $returnDateTime = $pickupDateTime->copy();
            $rentalDays     = 1;
            $totalPrice     = $car->price;
        } else {
            $returnDateTime = Carbon::parse($validated['return_date'] . ' ' . $validated['return_time']);
            $rentalDays     = max(1, $pickupDateTime->diffInDays($returnDateTime));
            $totalPrice     = $car->price * $rentalDays;
        }

        $deliveryRequired = $request->boolean('delivery_required');

        $reservation = Reservation::create([
            'pickup_date'      => $pickupDateTime,
            'return_date'      => $returnDateTime,
            'rental_days'      => $rentalDays,
            'total_price'      => $totalPrice,
            'pickup_location'  => $validated['pickup_location'] ?? null,
            'notes'            => $validated['notes'] ?? null,
            'status'           => 'pending',
            'brand_id'         => $car->brand_id,
            'model_id'         => $car->model_id,
            'car_id'           => $car->id,
            'customer_id'      => $customer->id,
            'delivery_required'=> $deliveryRequired,
            'delivery_address' => $deliveryRequired ? ($validated['delivery_address'] ?? null) : null,
            'delivery_status'  => $deliveryRequired ? 'pending' : null,
        ]);

        $car->update(['status' => false]);

        return redirect()->route('welcome.booking.success', $reservation->id);
    }

    public function bookingSuccess($id)
    {
        $reservation = Reservation::with(['car.brand', 'car.model', 'customer'])->findOrFail($id);
        $setting     = Setteing::first();

        return view('welcome.booking.booking-success', compact('reservation', 'setting'));
    }
}
