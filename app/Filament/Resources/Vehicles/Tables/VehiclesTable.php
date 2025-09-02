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
                TextColumn::make('make')->label('Marka')->searchable(),
                TextColumn::make('model')->label('Model')->searchable(),
                TextColumn::make('year')->label('Rocznik')->numeric()->sortable(),
                TextColumn::make('registration_number')->label('Rejestracja')->searchable()->toggleable(false),
                TextColumn::make('vin')->label('VIN')->searchable(),
                TextColumn::make('odometer_km')->label('Przebieg [km]')->numeric()->sortable(),
                TextColumn::make('next_service_due_date')->label('Nast. serwis (data)')->date()->sortable(),
                TextColumn::make('next_service_due_km')->label('Nast. serwis (km)')->numeric()->sortable(),
                IconColumn::make('active')->label('Aktywny')->boolean(),
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
