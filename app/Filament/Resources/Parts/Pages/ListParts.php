<?php

namespace App\Filament\Resources\Parts\Pages;

use App\Filament\Resources\Parts\PartResource;
use App\Exports\PartsExport;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Resources\Pages\ListRecords;

class ListParts extends ListRecords
{
    protected static string $resource = PartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('export_csv')
                ->label('Export CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(fn () => Excel::download(new PartsExport(), 'parts.csv', \Maatwebsite\Excel\Excel::CSV))
                ->requiresConfirmation(),
            Action::make('export_xlsx')
                ->label('Export XLSX')
                ->icon('heroicon-o-document-arrow-down')
                ->action(fn () => Excel::download(new PartsExport(), 'parts.xlsx'))
                ->requiresConfirmation(),
        ];
    }
}
