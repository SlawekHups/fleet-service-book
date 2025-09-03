<?php

namespace App\Filament\Widgets;

use App\Models\RecurringMaintenanceRule;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UpcomingMaintenanceWidget extends BaseWidget
{
    public function getHeading(): string
    {
        return __('Nadchodzące serwisy');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                RecurringMaintenanceRule::query()
                    ->where('active', true)
                    ->where(function ($q) {
                        $q->whereDate('next_due_date', '>=', now())
                          ->whereDate('next_due_date', '<=', now()->addDays(30));
                    })
                    ->with('vehicle')
            )
            ->columns([
                TextColumn::make('vehicle.registration_number')->label('Pojazd')->searchable(),
                TextColumn::make('component')->label('Element'),
                TextColumn::make('next_due_date')->date()->label('Termin'),
                TextColumn::make('next_due_km')->numeric()->label('Przebieg [km]'),
            ])
            ->filters([
                Filter::make('zakres_dat')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')->label('Od'),
                        \Filament\Forms\Components\DatePicker::make('to')->label('Do'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'] ?? null, fn ($q, $date) => $q->whereDate('next_due_date', '>=', $date))
                            ->when($data['to'] ?? null, fn ($q, $date) => $q->whereDate('next_due_date', '<=', $date));
                    }),
            ]);
    }
}


