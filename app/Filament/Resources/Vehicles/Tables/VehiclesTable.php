<?php

namespace App\Filament\Resources\Vehicles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VehiclesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('make')->label(__('app.make'))->searchable(),
                TextColumn::make('model')->label(__('app.model'))->searchable(),
                TextColumn::make('year')->label(__('app.year'))->numeric()->sortable(),
                TextColumn::make('registration_number')->label(__('app.registration_number'))->searchable()->toggleable(false),
                TextColumn::make('vin')->label(__('app.vin'))->searchable(),
                TextColumn::make('odometer_km')->label(__('app.odometer_km'))->numeric()->sortable(),
                TextColumn::make('next_service_due_date')->label(__('app.next_service_due_date'))->date()->sortable(),
                TextColumn::make('next_service_due_km')->label(__('app.next_service_due_km'))->numeric()->sortable(),
                IconColumn::make('active')->label(__('app.active'))->boolean(),
            ])
            ->filters([
                SelectFilter::make('type')->label('Typ')
                    ->options(['car' => 'Samochód', 'motorcycle' => 'Motocykl']),
                Filter::make('active')->label('Aktywne')
                    ->query(fn ($q) => $q->where('active', true)),
                Filter::make('overdue_service')->label('Zaległe serwisy')
                    ->query(fn ($q) => $q->whereNotNull('next_service_due_date')->whereDate('next_service_due_date', '<', now())),
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
