<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
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
                    ->label(__('app.type'))
                    ->options(['car' => __('app.vehicle_type.car'), 'motorcycle' => __('app.vehicle_type.motorcycle')])
                    ->required(),
                TextInput::make('vin')->label(__('app.vin'))->required()->unique(ignoreRecord: true),
                TextInput::make('make')->label(__('app.make'))->required(),
                TextInput::make('model')->label(__('app.model'))->required(),
                TextInput::make('year')->label(__('app.year'))->required()->numeric()->minValue(1900)->maxValue((int) date('Y') + 1),
                TextInput::make('registration_number')->label(__('app.registration_number'))->required()->unique(ignoreRecord: true),
                TextInput::make('engine_code')->label(__('app.engine_code')),
                TextInput::make('engine_displacement_cc')->label(__('app.engine_displacement_cc'))->numeric(),
                Select::make('fuel_type')->label(__('app.fuel_type'))
                    ->options([
                        'petrol' => __('app.fuel.petrol'),
                        'diesel' => __('app.fuel.diesel'),
                        'hybrid' => __('app.fuel.hybrid'),
                        'ev' => __('app.fuel.ev'),
                        'lpg' => __('app.fuel.lpg'),
                    ])
                    ->required(),
                TextInput::make('oil_spec')->label(__('app.oil_spec'))->required(),
                TextInput::make('color')->label(__('app.color')),
                DatePicker::make('purchase_date')->label(__('app.purchase_date')),
                TextInput::make('odometer_km')->label(__('app.odometer_km'))->required()->numeric()->default(0),
                DateTimePicker::make('odometer_updated_at')->label(__('Aktualizacja przebiegu')),
                Textarea::make('notes')->label(__('app.notes'))
                    ->columnSpanFull(),
                Toggle::make('active')->label(__('app.active'))->required(),
                DatePicker::make('next_service_due_date')->label(__('app.next_service_due_date')),
                TextInput::make('next_service_due_km')->label(__('app.next_service_due_km'))->numeric(),
                SpatieMediaLibraryFileUpload::make('photos')
                    ->label(__('Zdjęcia / Skany'))
                    ->collection('photos')
                    ->multiple()
                    ->downloadable()
                    ->openable()
                    ->columnSpanFull(),
            ]);
    }
}
