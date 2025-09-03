<?php

namespace App\Filament\Resources\Parts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PartForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('sku')
                    ->label(__('app.part').' SKU')
                    ->required(),
                TextInput::make('manufacturer')
                    ->label(__('app.vendor'))
                    ->required(),
                TextInput::make('name')
                    ->label(__('app.part'))
                    ->required(),
                Textarea::make('description')
                    ->label(__('app.notes'))
                    ->columnSpanFull(),
                TextInput::make('category')
                    ->label(__('app.category'))
                    ->required(),
                TextInput::make('unit')
                    ->label(__('app.unit'))
                    ->required()
                    ->default('szt.'),
                TextInput::make('default_price')
                    ->label(__('app.default_price'))
                    ->numeric(),
                TextInput::make('external_url')
                    ->label(__('app.external_url')),
            ]);
    }
}
