<?php

namespace App\Filament\Resources\Vehicles\Pages;

use App\Filament\Resources\Vehicles\VehicleResource;
use App\Exports\VehiclesExport;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Resources\Pages\ListRecords;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Services\Imports\VehiclesCsvImporter;
use Filament\Forms\Components\FileUpload;

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
            Action::make('import_csv')
                ->label('Import CSV')
                ->icon('heroicon-o-arrow-up-tray')
                ->form([
                    FileUpload::make('file')->required()->acceptedFileTypes(['text/csv'])->storeFiles(false),
                ])
                ->action(function (array $data) {
                    /** @var TemporaryUploadedFile $file */
                    $file = $data['file'];
                    $path = $file->getRealPath();
                    $result = app(VehiclesCsvImporter::class)->import($path);
                    $msg = "Dodano: {$result['created']}, zaktualizowano: {$result['updated']}";
                    if (!empty($result['errors'])) {
                        $msg .= "\nBłędy w wierszach: " . collect($result['errors'])->pluck('row')->join(', ');
                    }
                    $this->notify('success', $msg);
                }),
        ];
    }
}
