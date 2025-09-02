<?php

namespace App\Filament\Resources\RecurringMaintenanceRules\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RecurringMaintenanceRuleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('vehicle_id')
                    ->relationship('vehicle', 'id'),
                Select::make('component')
                    ->options([
            'oil' => 'Oil',
            'filter_oil' => 'Filter oil',
            'filter_air' => 'Filter air',
            'filter_cabin' => 'Filter cabin',
            'filter_fuel' => 'Filter fuel',
            'brake_pads' => 'Brake pads',
            'brake_discs' => 'Brake discs',
            'coolant' => 'Coolant',
            'spark_plug' => 'Spark plug',
            'chain' => 'Chain',
            'sprocket' => 'Sprocket',
            'tire' => 'Tire',
            'belt' => 'Belt',
            'wiper' => 'Wiper',
            'labor' => 'Labor',
            'other' => 'Other',
            'inspection_general' => 'Inspection general',
        ])
                    ->required(),
                TextInput::make('interval_km')
                    ->numeric(),
                TextInput::make('interval_months')
                    ->numeric(),
                Select::make('last_record_id')
                    ->relationship('lastRecord', 'id'),
                DatePicker::make('last_date'),
                TextInput::make('last_odometer_km')
                    ->numeric(),
                DatePicker::make('next_due_date'),
                TextInput::make('next_due_km')
                    ->numeric(),
                TextInput::make('lead_time_days')
                    ->required()
                    ->numeric()
                    ->default(14),
                Toggle::make('notify')
                    ->required(),
                Toggle::make('active')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
