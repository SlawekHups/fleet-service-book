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
                TextColumn::make('vehicle.id')
                    ->searchable(),
                TextColumn::make('component'),
                TextColumn::make('interval_km')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('interval_months')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lastRecord.id')
                    ->searchable(),
                TextColumn::make('last_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('last_odometer_km')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('next_due_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('next_due_km')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lead_time_days')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('notify')
                    ->boolean(),
                IconColumn::make('active')
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
