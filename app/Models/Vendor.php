<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','type','phone','email','address','notes'
    ];

    public function records(): HasMany
    {
        return $this->hasMany(MaintenanceRecord::class);
    }
}


