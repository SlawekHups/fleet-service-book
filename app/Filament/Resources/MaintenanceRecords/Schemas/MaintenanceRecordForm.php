<?php

namespace App\Filament\Resources\MaintenanceRecords\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MaintenanceRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('vehicle_id')
                    ->label('Pojazd')
                    ->relationship('vehicle', 'registration_number')
                    ->searchable()
                    ->required(),
                DatePicker::make('date')
                    ->label('Data')
                    ->required(),
                TextInput::make('odometer_km')
                    ->label('Przebieg [km]')
                    ->required()
                    ->numeric(),
                Select::make('type')
                    ->label('Typ')
                    ->options([
                        'service' => 'Serwis',
                        'repair' => 'Naprawa',
                        'inspection' => 'Przegląd',
                        'tire_change' => 'Wymiana opon',
                        'accident' => 'Kolizja',
                        'other' => 'Inne',
                    ])
                    ->required(),
                Select::make('vendor_id')
                    ->label('Dostawca / Serwis')
                    ->relationship('vendor', 'name')
                    ->searchable(),
                TextInput::make('invoice_number')->label('Faktura'),
                TextInput::make('total_cost')
                    ->label('Kwota')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('currency')
                    ->label('Waluta')
                    ->required()
                    ->default('PLN'),
                Textarea::make('notes')
                    ->label('Notatki')
                    ->columnSpanFull(),
            ]);
    }
}
