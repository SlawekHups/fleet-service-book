<?php

namespace App\Filament\Resources\RecurringMaintenanceRules\Pages;

use App\Filament\Resources\RecurringMaintenanceRules\RecurringMaintenanceRuleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRecurringMaintenanceRule extends EditRecord
{
    protected static string $resource = RecurringMaintenanceRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
