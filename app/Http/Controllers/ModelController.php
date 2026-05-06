<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Models;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function index()
    {
        $models = Models::with('brand')->get();
        $brands = Brand::all();
        return view('dashboard.model-car.index', compact('models', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'brand_id'    => 'required|exists:brands,id',
            'status'      => 'required|boolean',
        ]);

        Models::create($validated);

        return redirect()->route('models.index')
            ->with('success', 'Car model created successfully.');
    }

    public function update(Request $request, $id)
    {
        $model = Models::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'brand_id'    => 'required|exists:brands,id',
            'status'      => 'required|boolean',
        ]);

        $model->update($validated);

        return redirect()->route('models.index')
            ->with('success', 'Car model updated successfully.');
    }

    public function destroy($id)
    {
        Models::findOrFail($id)->delete();

        return redirect()->route('models.index')
            ->with('success', 'Car model deleted successfully.');
    }
}
