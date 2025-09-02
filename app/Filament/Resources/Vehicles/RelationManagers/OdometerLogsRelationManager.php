<?php

namespace App\Filament\Resources\Vehicles\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OdometerLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'odometerLogs';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            DatePicker::make('date')->label('Data')->required(),
            TextInput::make('value_km')->label('Przebieg [km]')->numeric()->required(),
            Select::make('source')->label('Źródło')->options([
                'manual' => 'Ręcznie',
                'service' => 'Serwis',
                'import' => 'Import',
            ])->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('date')->date()->label('Data')->sortable(),
            TextColumn::make('value_km')->label('Przebieg [km]')->numeric(),
            TextColumn::make('source')->label('Źródło'),
        ]);
    }
}


