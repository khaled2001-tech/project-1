<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use App\Models\CarSaleRequest;
use App\Models\Models;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerCarRequestController extends Controller
{
    public function index()
    {
        $requests = CarSaleRequest::with('customer')->latest()->paginate(15);

        return view('back.car-requests.index', compact('requests'));
    }

    public function show(int $id)
    {
        $requestItem = CarSaleRequest::with('customer')->findOrFail($id);

        return view('back.car-requests.show', compact('requestItem'));
    }

    public function approve(int $id): RedirectResponse
    {
        $requestItem = CarSaleRequest::findOrFail($id);

        if ($requestItem->status !== 'pending' && $requestItem->status !== 'needs_modification') {
            return back()->with('error', 'This request cannot be approved in its current status.');
        }

        DB::transaction(function () use ($requestItem) {
            $brand = Brand::firstOrCreate(
                ['name' => $requestItem->brand],
                ['status' => true, 'created_by' => auth()->id()]
            );

            $model = Models::firstOrCreate(
                ['name' => $requestItem->model, 'brand_id' => $brand->id],
                ['status' => true, 'created_by' => auth()->id()]
            );

            $firstImage = is_array($requestItem->images) && !empty($requestItem->images)
                ? $requestItem->images[0]
                : null;

            Car::create([
                'name' => $requestItem->brand . ' ' . $requestItem->model,
                'img' => $firstImage,
                'count' => 1,
                'body_type' => 'BUY',
                'color' => null,
                'price' => $requestItem->price,
                'engine_capacity' => null,
                'menufacturing_year' => $requestItem->year,
                'transmission_type' => ucfirst($requestItem->transmission),
                'number_doors' => 4,
                'discount' => 0,
                'status' => true,
                'brand_id' => $brand->id,
                'model_id' => $model->id,
                'created_by' => $requestItem->customer_id,
            ]);

            $requestItem->update([
                'status' => 'approved',
                'admin_notes' => null,
            ]);
        });

        return back()->with('success', 'Request approved and car added successfully.');
    }

    public function reject(int $id): RedirectResponse
    {
        $requestItem = CarSaleRequest::findOrFail($id);

        $requestItem->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Request rejected successfully.');
    }

    public function requestModification(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'admin_notes' => 'required|string|min:5|max:1000',
        ]);

        $requestItem = CarSaleRequest::findOrFail($id);

        $requestItem->update([
            'status' => 'needs_modification',
            'admin_notes' => $validated['admin_notes'],
        ]);

        return back()->with('success', 'Modification request sent to customer.');
    }
}
