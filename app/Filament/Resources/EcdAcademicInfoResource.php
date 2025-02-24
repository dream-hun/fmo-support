<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EcdAcademicInfoResource\Pages;
use App\Models\EcdAcademicInfo;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EcdAcademicInfoResource extends Resource
{
    protected static ?string $model = EcdAcademicInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $navigationLabel = 'Academic Information';

    protected static ?string $navigationGroup = 'Ecd Beneficiaries';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('ecd_id')
                    ->label('Names')
                    ->relationship('ecd', 'name')
                    ->required(),
                Forms\Components\TextInput::make('academic_year')
                    ->maxLength(255),
                Forms\Components\TextInput::make('grade')
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->maxLength(255),
                Forms\Components\Textarea::make('comment')
                    ->columnSpanFull(),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ecd.name')
                    ->label('Names')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('academic_year')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('grade')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gender')
                    ->options([
                        'M' => 'Male',
                        'F' => 'Female',
                    ])
                    ->query(function (Builder $query, array $data) {
                        // Only apply the filter if a gender is selected
                        return isset($data['gender']) && $data['gender']
                            ? $query->whereHas('ecd', function ($subQuery) use ($data) {
                                $subQuery->where('gender', $data['gender']);
                            })
                            : $query;
                    }),

                Tables\Filters\Filter::make('academic_year')
                    ->form([
                        Forms\Components\TextInput::make('academic_year'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        // Only apply the filter if an academic year is provided
                        return isset($data['academic_year']) && $data['academic_year']
                            ? $query->where('academic_year', $data['academic_year'])
                            : $query;
                    })->indicateUsing(function (array $data): array {
                        $indicator = [];
                        if ($data['academic_year'] ?? null) {
                            $indicator['academic_year'] = 'Academic year: '.$data['academic_year'];
                        }

                        return $indicator;
                    }),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'graduated' => 'Graduated',
                        'in-progress' => 'In Progress',
                        'repeater' => 'Repeater',
                    ])
                    ->query(function (Builder $query, array $data) {
                        // Only apply the filter if a status is selected
                        return isset($data['status']) && $data['status']
                            ? $query->where('status', $data['status'])
                            : $query;
                    })->native(false),
                Tables\Filters\SelectFilter::make('grade')
                    ->options([
                        'baby' => 'Baby',
                        'middle' => 'Middle',
                        'top' => 'Top',
                    ])->native(false),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEcdAcademicInfos::route('/'),
            'create' => Pages\CreateEcdAcademicInfo::route('/create'),
            'edit' => Pages\EditEcdAcademicInfo::route('/{record}/edit'),
        ];
    }
}
