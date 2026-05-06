<?php
// app/Models/Delivery.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'driver_id',
        'assigned_by',
        'delivery_address',
        'status',
        'driver_notes',
        'accepted_at',
        'delivered_at',
    ];

    protected $casts = [
        'accepted_at'  => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(Employee::class, 'assigned_by');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'     => 'warning',
            'accepted'    => 'info',
            'rejected'    => 'danger',
            'in_progress' => 'primary',
            'delivered'   => 'success',
            default       => 'secondary',
        };
    }
}
