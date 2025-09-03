<?php

namespace App\Filament\Pages;

use App\Models\OdometerLog;
use App\Models\Vehicle;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard;

class HomeDashboard extends Dashboard
{
    protected static ?string $navigationLabel = 'Panel';

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\UpcomingMaintenanceWidget::class,
            \App\Filament\Widgets\OverdueMaintenanceWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('language')
                ->label('Język')
                ->icon('heroicon-o-globe-alt')
                ->form([
                    Select::make('locale')
                        ->label('Wybierz język')
                        ->options(['pl' => 'Polski', 'en' => 'English'])
                        ->default(app()->getLocale())
                        ->required(),
                ])
                ->action(function (array $data) {
                    session(['locale' => $data['locale']]);
                    $referer = request()->headers->get('referer');
                    $target = $referer ?: url('/admin');
                    return redirect()->to($target);
                }),
            Action::make('add_service')
                ->label('Dodaj serwis')
                ->icon('heroicon-o-wrench-screwdriver')
                ->url(fn () => url('/admin/maintenance-records/create')),

            Action::make('add_odometer')
                ->label('Dodaj przebieg')
                ->icon('heroicon-o-chart-bar')
                ->form([
                    Select::make('vehicle_id')
                        ->label('Pojazd')
                        ->options(fn () => Vehicle::query()->orderBy('registration_number')->pluck('registration_number','id'))
                        ->searchable()
                        ->required(),
                    DatePicker::make('date')->label('Data')->required(),
                    TextInput::make('value_km')->label('Przebieg [km]')->numeric()->required(),
                    Select::make('source')->label('Źródło')->options([
                        'manual' => 'Ręcznie',
                        'service' => 'Serwis',
                        'import' => 'Import',
                    ])->required(),
                ])
                ->action(function (array $data) {
                    OdometerLog::create($data);
                    Notification::make()->success()->title('Zapisano przebieg')->send();
                }),

            Action::make('add_part')
                ->label('Dodaj część')
                ->icon('heroicon-o-cog-6-tooth')
                ->url(fn () => url('/admin/parts/create')),
        ];
    }
}


