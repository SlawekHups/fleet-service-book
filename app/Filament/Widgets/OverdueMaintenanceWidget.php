<?php

namespace App\Filament\Widgets;

use App\Models\RecurringMaintenanceRule;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class OverdueMaintenanceWidget extends BaseWidget
{
    public function getHeading(): string
    {
        return __('Przeterminowane serwisy');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                RecurringMaintenanceRule::query()
                    ->where('active', true)
                    ->whereNotNull('next_due_date')
                    ->whereDate('next_due_date', '<', now())
                    ->with('vehicle')
            )
            ->columns([
                TextColumn::make('vehicle.registration_number')->label('Pojazd')->searchable(),
                TextColumn::make('component')->label('Element'),
                TextColumn::make('next_due_date')->date()->label('Termin'),
                TextColumn::make('next_due_km')->numeric()->label('Przebieg [km]'),
            ]);
    }
}


