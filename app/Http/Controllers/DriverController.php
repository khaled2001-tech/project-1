<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Delivery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{
    // ─────────────────────────────────────────────────────────────────
    // Admin: Driver List
    // ─────────────────────────────────────────────────────────────────
    public function index()
    {
        $drivers = Driver::get();

        return view('dashboard.drivers.index', compact('drivers'));
    }

    // ─────────────────────────────────────────────────────────────────
    // Admin: Show single driver
    // ─────────────────────────────────────────────────────────────────
    public function show(int $id)
    {
        $driver = Driver::findOrFail($id);

        // $stats = [
        //     'total'     => Delivery::where('driver_id', $id)->count(),
        //     'pending'   => Delivery::where('driver_id', $id)->where('status', 'pending')->count(),
        //     'accepted'  => Delivery::where('driver_id', $id)->where('status', 'accepted')->count(),
        //     'delivered' => Delivery::where('driver_id', $id)->where('status', 'delivered')->count(),
        // ];

        return view('dashboard.drivers.show', compact('driver'));
    }

    // ─────────────────────────────────────────────────────────────────
    // Admin: Store new driver (Add via Modal)
    // ─────────────────────────────────────────────────────────────────
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'unique:users,email'],
            'password'  => ['required', 'string', 'min:8'],
            'birthdate' => ['nullable', 'date'],
            'gender'    => ['required', 'boolean'],
            'salary'    => ['nullable', 'numeric', 'min:0'],
            'status'    => ['required', 'boolean'],
            'photo'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        DB::transaction(function () use ($request, $validated) {
            // 1. Create the User account
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => 'driver',
            ]);

            // 2. Handle photo upload
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('drivers', 'public');
            }

            // 3. Create the Driver record
            Driver::create([
                'user_id'   => $user->id,
                'name'      => $validated['name'],
                'email'     => $validated['email'],
                'password'  => Hash::make($validated['password']),
                'birthdate' => $validated['birthdate'] ?? null,
                'gender'    => $validated['gender'],
                'salary'    => $validated['salary'] ?? 0,
                'status'    => $validated['status'],
                'photo'     => $photoPath,
            ]);
        });

        return redirect()->route('drivers.index')
            ->with('success', 'Driver created successfully.');
    }

    // ─────────────────────────────────────────────────────────────────
    // Admin: Edit page (صفحة منفصلة)
    // ─────────────────────────────────────────────────────────────────
    public function edit(int $id)
    {
        $driver = Driver::findOrFail($id);

        return view('dashboard.drivers.edit', compact('driver'));
    }

    // ─────────────────────────────────────────────────────────────────
    // Admin: Update existing driver
    // ─────────────────────────────────────────────────────────────────
    public function update(Request $request, int $id): RedirectResponse
    {
        $driver = Driver::findOrFail($id);

        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', Rule::unique('users', 'email')->ignore($driver->user_id)],
            'password'  => ['nullable', 'string', 'min:8'],
            'birthdate' => ['nullable', 'date'],
            'gender'    => ['required', 'boolean'],
            'salary'    => ['nullable', 'numeric', 'min:0'],
            'status'    => ['required', 'boolean'],
            'photo'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        DB::transaction(function () use ($request, $validated, $driver) {
            // Update linked User
            $userUpdate = [
                'name'  => $validated['name'],
                'email' => $validated['email'],
            ];
            if (!empty($validated['password'])) {
                $userUpdate['password'] = Hash::make($validated['password']);
            }
            if ($driver->user) {
                $driver->user->update($userUpdate);
            }

            // Prepare driver data
            $driverUpdate = [
                'name'      => $validated['name'],
                'email'     => $validated['email'],
                'birthdate' => $validated['birthdate'] ?? null,
                'gender'    => $validated['gender'],
                'salary'    => $validated['salary'] ?? 0,
                'status'    => $validated['status'],
            ];

            if (!empty($validated['password'])) {
                $driverUpdate['password'] = Hash::make($validated['password']);
            }

            // Handle photo upload
            if ($request->hasFile('photo')) {
                if ($driver->photo) {
                    Storage::disk('public')->delete($driver->photo);
                }
                $driverUpdate['photo'] = $request->file('photo')->store('drivers', 'public');
            }

            $driver->update($driverUpdate);
        });

        return redirect()->route('drivers.index')
            ->with('success', 'Driver updated successfully.');
    }

    // ─────────────────────────────────────────────────────────────────
    // Admin: Delete confirm page (صفحة منفصلة)
    // ─────────────────────────────────────────────────────────────────
    public function delete(int $id)
    {
        $driver = Driver::findOrFail($id);

        return view('dashboard.drivers.delete', compact('driver'));
    }

    // ─────────────────────────────────────────────────────────────────
    // Admin: Destroy driver
    // ─────────────────────────────────────────────────────────────────
    public function destroy(int $id): RedirectResponse
    {
        $driver = Driver::findOrFail($id);

        DB::transaction(function () use ($driver) {
            // Delete photo from storage
            if ($driver->photo) {
                Storage::disk('public')->delete($driver->photo);
            }

            // Delete linked User (cascade also deletes driver if FK set up)
            if ($driver->user) {
                $driver->user->delete();
            } else {
                $driver->delete();
            }
        });

        return redirect()->route('drivers.index')
            ->with('success', 'Driver deleted successfully.');
    }

    // ─────────────────────────────────────────────────────────────────
    // Driver Portal: Dashboard
    // ─────────────────────────────────────────────────────────────────
    public function dashboard()
    {
        $driverId = auth()->id();

        $stats = [
            'total'     => Delivery::where('driver_id', $driverId)->count(),
            'pending'   => Delivery::where('driver_id', $driverId)->where('status', 'pending')->count(),
            'accepted'  => Delivery::where('driver_id', $driverId)->where('status', 'accepted')->count(),
            'delivered' => Delivery::where('driver_id', $driverId)->where('status', 'delivered')->count(),
        ];

        return view('driver.dashboard', compact('stats'));
    }

    // ─────────────────────────────────────────────────────────────────
    // Driver Portal: My deliveries list
    // ─────────────────────────────────────────────────────────────────
    public function myDeliveries()
    {
        $deliveries = Delivery::with(['order.customer.user', 'order.car'])
            ->where('driver_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('driver.deliveries.index', compact('deliveries'));
    }

    // ─────────────────────────────────────────────────────────────────
    // Driver Portal: Accept delivery
    // ─────────────────────────────────────────────────────────────────
    public function accept(int $id): RedirectResponse
    {
        $delivery = Delivery::where('driver_id', auth()->id())->findOrFail($id);

        if ($delivery->status !== 'pending') {
            return back()->with('error', 'Only pending deliveries can be accepted.');
        }

        $delivery->update(['status' => 'accepted']);

        return back()->with('success', 'Delivery accepted successfully.');
    }

    // ─────────────────────────────────────────────────────────────────
    // Driver Portal: Reject delivery
    // ─────────────────────────────────────────────────────────────────
    public function reject(int $id): RedirectResponse
    {
        $delivery = Delivery::where('driver_id', auth()->id())->findOrFail($id);

        if ($delivery->status !== 'pending') {
            return back()->with('error', 'Only pending deliveries can be rejected.');
        }

        $delivery->update(['status' => 'rejected']);

        return back()->with('success', 'Delivery rejected successfully.');
    }

    // ─────────────────────────────────────────────────────────────────
    // Driver Portal: Mark as delivered
    // ─────────────────────────────────────────────────────────────────
    public function markDelivered(int $id): RedirectResponse
    {
        $delivery = Delivery::with('order')
            ->where('driver_id', auth()->id())
            ->findOrFail($id);

        if ($delivery->status !== 'accepted') {
            return back()->with('error', 'Only accepted deliveries can be marked as delivered.');
        }

        DB::transaction(function () use ($delivery) {
            $delivery->update([
                'status'        => 'delivered',
                'delivery_date' => now(),
            ]);

            if ($delivery->order) {
                $delivery->order->update(['status' => 'completed']);
            }
        });

        return back()->with('success', 'Delivery marked as delivered and order completed.');
    }
}
