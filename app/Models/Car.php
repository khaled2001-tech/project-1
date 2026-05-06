<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand_id',
        'model_id',
        'body_type',
        'price',
        'discount',
        'color',
        'menufacturing_year',
        'engine_capacity',
        'transmission_type',
        'number_doors',
        'count',
        'phone',
        'img',
        'status',
        'created_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'status' => 'boolean',
        'menufacturing_year' => 'integer',
        'engine_capacity' => 'integer',
        'number_doors' => 'integer',
        'count' => 'integer',
    ];

    /**
     * Get the brand that owns the car.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the model that owns the car.
     */
    public function model()
    {
        return $this->belongsTo(Models::class, 'model_id');
    }

    /**
     * Get the user who created the car.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all reservations for the car.
     */
    public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'vehicle_id');
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites', 'vehicle_id', 'user_id')
            ->withTimestamps();
    }
             public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'order_id');
    }


public function ratings() {
    return $this->hasMany(Rating::class, 'vehicle_id');
}

public function comments() {
    return $this->hasMany(Comment::class, 'vehicle_id');
}

    /**
     * Get the price after discount.
     */
    public function getPriceAfterDiscountAttribute()
    {
        return $this->price - ($this->price * $this->discount / 100);
    }
}

