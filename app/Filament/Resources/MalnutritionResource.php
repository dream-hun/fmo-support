<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MalnutritionResource\Pages;
use App\Models\Malnutrition;
use Exception;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
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
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MalnutritionResource extends Resource
{
    protected static ?string $model = Malnutrition::class;

    protected static ?string $slug = 'malnutrition-control';
    protected static ?string $navigationLabel = "Malnutrition Control";

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([Group::make()
                ->schema([
                    Section::make()
                        ->schema(static::getBeneficiaryInformations())
                        ->columns(2),

                    Section::make('Malnutrition Support')
                        ->headerActions([
                            Action::make('reset')
                                ->modalHeading('Are you sure?')
                                ->modalDescription('All existing support will be removed from the beneficiary.')
                                ->requiresConfirmation()
                                ->color('danger')
                                ->action(fn (Set $set) => $set('malnutritionSupports', [])),
                        ])
                        ->schema([
                            static::getSupportDetails(),
                        ]),
                ])
                ->columnSpan(['lg' => fn (?Malnutrition $record) => $record === null ? 3 : 2]),

                Section::make()
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Malnutrition $record): ?string => $record->created_at?->diffForHumans()),

                        Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Malnutrition $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Malnutrition $record) => $record === null),
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

                TextColumn::make('gender'),
                TextColumn::make('associated_health_center')->label('Health Center'),

                TextColumn::make('entry_muac'),

                TextColumn::make('current_muac'),

                TextColumn::make('status'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
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
            'index' => Pages\ListMalnutritions::route('/'),
            'create' => Pages\CreateMalnutrition::route('/create'),
            'edit' => Pages\EditMalnutrition::route('/{record}/edit'),
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
        return ['name', 'father_name', 'mother_name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return $record->name;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Names' => $record->name,
            'Current MUAC' => $record->current_muac,
            'Current Nutrition Color' => $record->status,
        ];
    }

    private static function getBeneficiaryInformations(): array
    {
        return [
            TextInput::make('name')
                ->required(),

            Select::make('gender')->options([
                'M' => 'Male',
                'F' => 'Female',
            ])->native(false)->required(),

            TextInput::make('age_or_months'),

            TextInput::make('associated_health_center')
                ->required(),

            TextInput::make('sector'),

            TextInput::make('cell'),

            TextInput::make('village'),

            TextInput::make('father_name'),

            TextInput::make('mother_name'),

            TextInput::make('home_phone_number'),

            TextInput::make('entry_muac')
                ->required(),

            TextInput::make('current_muac')
                ->required(),

            TextInput::make('status')
                ->required(),

        ];
    }

    private static function getSupportDetails(): Repeater
    {
        return Repeater::make('malnutritionSupports')->relationship()->schema([
            DatePicker::make('package_reception_date')->required()->native(false)->maxDate(now()),

        ]);
    }
}
