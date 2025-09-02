<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'maintenance_record_id','part_id','name','part_number','manufacturer','category','qty','unit','unit_price','total_price','notes'
    ];

    protected $casts = [
        'maintenance_record_id' => 'integer',
        'part_id' => 'integer',
        'qty' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function record(): BelongsTo
    {
        return $this->belongsTo(MaintenanceRecord::class, 'maintenance_record_id');
    }

    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class);
    }
}


