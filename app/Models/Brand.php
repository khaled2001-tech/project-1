<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
 protected $guarded = [];

     public function user()
    {
        return $this->hasMany(User::class);
    }
      public function Models()
    {
        return $this->hasMany(Models::class);
    }
      public function cars()
    {
        return $this->hasMany(Car::class);
    }
    //    public function reservation()
    // {
    //     return $this->hasMany(Reservation::class);
    // }
    //    public function createdBy()
    // {
    //     return $this->belongsTo(User::class, 'created_by');
    // }
}
