<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\SchoolFeedingResource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestSchoolFeeding extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(SchoolFeedingResource::getEloquentQuery())
            ->defaultPaginationPageOption(10)
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('gender')->sortable(),

                TextColumn::make('grade')->sortable(),

                TextColumn::make('school'),
                TextColumn::make('sector'),
            ])
            ->filters([

            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                    RestoreAction::make(),
                    ForceDeleteAction::make(),
                ]),

            ]);
    }
}
