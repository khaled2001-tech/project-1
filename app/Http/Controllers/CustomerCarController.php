<?php

namespace App\Http\Controllers;

use App\Models\CarSaleRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerCarController extends Controller
{
    public function create()
    {
        $customer = Customer::where('user_id', auth()->id())->first();

        return view('customer.sell-car', compact('customer'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1990|max:2026',
            'price' => 'required|numeric|min:1',
            'mileage' => 'required|integer|min:0',
            'transmission' => 'required|in:manual,automatic',
            'fuel_type' => 'required|in:petrol,diesel,electric',
            'condition' => 'required|in:new,used',
            'description' => 'required|string|min:20|max:3000',
            'images' => 'required|array|min:1|max:8',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:4096',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $imagePaths = [];
        foreach ($request->file('images', []) as $image) {
            $imagePaths[] = $image->store('car-sale-requests', 'public');
        }

        $customer = Customer::where('user_id', auth()->id())->first();
        if ($customer && $request->filled('phone')) {
            $customer->update(['phone' => $request->string('phone')->toString()]);
        }

        $description = $validated['description'];
        if (!empty($validated['address'])) {
            $description .= "\n\nAddress: " . $validated['address'];
        }

        CarSaleRequest::create([
            'customer_id' => auth()->id(),
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'year' => $validated['year'],
            'price' => $validated['price'],
            'mileage' => $validated['mileage'],
            'transmission' => $validated['transmission'],
            'fuel_type' => $validated['fuel_type'],
            'condition' => $validated['condition'],
            'description' => $description,
            'images' => $imagePaths,
            'status' => 'pending',
        ]);

        return redirect()->route('customer.requests.index')
            ->with('success', 'Your car sale request has been submitted successfully.');
    }

    public function myRequests()
    {
        $requests = CarSaleRequest::where('customer_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('customer.my-requests', compact('requests'));
    }
}
