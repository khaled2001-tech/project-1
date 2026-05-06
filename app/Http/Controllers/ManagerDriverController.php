<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ManagerDriverController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));
        $status = trim((string) $request->input('status', ''));

        $drivers = User::query()
            ->where('role', 'driver')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('license_number', 'like', "%{$search}%");
                });
            })
            ->when(in_array($status, ['active', 'inactive'], true), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(15);

        return view('manager.drivers.index', compact('drivers', 'search', 'status'));
    }

    public function create(): View
    {
        return view('manager.drivers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'license_number' => 'required|string|max:100|unique:users,license_number',
            'password' => 'required|string|min:6',
            'status' => 'required|in:active,inactive',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
            'license_number' => $validated['license_number'],
            'password' => Hash::make($validated['password']),
            'role' => 'driver',
            'status' => $validated['status'],
        ]);

        return redirect()->route('manager.drivers.index')
            ->with('success', 'Driver created successfully.');
    }

    public function show(int $id): View
    {
        $driver = User::where('role', 'driver')->findOrFail($id);
        $activeDeliveriesCount = $driver->deliveries()->whereIn('status', ['pending', 'accepted'])->count();
        $completedDeliveriesCount = $driver->deliveries()->where('status', 'delivered')->count();

        return view('manager.drivers.show', compact('driver', 'activeDeliveriesCount', 'completedDeliveriesCount'));
    }

    public function edit(int $id): View
    {
        $driver = User::where('role', 'driver')->findOrFail($id);

        return view('manager.drivers.edit', compact('driver'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $driver = User::where('role', 'driver')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $driver->id,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'license_number' => 'required|string|max:100|unique:users,license_number,' . $driver->id,
            'status' => 'required|in:active,inactive',
        ]);

        $driver->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
            'license_number' => $validated['license_number'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('manager.drivers.index')
            ->with('success', 'Driver updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $driver = User::where('role', 'driver')->findOrFail($id);

        if ($driver->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $hasActiveDeliveries = $driver->deliveries()
            ->whereIn('status', ['pending', 'accepted'])
            ->exists();

        if ($hasActiveDeliveries) {
            return back()->with('error', 'Cannot delete driver with active deliveries.');
        }

        $driver->delete();

        return redirect()->route('manager.drivers.index')
            ->with('success', 'Driver deleted successfully.');
    }
}
