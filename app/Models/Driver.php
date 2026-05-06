<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'drivers';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'birthdate',
        'gender',
        'salary',
        'photo',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'gender'    => 'boolean',
        'status'    => 'boolean',
        'salary'    => 'decimal:2',
    ];

    // ─── Relationships ────────────────────────────────────────────────

    /**
     * The User account linked to this driver.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * All deliveries assigned to this driver.
     */
    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class, 'driver_id');
    }
}
