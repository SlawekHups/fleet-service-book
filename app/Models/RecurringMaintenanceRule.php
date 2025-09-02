<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecurringMaintenanceRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id','component','interval_km','interval_months','last_record_id','last_date','last_odometer_km','next_due_date','next_due_km','lead_time_days','notify','active','notes'
    ];

    protected $casts = [
        'vehicle_id' => 'integer',
        'interval_km' => 'integer',
        'interval_months' => 'integer',
        'last_record_id' => 'integer',
        'last_date' => 'date',
        'last_odometer_km' => 'integer',
        'next_due_date' => 'date',
        'next_due_km' => 'integer',
        'lead_time_days' => 'integer',
        'notify' => 'boolean',
        'active' => 'boolean',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function lastRecord(): BelongsTo
    {
        return $this->belongsTo(MaintenanceRecord::class, 'last_record_id');
    }
}


