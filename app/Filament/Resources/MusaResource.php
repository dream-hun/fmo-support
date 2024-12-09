<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MusaResource\Pages;
use App\Models\Musa;
use Carbon\Carbon;
use Exception;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MusaResource extends Resource
{
    protected static ?string $model = Musa::class;

    protected static ?string $slug = 'health-insurance';

    protected static ?string $recordTitleAttribute = 'head_of_family_name';

    protected static ?string $navigationLabel = 'Health Insurance';

    protected static ?string $navigationIcon = 'phosphor-users-light';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make()->schema(static::getBeneficiaryInformationSchema())->columns(2),
                    Section::make('Support Given')
                        ->headerActions([
                            Action::make('reset')
                                ->modalHeading('Are you sure?')
                                ->modalDescription('All existing support will be removed from the beneficiary.')
                                ->requiresConfirmation()
                                ->color('danger')
                                ->action(fn (Set $set) => $set('supports', [])),
                        ])->schema([static::getSupportRepeater()]),
                ])->columnSpan(['md' => fn (?Musa $record) => $record === null ? 3 : 2]),
                Section::make()
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Musa $record): ?string => $record->created_at?->diffForHumans()),

                        Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Musa $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Musa $record) => $record === null),
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
                TextColumn::make('head_of_family_name'),

                TextColumn::make('national_id'),

                TextColumn::make('total_family_members'),
            ])
            ->filters([
                TrashedFilter::make(),
                Filter::make('date_of_support')
                    ->form([
                        DatePicker::make('start_date')
                            ->placeholder(fn ($state): string => 'Start Date'),
                        DatePicker::make('end_date')
                            ->placeholder(fn ($state): string => 'End Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->whereHas('supports', function (Builder $subQuery) use ($data) {
                            $subQuery
                                ->when(
                                    $data['start_date'] ?? null,
                                    fn (Builder $q, $date): Builder => $q->whereDate('date_of_support', '>=', $date)
                                )
                                ->when(
                                    $data['end_date'] ?? null,
                                    fn (Builder $q, $date): Builder => $q->whereDate('date_of_support', '<=', $date)
                                );
                        });
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['start_date'] ?? null) {
                            $indicators['start_date'] = 'Support from ' . Carbon::parse($data['start_date'])->toFormattedDateString();
                        }
                        if ($data['end_date'] ?? null) {
                            $indicators['end_date'] = 'Support until ' . Carbon::parse($data['end_date'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
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
            'index' => Pages\ListMusas::route('/'),
            'create' => Pages\CreateMusa::route('/create'),
            'edit' => Pages\EditMusa::route('/{record}/edit'),
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
        return [
            'head_of_family_name', 'national_id',
        ];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Names' => $record->head_of_family_name,
            'National Id' => $record->national_id,
        ];
    }

    public static function getBeneficiaryInformationSchema(): array
    {
        return [
            TextInput::make('head_of_family_name')
                ->required(),

            TextInput::make('national_id')
                ->required(),

            TextInput::make('total_family_members')
                ->required()
                ->integer(),

            TextInput::make('district'),

            TextInput::make('sector'),

            TextInput::make('cell'),

            TextInput::make('village'),
        ];
    }

    public static function getSupportRepeater()
    {
        return Repeater::make('supports')
            ->relationship()->schema([
                TextInput::make('support_given')
                    ->required()
                    ->integer(),

                DatePicker::make('date_of_support'),

            ]);
    }
}