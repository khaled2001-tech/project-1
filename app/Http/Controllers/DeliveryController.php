<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class DeliveryController extends Controller
{
    // ═══════════════════════════════════════════════════════════════
    //  EMPLOYEE SIDE
    // ═══════════════════════════════════════════════════════════════

    // ─────────────────────────────────────────────────────────────
    // Employee: قائمة كل الـ Deliveries
    // ─────────────────────────────────────────────────────────────
    public function index()
    {
        $deliveries = Delivery::with([
            'reservation.car.brand',
            'reservation.customer',
            'driver',
            'assignedBy',
        ])->latest()->paginate(15);

        return view('dashboard.deliveries.index', compact('deliveries'));
    }

    // ─────────────────────────────────────────────────────────────
    // Employee: تفاصيل Delivery واحد
    // ─────────────────────────────────────────────────────────────
    public function show(Delivery $delivery)
    {
        $delivery->load([
            'reservation.car.brand',
            'reservation.customer',
            'driver',
            'assignedBy',
        ]);

        return view('dashboard.deliveries.show', compact('delivery'));
    }

    // ─────────────────────────────────────────────────────────────
    // Employee: إعادة تعيين سائق بعد الرفض
    // ─────────────────────────────────────────────────────────────
    public function reassign(Request $request, Delivery $delivery): RedirectResponse
    {
        abort_unless(
            $delivery->status === 'rejected',
            403,
            'Can only reassign rejected deliveries.'
        );

        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
        ]);

        $delivery->update([
            'driver_id'    => $validated['driver_id'],
            'status'       => 'pending',
            'driver_notes' => null,
            'accepted_at'  => null,
        ]);

        // إعادة delivery_status في الحجز إلى pending
        $delivery->reservation?->update(['delivery_status' => 'pending']);

        return redirect()->route('deliveries.show', $delivery)
            ->with('success', 'Delivery reassigned to new driver.');
    }

    // ═══════════════════════════════════════════════════════════════
    //  DRIVER SIDE
    // ═══════════════════════════════════════════════════════════════

    // ─────────────────────────────────────────────────────────────
    // Driver: لوحة التحكم الخاصة بالسائق
    // ─────────────────────────────────────────────────────────────
    public function driverDashboard()
    {
        $driver = auth()->user()->driver;

        abort_unless($driver, 403, 'No driver record linked to this account.');

        $deliveries = Delivery::with(['reservation.car.brand', 'reservation.customer'])
            ->where('driver_id', $driver->id)
            ->latest()
            ->get();

        $pendingCount    = $deliveries->where('status', 'pending')->count();
        $acceptedCount   = $deliveries->where('status', 'accepted')->count();
        $inProgressCount = $deliveries->where('status', 'in_progress')->count();
        $deliveredCount  = $deliveries->where('status', 'delivered')->count();

        return view('dashboard.drivers.dashboard', compact(
            'deliveries',
            'pendingCount',
            'acceptedCount',
            'inProgressCount',
            'deliveredCount'
        ));
    }

    // ─────────────────────────────────────────────────────────────
    // Driver: قبول طلب التوصيل
    // ─────────────────────────────────────────────────────────────
    public function accept(Delivery $delivery): RedirectResponse
    {
        $this->authorizeDriver($delivery);

        abort_unless(
            $delivery->status === 'pending',
            403,
            'Only pending deliveries can be accepted.'
        );

        $delivery->update([
            'status'      => 'accepted',
            'accepted_at' => now(),
        ]);

        return redirect()->route('driver.dashboard')
            ->with('success', 'Delivery accepted! You can start delivery when ready.');
    }

    // ─────────────────────────────────────────────────────────────
    // Driver: رفض طلب التوصيل
    // ─────────────────────────────────────────────────────────────
    public function reject(Request $request, Delivery $delivery): RedirectResponse
    {
        $this->authorizeDriver($delivery);

        abort_unless(
            $delivery->status === 'pending',
            403,
            'Only pending deliveries can be rejected.'
        );

        $request->validate([
            'driver_notes' => 'nullable|string|max:500',
        ]);

        $delivery->update([
            'status'       => 'rejected',
            'driver_notes' => $request->driver_notes,
        ]);

        // تحديث delivery_status في الحجز
        $delivery->reservation?->update(['delivery_status' => 'rejected']);

        return redirect()->route('driver.dashboard')
            ->with('success', 'Delivery rejected. The employee will be notified.');
    }

    // ─────────────────────────────────────────────────────────────
    // Driver: بدء التوصيل
    // ─────────────────────────────────────────────────────────────
    public function startDelivery(Delivery $delivery): RedirectResponse
    {
        $this->authorizeDriver($delivery);

        abort_unless(
            $delivery->status === 'accepted',
            403,
            'Only accepted deliveries can be started.'
        );

        $delivery->update(['status' => 'in_progress']);

        // تحديث delivery_status في الحجز
        $delivery->reservation?->update(['delivery_status' => 'in_progress']);

        return redirect()->route('driver.dashboard')
            ->with('success', 'Delivery started!');
    }

    // ─────────────────────────────────────────────────────────────
    // Driver: إنهاء التوصيل وإكمال الحجز
    // ─────────────────────────────────────────────────────────────
    public function markDelivered(Request $request, Delivery $delivery): RedirectResponse
    {
        $this->authorizeDriver($delivery);

        abort_unless(
            in_array($delivery->status, ['accepted', 'in_progress']),
            403,
            'Cannot mark this delivery as delivered.'
        );

        $request->validate([
            'driver_notes' => 'nullable|string|max:1000',
        ]);

        $delivery->update([
            'status'       => 'delivered',
            'delivered_at' => now(),
            'driver_notes' => $request->driver_notes,
        ]);

        // تحديث الحجز كاملاً
        $delivery->reservation?->update([
            'status'          => 'completed',
            'delivery_status' => 'delivered',
        ]);

        return redirect()->route('driver.dashboard')
            ->with('success', 'Reservation marked as completed.');
    }

    // ─────────────────────────────────────────────────────────────
    // Private: التحقق إن السائق الحالي هو صاحب هذا الـ Delivery
    // ─────────────────────────────────────────────────────────────
    private function authorizeDriver(Delivery $delivery): void
    {
        $driver = auth()->user()->driver;

        abort_unless(
            $driver && $delivery->driver_id === $driver->id,
            403,
            'Unauthorized.'
        );
    }
}
