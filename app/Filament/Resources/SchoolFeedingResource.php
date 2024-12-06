<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchoolFeedingResource\Pages;
use App\Models\SchoolFeeding;
use Exception;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
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
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SchoolFeedingResource extends Resource
{
    protected static ?string $model = SchoolFeeding::class;

    protected static ?string $navigationLabel = 'School Feeding';

    protected static ?string $slug = 'school-feeding';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'phosphor-student-fill';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make()
                        ->schema(static::getStudentInformations())
                        ->columns(2),

                    Section::make('Support Given')
                        ->headerActions([
                            Action::make('reset')
                                ->modalHeading('Are you sure?')
                                ->modalDescription('All existing support will be removed from the beneficiary.')
                                ->requiresConfirmation()
                                ->color('danger')
                                ->action(fn (Set $set) => $set('schoolFeedingPayments', [])),
                        ])->schema([static::getSupportRepeater()]),
                ])->columnSpan(['md' => fn (?SchoolFeeding $record) => $record === null ? 3 : 2]),
                Section::make('Data change Information')->schema([
                    Placeholder::make('created_at')
                        ->label('Created Date')
                        ->content(fn (?SchoolFeeding $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                    Placeholder::make('updated_at')
                        ->label('Last Modified Date')
                        ->content(fn (?SchoolFeeding $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                ])->columnSpan(['lg' => 1])
                    ->hidden(fn (?SchoolFeeding $record) => $record === null),

            ])->columns(3);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
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
                TrashedFilter::make(),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
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
            'index' => Pages\ListSchoolFeedings::route('/'),
            'create' => Pages\CreateSchoolFeeding::route('/create'),
            'edit' => Pages\EditSchoolFeeding::route('/{record}/edit'),
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
        return ['name', 'sector', 'cell', 'school'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'School' => $record->school,
            'Sector' => $record->sector,
            'Cell' => $record->cell,
        ];
    }

    private static function getStudentInformations(): array
    {
        return [
            TextInput::make('name')
                ->required(),

            TextInput::make('grade'),

            TextInput::make('school')
                ->required(),

            TextInput::make('district')
                ->required(),

            TextInput::make('sector'),

            TextInput::make('cell'),

            TextInput::make('village'),

            TextInput::make('father_name'),

            TextInput::make('mother_name'),
            Select::make('gender')->options([
                'M' => 'Male',
                'F' => 'Female',
            ])->native(false),
        ];
    }

    private static function getSupportRepeater(): Repeater
    {
        return Repeater::make('schoolFeedingPayments')
            ->relationship()->schema([
                TextInput::make('academic_year')->required(),
                Select::make('trimester')->options([
                    '1' => 'Trimester I',
                    '2' => 'Trimester II',
                    '3' => 'Trimester III',
                ])->required()->native(false),
                TextInput::make('amount')->required()->default(19000)->numeric(),
                Select::make('status')->default('pending')->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                ])->native(false),

            ])->columns(2);
    }
}
