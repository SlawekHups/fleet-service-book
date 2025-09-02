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
                TextColumn::make('vehicle.registration_number')->label('Pojazd')->searchable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('odometer_km')->label('Przebieg [km]')->numeric()->sortable(),
                TextColumn::make('type')->label('Typ'),
                TextColumn::make('vendor.name')->label('Dostawca')->searchable(),
                TextColumn::make('invoice_number')->label('Faktura')->searchable(),
                TextColumn::make('total_cost')->label('Kwota')->money('PLN')->sortable(),
                TextColumn::make('currency')->label('Wal.'),
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
