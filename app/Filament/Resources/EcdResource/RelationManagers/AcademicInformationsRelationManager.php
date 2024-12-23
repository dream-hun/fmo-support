<?php

namespace App\Filament\Resources\EcdResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AcademicInformationsRelationManager extends RelationManager
{
    protected static string $relationship = 'academicInformations';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('grade')->options([
                    'Baby' => 'Baby',
                    'Middle' => 'Middle',
                    'Top' => 'Top',
                ])->native(false)->placeholder('Choose grade'),
                TextInput::make('academic_year')->required(),
                Select::make('status')->options([
                    'graduate' => 'Graduated',
                    'in-progress' => 'In Progress',
                    'repeater' => 'Repeater',
                ])->native(false)->placeholder('Select status'),
                Textarea::make('comment'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('academic_year')
            ->columns([

                Tables\Columns\TextColumn::make('grade')->sortable(),
                Tables\Columns\TextColumn::make('academic_year')->sortable(),
                Tables\Columns\TextColumn::make('status')->sortable(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
