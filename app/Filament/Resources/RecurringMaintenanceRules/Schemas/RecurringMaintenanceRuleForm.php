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
                    ->label(__('app.vehicle'))
                    ->relationship('vehicle', 'registration_number')
                    ->searchable(),
                Select::make('component')
                    ->label(__('app.maintenance_rule.fields.component'))
                    ->options([
                        'oil' => __('app.maintenance_rule.components.oil'),
                        'filter_oil' => __('app.maintenance_rule.components.filter_oil'),
                        'filter_air' => __('app.maintenance_rule.components.filter_air'),
                        'filter_cabin' => __('app.maintenance_rule.components.filter_cabin'),
                        'filter_fuel' => __('app.maintenance_rule.components.filter_fuel'),
                        'brake_pads' => __('app.maintenance_rule.components.brake_pads'),
                        'brake_discs' => __('app.maintenance_rule.components.brake_discs'),
                        'coolant' => __('app.maintenance_rule.components.coolant'),
                        'spark_plug' => __('app.maintenance_rule.components.spark_plug'),
                        'chain' => __('app.maintenance_rule.components.chain'),
                        'sprocket' => __('app.maintenance_rule.components.sprocket'),
                        'tire' => __('app.maintenance_rule.components.tire'),
                        'belt' => __('app.maintenance_rule.components.belt'),
                        'wiper' => __('app.maintenance_rule.components.wiper'),
                        'labor' => __('app.maintenance_rule.components.labor'),
                        'other' => __('app.maintenance_rule.components.other'),
                        'inspection_general' => __('app.maintenance_rule.components.inspection_general'),
                    ])
                    ->required(),
                TextInput::make('interval_km')
                    ->label(__('app.maintenance_rule.fields.interval_km'))
                    ->numeric(),
                TextInput::make('interval_months')
                    ->label(__('app.maintenance_rule.fields.interval_months'))
                    ->numeric(),
                Select::make('last_record_id')
                    ->label(__('app.maintenance_rule.fields.last_record'))
                    ->relationship('lastRecord', 'id'),
                DatePicker::make('last_date')
                    ->label(__('app.maintenance_rule.fields.last_date')),
                TextInput::make('last_odometer_km')
                    ->label(__('app.maintenance_rule.fields.last_odometer_km'))
                    ->numeric(),
                DatePicker::make('next_due_date')
                    ->label(__('app.maintenance_rule.fields.next_due_date')),
                TextInput::make('next_due_km')
                    ->label(__('app.maintenance_rule.fields.next_due_km'))
                    ->numeric(),
                TextInput::make('lead_time_days')
                    ->label(__('app.maintenance_rule.fields.lead_time_days'))
                    ->required()
                    ->numeric()
                    ->default(14),
                Toggle::make('notify')
                    ->label(__('app.maintenance_rule.fields.notify'))
                    ->required(),
                Toggle::make('active')
                    ->label(__('app.active'))
                    ->required(),
                Textarea::make('notes')
                    ->label(__('app.notes'))
                    ->columnSpanFull(),
            ]);
    }
}
