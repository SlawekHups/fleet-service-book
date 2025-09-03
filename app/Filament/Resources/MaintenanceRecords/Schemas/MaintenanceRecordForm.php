<?php

namespace App\Filament\Resources\MaintenanceRecords\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Schemas\Schema;

class MaintenanceRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('vehicle_id')
                    ->label(__('app.vehicle'))
                    ->relationship('vehicle', 'registration_number')
                    ->preload()
                    ->searchable()
                    ->required(),
                DatePicker::make('date')
                    ->label(__('app.date'))
                    ->required(),
                TextInput::make('odometer_km')
                    ->label(__('app.odometer_km'))
                    ->required()
                    ->numeric(),
                Select::make('type')
                    ->label(__('app.type'))
                    ->options([
                        'service' => __('app.maintenance_type.service'),
                        'repair' => __('app.maintenance_type.repair'),
                        'inspection' => __('app.maintenance_type.inspection'),
                        'tire_change' => __('app.maintenance_type.tire_change'),
                        'accident' => __('app.maintenance_type.accident'),
                        'other' => __('app.maintenance_type.other'),
                    ])
                    ->required(),
                Select::make('vendor_id')
                    ->label(__('app.vendor'))
                    ->relationship('vendor', 'name')
                    ->preload()
                    ->searchable(),
                TextInput::make('invoice_number')->label(__('app.invoice_number')),
                TextInput::make('total_cost')
                    ->label(__('app.total_cost'))
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('currency')
                    ->label(__('app.currency'))
                    ->required()
                    ->default('PLN'),
                Textarea::make('notes')
                    ->label(__('app.notes'))
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('attachments')
                    ->label(__('Załączniki'))
                    ->collection('attachments')
                    ->multiple()
                    ->downloadable()
                    ->openable()
                    ->columnSpanFull(),
            ]);
    }
}
