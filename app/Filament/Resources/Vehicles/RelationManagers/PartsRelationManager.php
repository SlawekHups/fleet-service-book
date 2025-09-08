<?php

namespace App\Filament\Resources\Vehicles\RelationManagers;

use Filament\Actions\Action;
use Filament\Tables as Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use App\Models\Part;

class PartsRelationManager extends RelationManager
{
    protected static string $relationship = 'parts';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('recordId')
                ->label('Część')
                ->relationship(name: 'parts', titleAttribute: 'name')
                ->searchable(),
            Toggle::make('preferred')->label('Preferowana'),
            Textarea::make('notes')->label('Notatki'),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                ImageColumn::make('media')
                    ->label('Foto')
                    ->getStateUsing(function ($record) {
                        $url = $record->getFirstMediaUrl('part_photos', 'thumb');
                        if (! $url) {
                            $url = $record->getFirstMediaUrl('part_photos');
                        }
                        return $url ?: null;
                    })
                    ->width(40)
                    ->height(40),
                TextColumn::make('name')->label('Nazwa')->searchable(),
                TextColumn::make('manufacturer')->label('Producent')->searchable(),
                TextColumn::make('sku')->label('SKU')->searchable(),
                IconColumn::make('pivot.preferred')->label('Pref.')->boolean(),
                TextColumn::make('pivot.notes')->label('Notatki')->wrap(),
            ])
            ->headerActions([
                Action::make('attach_part')
                    ->label('Dodaj część')
                    ->form([
                        Select::make('part_id')
                            ->label('Część')
                            ->options(fn () => Part::query()->orderBy('name')->pluck('name','id'))
                            ->searchable()
                            ->required(),
                        Toggle::make('preferred')->label('Preferowana'),
                        Textarea::make('notes')->label('Notatki'),
                    ])
                    ->action(function (array $data) {
                        $vehicle = $this->getOwnerRecord();
                        $partId = (int) $data['part_id'];
                        $attributes = [
                            'preferred' => (bool) ($data['preferred'] ?? false),
                            'notes' => $data['notes'] ?? null,
                        ];

                        $alreadyAttached = $vehicle->parts()->where('parts.id', $partId)->exists();

                        if ($alreadyAttached) {
                            $vehicle->parts()->updateExistingPivot($partId, $attributes);
                        } else {
                            $vehicle->parts()->attach([$partId => $attributes]);
                        }
                    }),
            ])
            ->actions([
                Action::make('edit_pivot')
                    ->label('Edytuj')
                    ->fillForm(function ($record) {
                        return [
                            'preferred' => (bool) ($record->pivot->preferred ?? false),
                            'notes' => $record->pivot->notes ?? null,
                        ];
                    })
                    ->form([
                        Toggle::make('preferred')->label('Preferowana'),
                        Textarea::make('notes')->label('Notatki'),
                    ])
                    ->action(function ($record, array $data) {
                        $this->getOwnerRecord()->parts()->updateExistingPivot($record->id, [
                            'preferred' => (bool) ($data['preferred'] ?? false),
                            'notes' => $data['notes'] ?? null,
                        ]);
                    }),
                Action::make('detach_part')
                    ->label('Odłącz')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $this->getOwnerRecord()->parts()->detach($record->id);
                    }),
            ]);
    }
}


