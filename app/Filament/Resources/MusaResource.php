<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MusaResource\Pages;
use App\Models\Musa;
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
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MusaResource extends Resource
{
    protected static ?string $model = Musa::class;

    protected static ?string $slug = 'health-insurance';

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

                TextColumn::make('district'),

                TextColumn::make('sector'),

                TextColumn::make('cell'),

                TextColumn::make('village'),
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
        return [];
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
