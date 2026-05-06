<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Brand;
use App\Models\Models;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Driver;
use App\Models\Delivery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ReservationController extends Controller
{
    // ─────────────────────────────────────────────────────────────
    // Employee: قائمة الحجوزات
    // ─────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $reservations = Reservation::with(['car.brand', 'customer', 'delivery'])
            ->latest()
            ->get();

        return view('dashboard.reservations.index', compact('reservations'));
    }

    // ─────────────────────────────────────────────────────────────
    // Employee: تفاصيل حجز
    // ─────────────────────────────────────────────────────────────
    public function show(Reservation $reservation)
    {
        $reservation->load(['brand', 'model', 'car.brand', 'customer', 'employee', 'delivery.driver']);

        return view('dashboard.reservations.show', compact('reservation'));
    }

    // ─────────────────────────────────────────────────────────────
    // Customer/Employee: إنشاء حجز
    // ─────────────────────────────────────────────────────────────
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'pickup_date'       => 'required|date',
            'return_date'       => 'required|date|after:pickup_date',
            'pickup_location'   => 'nullable|string|max:500',
            'notes'             => 'nullable|string|max:1000',
            'status'            => 'required|in:pending,approved,rejected,completed,cancelled',
            'car_id'            => 'required|exists:cars,id',
            'customer_id'       => 'required|exists:customers,id',
            'delivery_required' => 'boolean',
            'delivery_address'  => 'nullable|string|max:500',
        ]);

        $car        = Car::findOrFail($validated['car_id']);
        $rentalDays = max(1, Carbon::parse($validated['pickup_date'])
            ->diffInDays(Carbon::parse($validated['return_date'])));

        $validated['rental_days']       = $rentalDays;
        $validated['total_price']       = $car->price * $rentalDays;
        $validated['delivery_required'] = $request->boolean('delivery_required');

        $reservation = Reservation::create($validated);

        return redirect()->route('welcome.booking.success', $reservation)
            ->with('success', 'Reservation created successfully!');
    }

    // ─────────────────────────────────────────────────────────────
    // Employee: فورم تعديل الحجز
    // ─────────────────────────────────────────────────────────────
    public function edit(Reservation $reservation)
    {
        $brands    = Brand::all();
        $models    = Models::all();
        $cars      = Car::all();
        $customers = Customer::all();
        $employees = Employee::all();

        return view('dashboard.reservations.edit',
            compact('reservation', 'brands', 'models', 'cars', 'customers', 'employees'));
    }

    // ─────────────────────────────────────────────────────────────
    // Employee: تحديث الحجز
    // ─────────────────────────────────────────────────────────────
    public function update(Request $request, Reservation $reservation): RedirectResponse
    {
        $validated = $request->validate([
            'pickup_date'     => 'required|date',
            'return_date'     => 'required|date|after:pickup_date',
            'pickup_location' => 'nullable|string|max:500',
            'notes'           => 'nullable|string|max:1000',
            'status'          => 'required|in:pending,approved,rejected,completed,cancelled',
            'car_id'          => 'required|exists:cars,id',
            'customer_id'     => 'required|exists:customers,id',
        ]);

        $car        = Car::findOrFail($validated['car_id']);
        $rentalDays = max(1, Carbon::parse($validated['pickup_date'])
            ->diffInDays(Carbon::parse($validated['return_date'])));

        $validated['rental_days'] = $rentalDays;
        $validated['total_price'] = $car->price * $rentalDays;

        $reservation->update($validated);

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation updated successfully!');
    }

    // ─────────────────────────────────────────────────────────────
    // Employee: حذف الحجز
    // ─────────────────────────────────────────────────────────────
    public function destroy(Reservation $reservation): RedirectResponse
    {
        $carName = $reservation->car->name ?? 'Unknown';
        $reservation->car?->update(['status' => true]);
        $reservation->delete();

        return redirect()->route('reservations.index')
            ->with('success', "Reservation deleted! Car '{$carName}' is now available.");
    }

    // ─────────────────────────────────────────────────────────────
    // Employee: فورم القبول (GET)
    // ─────────────────────────────────────────────────────────────
    public function approveForm(Reservation $reservation)
    {
        abort_unless(
            $reservation->status === 'pending',
            403,
            'Only pending reservations can be approved.'
        );

        // جلب السائقين المتاحين فقط
        $drivers = Driver::where('status', true)->get();

        return view('dashboard.reservations.approved', compact('reservation', 'drivers'));
    }

    // ─────────────────────────────────────────────────────────────
    // Employee: تنفيذ القبول (POST)
    // ─────────────────────────────────────────────────────────────
    public function approve(Request $request, Reservation $reservation): RedirectResponse
    {
        abort_unless(
            $reservation->status === 'pending',
            403,
            'Only pending reservations can be approved.'
        );

        // تحديد هل التوصيل مطلوب بناءً على اختيار driver_id
        $needsDelivery = $request->filled('driver_id');

        // Validation ديناميكي
        if ($needsDelivery) {
            $request->validate([
                'driver_id'        => 'required|exists:drivers,id',
                'delivery_address' => 'nullable|string|max:500',
            ]);
        }

        // جلب الموظف الحالي عبر علاقة user
        $employee = auth()->user()->employee
            ?? Employee::where('user_id', auth()->id())->first();

        abort_unless($employee, 403, 'No employee record linked to this account.');

        // إنشاء Delivery إذا كان مطلوبًا
        if ($needsDelivery) {
            Delivery::updateOrCreate(
                ['reservation_id' => $reservation->id],
                [
                    'driver_id'        => $request->driver_id,
                    'assigned_by'      => $employee->id,
                    'delivery_address' => $request->delivery_address
                        ?? $reservation->delivery_address
                        ?? $reservation->pickup_location
                        ?? '',
                    'status'           => 'pending',
                ]
            );

            $reservation->update(['delivery_status' => 'pending']);
        }

        // تحديث الحجز
        $reservation->update([
            'status'      => 'approved',
            'approved_id' => $employee->id,
        ]);

        // تحديث حالة السيارة إلى غير متاحة
        $reservation->car?->update(['status' => false]);

        return redirect()->route('reservations.index')
            ->with('success', $needsDelivery
                ? 'Reservation approved & delivery assigned successfully!'
                : 'Reservation approved successfully!');
    }

    // ─────────────────────────────────────────────────────────────
    // Employee: رفض الحجز
    // ─────────────────────────────────────────────────────────────
    public function reject(Reservation $reservation): RedirectResponse
    {
        $reservation->update(['status' => 'rejected']);
        $reservation->car?->update(['status' => true]);

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation rejected.');
    }
}
