<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'profile_image',
        'bio',
        'license_number',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
public function employee()
{
    return $this->hasOne(Employee::class);
}
      public function customer()
    {
        return $this->hasOne(Customer::class);
    }

     public function brands()
    {
        return $this->belongsTo(Brand::class);
    }
       public function models()
    {
        return $this->belongsTo(Models::class);
    }
        public function cars()
    {
        return $this->belongsTo(Car::class);
    }
    public function driver()
{
    return $this->hasOne(\App\Models\Driver::class);
}


     public function isAdmin()
    {
        return in_array($this->role, ['admin','employee', 'manager']);
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    public function isDriver()
    {
        return $this->role === 'driver';
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'driver_id');
    }

    public function scopeActiveDrivers($query)
    {
        return $query->where('role', 'driver')->where('status', 'active');
    }

    public function carSaleRequests()
    {
        return $this->hasMany(CarSaleRequest::class, 'customer_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedVehicles()
    {
        return $this->belongsToMany(Car::class, 'favorites', 'user_id', 'vehicle_id')
            ->withTimestamps();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // public function vehicleComments()
    // {
    //     return $this->hasMany(Comment::class);
    // }

    public function hasFavoritedVehicle(int $vehicleId): bool
    {
        return $this->favorites()->where('vehicle_id', $vehicleId)->exists();
    }
}
