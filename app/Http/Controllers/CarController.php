<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Brand;
use App\Models\Models;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     $cars = Car::with(['brand', 'model'])->paginate(5);
        $brands = Brand::all();
        $models = Models::all();


        return view('dashboard.cars.index', compact('cars','brands','models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::all();
        $models = Models::all();

        return view('dashboard.cars.create', compact('brands', 'models'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'model_id' => 'nullable|exists:models,id',
            'body_type' => 'required|in:rent,buy',
            'price' => 'required|numeric|min:0',
            'color' => 'nullable|string|max:255',
            'Vin-number'=>'nullable|numeric|min:0',
            'menufacturing_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'engine_capacity' => 'nullable|integer|min:0',
            'transmission_type' => 'nullable|string|max:255',
            'number_doors' => 'nullable|integer|min:2|max:6',
            'count' => 'nullable|integer|min:0',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('img')) {
            $validated['img'] = $request->file('img')->store('cars', 'public');
        }

        // Add created_by
        // $validated['created_by'] = Auth::id();

        Car::create($validated);

        return redirect()->route('cars.index')
            ->with('success', 'Car created successfully!');
    }

    /**
     * Display the specified resource.
     */
   public function show(Car $car)
{
    $car->load(['brand', 'model', 'reservation', 'creator', 'ratings.user', 'comments.customer']);
    return view('dashboard.cars.show', compact('car'));
}

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Car $car)
    {
        $brands = Brand::all();
        $models = Models::all();

        $prevCar = Car::where('id', '<', $car->id)->orderBy('id', 'desc')->first();
        $nextCar = Car::where('id', '>', $car->id)->orderBy('id', 'asc')->first();

        return view('dashboard.cars.edit', compact('car', 'brands', 'models', 'prevCar', 'nextCar'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'model_id' => 'nullable|exists:models,id',
            'body_type' => 'required|in:rent,buy',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'color' => 'nullable|string|max:255',
            'menufacturing_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'engine_capacity' => 'nullable|integer|min:0',
            'transmission_type' => 'nullable|string|max:255',
            'number_doors' => 'nullable|integer|min:2|max:6',
            'count' => 'nullable|integer|min:0',
            'phone' => 'nullable|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|boolean',
        ]);

        // Handle image upload
       if ($request->hasFile('img')) {
            $validated['img'] = $request->file('img')->store('cars', 'public');
        }


        $car->update($validated);

        return redirect()->route('cars.index')
            ->with('success', 'Car updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        // Delete image if exists
        if ($car->img) {
            Storage::disk('public')->delete($car->img);
        }

        $car->delete();

        return redirect()->route('cars.index')
            ->with('success', 'Car deleted successfully!');
    }
}
