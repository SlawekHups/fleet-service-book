<?php

namespace App\Filament\Resources\RecurringMaintenanceRules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RecurringMaintenanceRulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vehicle.registration_number')
                    ->label(__('app.vehicle'))->searchable(),
                TextColumn::make('component')->label(__('app.category')),
                TextColumn::make('interval_km')->label(__('app.next_service_due_km'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('interval_months')->label(__('Miesiące'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lastRecord.id')->label(__('Ostatni rekord'))
                    ->searchable(),
                TextColumn::make('last_date')->label(__('app.date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('last_odometer_km')->label(__('app.odometer_km'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('next_due_date')->label(__('app.next_service_due_date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('next_due_km')->label(__('app.next_service_due_km'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lead_time_days')->label(__('Lead time (dni)'))
                    ->numeric()
                    ->sortable(),
                IconColumn::make('notify')->label(__('Powiadomienia'))
                    ->boolean(),
                IconColumn::make('active')->label(__('app.active'))
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
