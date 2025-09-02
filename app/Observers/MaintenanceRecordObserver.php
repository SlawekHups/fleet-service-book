<?php

namespace App\Observers;

use App\Models\MaintenanceRecord;
use App\Services\RecurringMaintenanceService;

class MaintenanceRecordObserver
{
    public function __construct(private readonly RecurringMaintenanceService $service)
    {
    }

    public function created(MaintenanceRecord $record): void
    {
        $this->service->onRecordSaved($record);
    }

    public function updated(MaintenanceRecord $record): void
    {
        $this->service->onRecordSaved($record);
    }
}


