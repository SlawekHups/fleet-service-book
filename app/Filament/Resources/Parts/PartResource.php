<?php

namespace App\Filament\Resources\Parts;

use App\Filament\Resources\Parts\Pages\CreatePart;
use App\Filament\Resources\Parts\Pages\EditPart;
use App\Filament\Resources\Parts\Pages\ListParts;
use App\Filament\Resources\Parts\Schemas\PartForm;
use App\Filament\Resources\Parts\Tables\PartsTable;
use App\Models\Part;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PartResource extends Resource
{
    protected static ?string $model = Part::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;
    protected static ?string $modelLabel = 'Część';
    protected static ?string $pluralModelLabel = 'Części';
    protected static string|UnitEnum|null $navigationGroup = 'Części';

    public static function form(Schema $schema): Schema
    {
        return PartForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PartsTable::configure($table);
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
            'index' => ListParts::route('/'),
            'create' => CreatePart::route('/create'),
            'edit' => EditPart::route('/{record}/edit'),
        ];
    }
}
