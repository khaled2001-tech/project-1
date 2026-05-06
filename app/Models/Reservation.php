<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'pickup_date',
        'return_date',
        'total_price',
        'rental_days',
        'pickup_location',
        'notes',
        'status',
        'brand_id',
        'model_id',
        'car_id',
        'customer_id',
        'approved_id',
        'delivery_required',
        'delivery_address',
        'delivery_status',
    ];

    protected $casts = [
        'pickup_date'       => 'datetime',
        'return_date'       => 'datetime',
        'total_price'       => 'decimal:2',
        'delivery_required' => 'boolean',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function model()
    {
        return $this->belongsTo(Models::class, 'model_id');
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

 
       public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'approved_id');
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'reservation_id');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'warning',
            'approved'  => 'success',
            'rejected'  => 'danger',
            'completed' => 'info',
            'cancelled' => 'secondary',
            default     => 'secondary',
        };
    }
}
