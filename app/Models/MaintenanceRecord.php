<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaintenanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id','date','odometer_km','type','vendor_id','invoice_number','total_cost','currency','notes'
    ];

    protected $casts = [
        'vehicle_id' => 'integer',
        'date' => 'date',
        'odometer_km' => 'integer',
        'vendor_id' => 'integer',
        'total_cost' => 'decimal:2',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(MaintenanceItem::class);
    }
}


