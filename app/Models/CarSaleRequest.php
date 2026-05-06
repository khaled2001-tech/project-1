<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarSaleRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'brand',
        'model',
        'year',
        'color',
        'engine_capacity',
        'number_doors',
        'price',
        'mileage',
        'transmission',
        'fuel_type',
        'condition',
        'description',
        'images',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'images' => 'array',
        'price'  => 'decimal:2',
        'year'   => 'integer',
    ];

    // ✅ Fixed: relation points to User not Customer
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Helper
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function statusBadgeClass(): string
    {
        return match($this->status) {
            'approved'          => 'badge-success',
            'rejected'          => 'badge-danger',
            'needs_modification'=> 'badge-warning',
            default             => 'badge-secondary',
        };
    }
}
