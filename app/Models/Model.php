<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    use HasFactory;
 protected $guarded = [];

    public function user()
    {
        return $this->hasMany(User::class);
    }
       public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
       public function cars()
    {
        return $this->hasMany(Car::class);
    }
       public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }
}
