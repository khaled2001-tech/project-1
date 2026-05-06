<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Employee;
use App\Models\Setteing;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $setting = Setteing::Selection()->first();
        $employees = Employee::all();
        $cars = Car::query()
            ->with(['brand', 'model'])
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->latest()
            ->paginate(100);

        $favoriteIds = auth()->user()->favorites()->pluck('vehicle_id');

        return view('Front.index', compact('setting', 'employees', 'cars', 'favoriteIds'));
    }
}
