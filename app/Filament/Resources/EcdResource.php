<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EcdResource\Pages;
use App\Models\Ecd;
use Exception;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class EcdResource extends Resource
{
    protected static ?string $model = Ecd::class;

    protected static ?string $slug = 'early-childhood-beneficiaries';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Ecd Beneficiaries';

    protected static bool $isGloballySearchable = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([Group::make()
                ->schema([
                    Section::make()
                        ->schema(static::getBeneficiaryInformation())
                        ->columns(3),

                    Section::make('Academic Information')
                        ->headerActions([
                            Action::make('reset')
                                ->modalHeading('Are you sure?')
                                ->modalDescription('All existing support will be removed from the beneficiary.')
                                ->requiresConfirmation()
                                ->color('danger')
                                ->action(fn (Set $set) => $set('academicInformations', [])),
                        ])
                        ->schema([
                            static::getEducationInformation(),
                        ]),
                ])
                ->columnSpan(['lg' => fn (?Ecd $record) => $record === null ? 3 : 2]),

                Section::make()
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Ecd $record): ?string => $record->created_at?->diffForHumans()),

                        Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Ecd $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Ecd $record) => $record === null),
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

                TextColumn::make('grade')->searchable()->sortable(),

                TextColumn::make('gender')->searchable()->sortable(),

                TextColumn::make('academic_year')->searchable()->sortable(),

                TextColumn::make('father_id_number')->searchable(),

            ])
            ->filters([
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListEcds::route('/'),
            'create' => Pages\CreateEcd::route('/create'),
            'view' => Pages\ViewEcd::route('/{record}'),
            'edit' => Pages\EditEcd::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'ecdAcademicInfos.academic_year', 'father_name', 'mother_name', 'father_id_number'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [

            'Father' => $record->father_name,
            'Mother' => $record->mother_name,
        ];
    }

    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return EcdResource::getUrl('edit', ['record' => $record]);
    }

    private static function getBeneficiaryInformation(): array
    {
        return [
            TextInput::make('name')
                ->required(),

            Select::make('gender')->options([
                'M' => 'Male',
                'F' => 'Female',
            ])->native(false)->placeholder('Choose gender'),

            DatePicker::make('birthday')->native(false)->maxDate(now()),
            TextInput::make('district')->default('Bugesera'),

            TextInput::make('sector'),

            TextInput::make('cell'),

            TextInput::make('village'),

            TextInput::make('father_id_number'),

            TextInput::make('mother_name'),

            TextInput::make('home_phone_number'),

            TextInput::make('father_name'),
        ];
    }

    private static function getEducationInformation(): Repeater
    {
        return Repeater::make('academicInformations')->relationship()->schema([
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
}
