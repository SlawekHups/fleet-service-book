<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\LogOptions;

class Vehicle extends Model implements HasMedia
{
    use HasFactory, LogsActivity, InteractsWithMedia;

    protected $fillable = [
        'type','vin','make','model','year','registration_number','engine_code','engine_displacement_cc','fuel_type','oil_spec','color','purchase_date','odometer_km','odometer_updated_at','notes','active','next_service_due_date','next_service_due_km'
    ];

    protected $casts = [
        'year' => 'integer',
        'engine_displacement_cc' => 'integer',
        'purchase_date' => 'date',
        'odometer_km' => 'integer',
        'odometer_updated_at' => 'datetime',
        'active' => 'boolean',
        'next_service_due_date' => 'date',
        'next_service_due_km' => 'integer',
    ];

    protected static $logName = 'vehicle';
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    public function maintenanceRecords(): HasMany
    {
        return $this->hasMany(MaintenanceRecord::class);
    }

    public function odometerLogs(): HasMany
    {
        return $this->hasMany(OdometerLog::class);
    }

    public function parts(): BelongsToMany
    {
        return $this->belongsToMany(Part::class, 'part_vehicle')->withTimestamps()->withPivot(['preferred','notes']);
    }

    public function recurringRules(): HasMany
    {
        return $this->hasMany(RecurringMaintenanceRule::class);
    }
}


