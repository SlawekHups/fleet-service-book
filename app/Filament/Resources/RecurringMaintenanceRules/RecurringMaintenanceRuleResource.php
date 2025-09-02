<?php

namespace App\Filament\Resources\RecurringMaintenanceRules;

use App\Filament\Resources\RecurringMaintenanceRules\Pages\CreateRecurringMaintenanceRule;
use App\Filament\Resources\RecurringMaintenanceRules\Pages\EditRecurringMaintenanceRule;
use App\Filament\Resources\RecurringMaintenanceRules\Pages\ListRecurringMaintenanceRules;
use App\Filament\Resources\RecurringMaintenanceRules\Schemas\RecurringMaintenanceRuleForm;
use App\Filament\Resources\RecurringMaintenanceRules\Tables\RecurringMaintenanceRulesTable;
use App\Models\RecurringMaintenanceRule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RecurringMaintenanceRuleResource extends Resource
{
    protected static ?string $model = RecurringMaintenanceRule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBellAlert;
    protected static ?string $modelLabel = 'Reguła serwisowa';
    protected static ?string $pluralModelLabel = 'Reguły serwisowe';
    protected static string|UnitEnum|null $navigationGroup = 'Reguły';

    public static function form(Schema $schema): Schema
    {
        return RecurringMaintenanceRuleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RecurringMaintenanceRulesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRecurringMaintenanceRules::route('/'),
            'create' => CreateRecurringMaintenanceRule::route('/create'),
            'edit' => EditRecurringMaintenanceRule::route('/{record}/edit'),
        ];
    }
}
