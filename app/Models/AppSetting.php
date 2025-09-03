<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_time_days','default_intervals','mail_from_address','notifications_enabled',
    ];

    protected $casts = [
        'lead_time_days' => 'integer',
        'default_intervals' => 'array',
        'notifications_enabled' => 'boolean',
    ];
}


