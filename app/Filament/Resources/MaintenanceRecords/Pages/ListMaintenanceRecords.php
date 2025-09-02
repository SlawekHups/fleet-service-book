<?php

namespace App\Filament\Resources\MaintenanceRecords\Pages;

use App\Filament\Resources\MaintenanceRecords\MaintenanceRecordResource;
use App\Exports\MaintenanceRecordsExport;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Resources\Pages\ListRecords;

class ListMaintenanceRecords extends ListRecords
{
    protected static string $resource = MaintenanceRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('export_csv')
                ->label('Export CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(fn () => Excel::download(new MaintenanceRecordsExport(), 'maintenance_records.csv', \Maatwebsite\Excel\Excel::CSV))
                ->requiresConfirmation(),
            Action::make('export_xlsx')
                ->label('Export XLSX')
                ->icon('heroicon-o-document-arrow-down')
                ->action(fn () => Excel::download(new MaintenanceRecordsExport(), 'maintenance_records.xlsx'))
                ->requiresConfirmation(),
        ];
    }
}
