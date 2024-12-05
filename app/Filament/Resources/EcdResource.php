<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EcdResource\Pages;
use App\Models\Ecd;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EcdResource extends Resource
{
    protected static ?string $model = Ecd::class;

    protected static ?string $slug = 'ecds';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Ecd Management';

    protected static bool $isGloballySearchable = true;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()
                    ->description()
                    ->schema([

                        TextInput::make('name')
                            ->required(),

                        Select::make('grade')->options([
                            'Baby' => 'Baby',
                            'Middle' => 'Middle',
                            'Top' => 'Top',
                        ])->native(false)->placeholder('Choose grade'),

                        Select::make('gender')->options([
                            'M' => 'Male',
                            'F' => 'Female',
                        ])->native(false)->placeholder('Choose gender'),

                        TextInput::make('birthday'),

                        TextInput::make('academic_year'),

                        TextInput::make('district')->default('Bugesera'),

                        TextInput::make('sector'),

                        TextInput::make('cell'),

                        TextInput::make('village'),

                        TextInput::make('father_id_number'),

                        TextInput::make('mother_name'),

                        TextInput::make('home_phone_number'),

                        TextInput::make('father_name'),

                        Placeholder::make('created_at')
                            ->label('Created Date')
                            ->content(fn (?Ecd $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                        Placeholder::make('updated_at')
                            ->label('Last Modified Date')
                            ->content(fn (?Ecd $record): string => $record?->updated_at?->diffForHumans() ?? '-'),

                    ])->columns(3),

            ]);
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('grade')->searchable()->sortable(),

                TextColumn::make('gender')->searchable()->sortable(),

                TextColumn::make('academic_year')->searchable()->sortable(),

                TextColumn::make('home_phone_number'),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('grade')->options([
                    'Baby' => 'Baby',
                    'Middle' => 'Middle',
                    'Top' => 'Top',
                ])->native(false)->placeholder('Select grade'),
                SelectFilter::make('gender')->options([
                    'M' => 'Male',
                    'F' => 'Female',
                ])->native(false)->placeholder('Select gender'),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()->successNotification(Notification::make()->success()->title('Beneficiary updated')->body('Beneficiary Information has been updated')),
                    DeleteAction::make(),
                    RestoreAction::make(),
                    ForceDeleteAction::make(),
                ]),

            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEcds::route('/'),
            'create' => Pages\CreateEcd::route('/create'),
            'edit' => Pages\EditEcd::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'grade', 'academic_year'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Grade' => $record->grade,
            'Academic Year' => $record->academic_year,
        ];
    }
}
