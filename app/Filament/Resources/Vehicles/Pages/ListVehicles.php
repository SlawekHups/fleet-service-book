<?php

namespace App\Filament\Resources\Vehicles\Pages;

use App\Filament\Resources\Vehicles\VehicleResource;
use App\Exports\VehiclesExport;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Resources\Pages\ListRecords;

class ListVehicles extends ListRecords
{
    protected static string $resource = VehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('export_csv')
                ->label('Export CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(fn () => Excel::download(new VehiclesExport(), 'vehicles.csv', \Maatwebsite\Excel\Excel::CSV))
                ->requiresConfirmation(),
            Action::make('export_xlsx')
                ->label('Export XLSX')
                ->icon('heroicon-o-document-arrow-down')
                ->action(fn () => Excel::download(new VehiclesExport(), 'vehicles.xlsx'))
                ->requiresConfirmation(),
        ];
    }
}
