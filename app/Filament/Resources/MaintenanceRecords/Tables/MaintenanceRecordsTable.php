<?php

namespace App\Filament\Resources\MaintenanceRecords\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MaintenanceRecordsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vehicle.registration_number')->label(__('app.vehicle'))->searchable(),
                TextColumn::make('date')->label(__('app.date'))->date()->sortable(),
                TextColumn::make('odometer_km')->label(__('app.odometer_km'))->numeric()->sortable(),
                TextColumn::make('type')->label(__('app.type')),
                TextColumn::make('vendor.name')->label(__('app.vendor'))->searchable(),
                TextColumn::make('invoice_number')->label(__('app.invoice_number'))->searchable(),
                TextColumn::make('total_cost')->label(__('app.total_cost'))->money('PLN')->sortable(),
                TextColumn::make('currency')->label(__('app.currency')),
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
