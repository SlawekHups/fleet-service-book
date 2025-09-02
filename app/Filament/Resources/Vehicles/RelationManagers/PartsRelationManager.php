<?php

namespace App\Filament\Resources\Vehicles\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PartsRelationManager extends RelationManager
{
    protected static string $relationship = 'parts';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('recordId')->relationship(name: 'parts', titleAttribute: 'name')->label('Część')->searchable(),
            Toggle::make('preferred')->label('Preferowana'),
            Textarea::make('notes')->label('Notatki'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Nazwa')->searchable(),
            TextColumn::make('manufacturer')->label('Producent')->searchable(),
            TextColumn::make('sku')->label('SKU')->searchable(),
            IconColumn::make('pivot.preferred')->label('Pref.')->boolean(),
            TextColumn::make('pivot.notes')->label('Notatki')->wrap(),
        ]);
    }
}


