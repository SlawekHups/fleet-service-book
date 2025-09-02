<?php

namespace App\Filament\Resources\Vehicles\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MaintenanceRecordsRelationManager extends RelationManager
{
    protected static string $relationship = 'maintenanceRecords';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            DatePicker::make('date')->label('Data')->required(),
            TextInput::make('odometer_km')->label('Przebieg [km]')->numeric()->required(),
            Select::make('type')->label('Typ')->options([
                'service' => 'Serwis',
                'repair' => 'Naprawa',
                'inspection' => 'Przegląd',
                'tire_change' => 'Wymiana opon',
                'accident' => 'Kolizja',
                'other' => 'Inne',
            ])->required(),
            TextInput::make('invoice_number')->label('Faktura'),
            TextInput::make('total_cost')->label('Kwota')->numeric()->default(0),
            Textarea::make('notes')->label('Notatki')->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('date')->date()->label('Data')->sortable(),
            TextColumn::make('type')->label('Typ'),
            TextColumn::make('odometer_km')->label('Przebieg [km]')->numeric(),
            TextColumn::make('vendor.name')->label('Dostawca'),
            TextColumn::make('total_cost')->label('Kwota')->money('PLN'),
        ]);
    }
}


