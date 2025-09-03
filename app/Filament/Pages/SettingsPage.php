<?php

namespace App\Filament\Pages;

use App\Models\AppSetting;
use BackedEnum;
use Filament\Forms\Components\KeyValue;
use Filament\Schemas\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class SettingsPage extends Page
{
    protected ?string $heading = 'Ustawienia aplikacji';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;
    protected static string|UnitEnum|null $navigationGroup = 'Ustawienia';
    protected string $view = 'filament.pages.settings';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && (method_exists($user, 'hasRole') ? $user->{'hasRole'}('Admin') : true);
    }

    public function mount(): void
    {
        $settings = AppSetting::first();
        $this->data = $settings ? $settings->toArray() : [
            'lead_time_days' => 14,
            'default_intervals' => config('fleet.defaults'),
            'mail_from_address' => config('mail.from.address'),
            'notifications_enabled' => true,
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Fieldset::make('Powiadomienia i interwały')->schema([
                TextInput::make('lead_time_days')->numeric()->label('Lead time (dni)')->required(),
                KeyValue::make('default_intervals')->label('Domyślne interwały (JSON)')->columnSpanFull(),
                TextInput::make('mail_from_address')->label('Email nadawcy'),
                Toggle::make('notifications_enabled')->label('Powiadomienia włączone'),
            ])->columns(2),
        ])->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();
        AppSetting::query()->firstOrNew()->fill($state)->save();
        Notification::make()->success()->title('Zapisano ustawienia')->send();
    }
}


