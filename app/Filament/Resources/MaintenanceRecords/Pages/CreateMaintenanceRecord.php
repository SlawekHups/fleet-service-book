<?php

namespace App\Filament\Resources\MaintenanceRecords\Pages;

use App\Filament\Resources\MaintenanceRecords\MaintenanceRecordResource;
use App\Models\MaintenanceRecord;
use Filament\Resources\Pages\CreateRecord;

class CreateMaintenanceRecord extends CreateRecord
{
    protected static string $resource = MaintenanceRecordResource::class;

    protected function afterCreate(): void
    {
        /** @var MaintenanceRecord $record */
        $record = $this->record;
        // Update vehicle odometer and timestamp
        if ($record->vehicle && $record->odometer_km) {
            $record->vehicle->update([
                'odometer_km' => max($record->vehicle->odometer_km, $record->odometer_km),
                'odometer_updated_at' => now(),
            ]);
        }
        // TODO: create/update OdometerLog and update related rules last_* fields
    }
}
