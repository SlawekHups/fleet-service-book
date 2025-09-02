<?php

namespace App\Filament\Resources\MaintenanceRecords\Pages;

use App\Filament\Resources\MaintenanceRecords\MaintenanceRecordResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMaintenanceRecord extends EditRecord
{
    protected static string $resource = MaintenanceRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
