<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OdometerLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id','date','value_km','source','notes'
    ];

    protected $casts = [
        'vehicle_id' => 'integer',
        'date' => 'date',
        'value_km' => 'integer',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}


