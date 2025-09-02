<?php

namespace App\Filament\Resources\Vehicles;

use App\Filament\Resources\Vehicles\Pages\CreateVehicle;
use App\Filament\Resources\Vehicles\Pages\EditVehicle;
use App\Filament\Resources\Vehicles\Pages\ListVehicles;
use App\Filament\Resources\Vehicles\Schemas\VehicleForm;
use App\Filament\Resources\Vehicles\Tables\VehiclesTable;
use App\Models\Vehicle;
use BackedEnum;
use UnitEnum;
use Illuminate\Support\Facades\Gate;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;
    protected static ?string $modelLabel = 'Pojazd';
    protected static ?string $pluralModelLabel = 'Pojazdy';
    protected static string|UnitEnum|null $navigationGroup = 'Pojazdy';

    public static function form(Schema $schema): Schema
    {
        return VehicleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VehiclesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\Vehicles\RelationManagers\MaintenanceRecordsRelationManager::class,
            \App\Filament\Resources\Vehicles\RelationManagers\OdometerLogsRelationManager::class,
            \App\Filament\Resources\Vehicles\RelationManagers\PartsRelationManager::class,
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Gate::allows('viewAny', Vehicle::class);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVehicles::route('/'),
            'create' => CreateVehicle::route('/create'),
            'edit' => EditVehicle::route('/{record}/edit'),
        ];
    }
}
