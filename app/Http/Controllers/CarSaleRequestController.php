<?php

namespace App\Http\Controllers;

use App\Models\CarSaleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarSaleRequestController extends Controller
{
       public function create()
    {
        return view('dashboard.car-sale-requests.create');
    }

    /* ─────────────────────────────────────────────
     *  CUSTOMER: store new request
     * ───────────────────────────────────────────── */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand'           => 'required|string|max:100',
            'model'           => 'required|string|max:100',
            'year'            => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'color'           => 'nullable|string|max:50',
            'engine_capacity' => 'nullable|integer|min:500|max:10000',
            'number_doors'    => 'required|integer|in:2,3,4,5',
            'price'           => 'required|numeric|min:0',
            'mileage'         => 'required|integer|min:0',
            'transmission'    => 'required|in:manual,automatic',
            'fuel_type'       => 'required|in:petrol,diesel,electric,hybrid',
            'condition'       => 'required|in:new,used',
            'description'     => 'required|string|min:20',
            'images.*'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $imagePaths[] = $img->store('car-sale-requests', 'public');
            }
        }

        CarSaleRequest::create([
            ...$validated,
            'customer_id' => Auth::id(),
            'images'      => $imagePaths ?: null,
            'status'      => 'pending',
        ]);

        return redirect()->back()
            ->with('success', 'Your car sale request has been submitted successfully! We will review it shortly.');
    }

    /* ─────────────────────────────────────────────
     *  CUSTOMER: my requests list
     * ───────────────────────────────────────────── */
    public function myRequests()
    {
        $requests = CarSaleRequest::where('customer_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('dashboard.car-sale-requests.my', compact('requests'));
    }

    /* ─────────────────────────────────────────────
     *  MANAGER: all requests list
     * ───────────────────────────────────────────── */
    public function index(Request $request)
    {
        $this->authorizeManager();

        $query = CarSaleRequest::with('customer')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->paginate(15);

        $stats = [
            'total'    => CarSaleRequest::count(),
            'pending'  => CarSaleRequest::pending()->count(),
            'approved' => CarSaleRequest::approved()->count(),
            'rejected' => CarSaleRequest::rejected()->count(),
        ];

        return view('dashboard.car-sale-requests.index', compact('requests', 'stats'));
    }

    /* ─────────────────────────────────────────────
     *  MANAGER: view single request
     * ───────────────────────────────────────────── */
    public function show(CarSaleRequest $carSaleRequest)
    {
        $this->authorizeManager();
        $carSaleRequest->load('customer');
        return view('dashboard.car-sale-requests.show', compact('carSaleRequest'));
    }

    /* ─────────────────────────────────────────────
     *  MANAGER: approve
     * ───────────────────────────────────────────── */
    public function approve(Request $request, CarSaleRequest $carSaleRequest)
    {
        $this->authorizeManager();

        $carSaleRequest->update([
            'status'      => 'approved',
            'admin_notes' => $request->input('admin_notes'),
        ]);

        return redirect()->route('car-sale-requests.index')
            ->with('success', "Request #{$carSaleRequest->id} has been approved.");
    }

    /* ─────────────────────────────────────────────
     *  MANAGER: reject
     * ───────────────────────────────────────────── */
    public function reject(Request $request, CarSaleRequest $carSaleRequest)
    {
        $this->authorizeManager();

        $request->validate([
            'admin_notes' => 'required|string|min:5',
        ]);

        $carSaleRequest->update([
            'status'      => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('car-sale-requests.index')
            ->with('success', "Request #{$carSaleRequest->id} has been rejected.");
    }

    /* ─────────────────────────────────────────────
     *  MANAGER: needs modification
     * ───────────────────────────────────────────── */
    public function needsModification(Request $request, CarSaleRequest $carSaleRequest)
    {
        $this->authorizeManager();

        $request->validate([
            'admin_notes' => 'required|string|min:5',
        ]);

        $carSaleRequest->update([
            'status'      => 'needs_modification',
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('car-sale-requests.index')
            ->with('success', "Request #{$carSaleRequest->id} marked as needs modification.");
    }

    /* ─────────────────────────────────────────────
     *  Helper
     * ───────────────────────────────────────────── */
    private function authorizeManager(): void
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['admin', 'manager', 'employee'])) {
            abort(403, 'Unauthorized');
        }
    }
}
