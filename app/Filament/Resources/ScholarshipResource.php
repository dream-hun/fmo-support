<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScholarshipResource\Pages;
use App\Models\Scholarship;
use Exception;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
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

class ScholarshipResource extends Resource
{
    protected static ?string $model = Scholarship::class;

    protected static ?string $slug = 'scholarships';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([Group::make()
                ->schema([
                    Section::make()
                        ->schema(static::getStudentInformations())
                        ->columns(3),

                    Section::make('Scholarship Support')
                        ->headerActions([
                            Action::make('reset')
                                ->modalHeading('Are you sure?')
                                ->modalDescription('All existing support will be removed from the beneficiary.')
                                ->requiresConfirmation()
                                ->color('danger')
                                ->action(fn (Set $set) => $set('', [])),
                        ])
                        ->schema([
                            static::getScholarshipSupport(),
                        ]),
                ])
                ->columnSpan(['lg' => fn (?Scholarship $record) => $record === null ? 3 : 2]),

                Section::make()
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Scholarship $record): ?string => $record->created_at?->diffForHumans()),

                        Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Scholarship $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Scholarship $record) => $record === null),
            ])
            ->columns(3);

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
                TextColumn::make('national_id_number')->searchable(),
                TextColumn::make('telephone')->searchable(),
                TextColumn::make('university_attended')->sortable(),
                TextColumn::make('year_of_entrance')->sortable(),
                TextColumn::make('status'),
            ])
            ->filters([
                TrashedFilter::make(),

            ])
            ->actions([ActionGroup::make([
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
            'index' => Pages\ListScholarships::route('/'),
            'create' => Pages\CreateScholarship::route('/create'),
            'edit' => Pages\EditScholarship::route('/{record}/edit'),
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
        return ['name', 'telephone', 'university_attended', 'national_id_number'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Name' => $record->name,
            'University' => $record->university_attended,
            'Contact' => $record->telephone,
        ];
    }

    private static function getStudentInformations(): array
    {
        return [
            TextInput::make('name')
                ->required(),

            Select::make('gender')->options([
                'M' => 'Male',
                'F' => 'Female',
            ])->native(false)->required(),

            TextInput::make('national_id_number')
                ->integer()
                ->minLength(16)
                ->maxLength(16)
                ->required(),

            TextInput::make('district')
                ->default('Bugesera')
                ->required(),

            TextInput::make('sector')
                ->required(),

            TextInput::make('cell')
                ->required(),

            TextInput::make('village')
                ->required(),

            TextInput::make('telephone')
                ->required(),

            TextInput::make('email')
                ->required(),

            TextInput::make('university_attended')
                ->required(),

            TextInput::make('faculty')
                ->required(),

            TextInput::make('program_duration')
                ->default('4 Years')
                ->required(),

            TextInput::make('year_of_entrance')
                ->required(),

            TextInput::make('intake')
                ->required(),

            TextInput::make('school_contact')
                ->required(),

            Select::make('status')
                ->options([
                    'Inprogress' => 'In Progress',
                    'Graduated' => 'Graduated',
                    'Dropped-out' => 'Dropped out',
                ])->native(false)
                ->default('In Progress')
                ->required(),

        ];
    }

    private static function getScholarshipSupport(): Repeater
    {
        return Repeater::make('scholarshipSupports')->relationship()->schema([
            TextInput::make('academic_year'),
            Select::make('support')->options([
                'tuition' => 'Tuition Fees',
                'internship' => 'Internship Fees',
            ])->multiple()->native(false)->required(),
            RichEditor::make('comment')->maxLength(600),
        ]);
    }
}
