<?php

namespace App\Filament\Resources\VslaResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CreditTopUpsRelationManager extends RelationManager
{
    protected static string $relationship = 'creditTopUps';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('done_at')
            ->columns([
                Tables\Columns\TextColumn::make('amount'),
                Tables\Columns\TextColumn::make('done_at'),
            ])
            ->filters([
                //
            ]);
    }
}
