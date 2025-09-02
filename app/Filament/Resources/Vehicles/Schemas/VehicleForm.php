<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VehicleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('Typ')
                    ->options(['car' => 'Samochód', 'motorcycle' => 'Motocykl'])
                    ->required(),
                TextInput::make('vin')->label('VIN')->required()->unique(ignoreRecord: true),
                TextInput::make('make')->label('Marka')->required(),
                TextInput::make('model')->label('Model')->required(),
                TextInput::make('year')->label('Rok')->required()->numeric()->minValue(1900)->maxValue((int) date('Y') + 1),
                TextInput::make('registration_number')->label('Rejestracja')->required()->unique(ignoreRecord: true),
                TextInput::make('engine_code')->label('Kod silnika'),
                TextInput::make('engine_displacement_cc')->label('Poj. silnika [cc]')->numeric(),
                Select::make('fuel_type')->label('Paliwo')
                    ->options(['petrol' => 'Benzyna', 'diesel' => 'Diesel', 'hybrid' => 'Hybryda', 'ev' => 'EV', 'lpg' => 'LPG'])
                    ->required(),
                TextInput::make('oil_spec')->label('Spec. oleju')->required(),
                TextInput::make('color')->label('Kolor'),
                DatePicker::make('purchase_date')->label('Data zakupu'),
                TextInput::make('odometer_km')->label('Przebieg [km]')->required()->numeric()->default(0),
                DateTimePicker::make('odometer_updated_at')->label('Aktualizacja przebiegu'),
                Textarea::make('notes')->label('Notatki')
                    ->columnSpanFull(),
                Toggle::make('active')->label('Aktywny')->required(),
                DatePicker::make('next_service_due_date')->label('Następny serwis (data)'),
                TextInput::make('next_service_due_km')->label('Następny serwis (km)')->numeric(),
                FileUpload::make('attachments')
                    ->label('Załączniki (placeholder)')
                    ->multiple()
                    ->downloadable()
                    ->openable()
                    ->dehydrated(false)
                    ->helperText('Integracja ze Spatie Media Library w kolejnym etapie'),
            ]);
    }
}
