<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Favorite;
use App\Models\Models;


class WelcomeController extends Controller
{
    public function index()
    {

    $cars=Car::get();
     $userFavorites = auth()->check()? Favorite::where('user_id', auth()->id())->pluck('vehicle_id')->toArray()
        : [];
        return  view('welcome.index',compact('cars','userFavorites'));
    }
   public function rentcar(Request $request)
{
    $query = Car::with(['brand', 'model'])->where('body_type', 'RENT');

    if ($request->filled('brand_id')) {
        $query->where('brand_id', $request->brand_id);
    }

    if ($request->filled('model_id')) {
        $query->where('model_id', $request->model_id);
    }

    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }

    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    $cars   = $query->get();
    $brands = Brand::all();
    $models = Models::all();
    $userFavorites = auth()->check()? Favorite::where('user_id', auth()->id())->pluck('vehicle_id')->toArray()
        : [];

    return view('welcome.rentcar', compact('cars', 'brands', 'models','userFavorites'));
}
     public function buycar(Request $request)
{
    $query = Car::with(['brand', 'model'])->where('body_type', 'BUY');

    if ($request->filled('brand_id')) {
        $query->where('brand_id', $request->brand_id);
    }

    if ($request->filled('model_id')) {
        $query->where('model_id', $request->model_id);
    }

    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }

    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }
 $userFavorites = auth()->check()? Favorite::where('user_id', auth()->id())->pluck('vehicle_id')->toArray()
        : [];
    $cars   = $query->get();
    $brands = Brand::all();
    $models = Models::all();

    return view('welcome.buycar', compact('cars', 'brands', 'models','userFavorites'));
}



public function sellCar()
{
    return view('welcome.sell-car');
}

















}
