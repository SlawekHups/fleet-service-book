<?php

namespace App\Filament\Resources\RecurringMaintenanceRules\Pages;

use App\Filament\Resources\RecurringMaintenanceRules\RecurringMaintenanceRuleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRecurringMaintenanceRules extends ListRecords
{
    protected static string $resource = RecurringMaintenanceRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
