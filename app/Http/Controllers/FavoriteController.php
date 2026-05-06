<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Request $request, int $carId)
    {
        $user = Auth::user();

        $favorite = Favorite::where('user_id', $user->id)
                            ->where('vehicle_id', $carId)
                            ->first();

        if ($favorite) {
            $favorite->delete();
            $isFavorited = false;
        } else {
            Favorite::create([
                'user_id'    => $user->id,
                'vehicle_id' => $carId,
            ]);
            $isFavorited = true;
        }

        if ($request->ajax()) {
            return response()->json(['favorited' => $isFavorited]);
        }

        return back();
    }

    public function index()
    {
        $favorites = Favorite::with('vehicle.brand')
                             ->where('user_id', Auth::id())
                             ->latest()
                             ->get();

        return view('welcome.favorites', compact('favorites'));
    }
}
