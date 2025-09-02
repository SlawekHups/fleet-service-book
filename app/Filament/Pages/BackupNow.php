<?php

namespace App\Filament\Pages;

use BackedEnum;
use UnitEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class BackupNow extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cloud-arrow-down';
    protected static string|UnitEnum|null $navigationGroup = 'Ustawienia';
    protected static ?string $title = 'Kopie zapasowe';
    protected static ?string $navigationLabel = 'Wykonaj backup';

    protected string $view = 'filament.pages.backup-now';

    public static function canAccess(): bool
    {
        $user = Auth::user();
        if (!$user) {
            return false;
        }
        // If Spatie roles/permissions are not present yet, allow access for safety only to logged-in user
        if (method_exists($user, 'hasRole') && $user->{'hasRole'}('Admin')) {
            return true;
        }
        if (method_exists($user, 'can') && $user->{'can'}('settings.manage')) {
            return true;
        }
        return false;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('run_backup')
                ->label('Wykonaj backup teraz')
                ->icon('heroicon-o-play')
                ->requiresConfirmation()
                ->action(function () {
                    Artisan::call('backup:run');
                    Notification::make()
                        ->success()
                        ->title('Backup uruchomiony')
                        ->body(trim(Artisan::output()) ?: 'Zadanie wykonania kopii zostało uruchomione.')
                        ->send();
                }),
        ];
    }
}


