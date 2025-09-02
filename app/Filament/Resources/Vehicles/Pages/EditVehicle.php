<?php

namespace App\Filament\Resources\Vehicles\Pages;

use App\Filament\Resources\Vehicles\VehicleResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditVehicle extends EditRecord
{
    protected static string $resource = VehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            Action::make('pdf')
                ->label('Pobierz książkę PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn () => route('vehicles.pdf', $this->record), shouldOpenInNewTab: true),
        ];
    }
}
