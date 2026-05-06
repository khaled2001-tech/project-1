<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setteing extends Model
{
    protected $table='settings';
    use HasFactory;
    protected $guarded = [];
    //  protected $fillable = ['name','phone','email','logo','about'];
     public function scopeSelection($query)
    {
        return $query->select('name','phone','email','about');
    }
}
