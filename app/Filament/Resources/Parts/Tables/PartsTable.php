<?php

namespace App\Filament\Resources\Parts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PartsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('media')
                    ->label('Zdjęcie')
                    ->getStateUsing(function ($record) {
                        $url = $record->getFirstMediaUrl('part_photos', 'thumb');
                        if (! $url) {
                            $url = $record->getFirstMediaUrl('part_photos');
                        }
                        return $url ?: null;
                    })
                    ->circular()
                    ->width(40)
                    ->height(40),
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                TextColumn::make('manufacturer')
                    ->label('Producent')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nazwa')
                    ->searchable(),
                TextColumn::make('category')
                    ->label('Kategoria')
                    ->searchable(),
                TextColumn::make('unit')
                    ->label('Jednostka')
                    ->searchable(),
                TextColumn::make('default_price')
                    ->label('Cena domyślna')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('external_url')
                    ->label('Link zewnętrzny')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
