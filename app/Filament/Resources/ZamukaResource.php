<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ZamukaResource\Pages;
use App\Models\Zamuka;
use Exception;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
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

class ZamukaResource extends Resource
{
    protected static ?string $model = Zamuka::class;

    protected static ?string $slug = 'zamuka-beneficiaries';

    protected static ?string $navigationLabel = 'Zamuka Beneficiaries';

    protected static ?string $recordTitleAttribute = 'head_of_household_name';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make()
                        ->schema(static::getBeneficiaryInformations())
                        ->columns(2),

                    Section::make('Support Given')
                        ->headerActions([
                            Action::make('reset')
                                ->modalHeading('Are you sure?')
                                ->modalDescription('All existing support will be removed from the beneficiary.')
                                ->requiresConfirmation()
                                ->color('danger')
                                ->action(fn (Set $set) => $set('zamukaSupports', [])),
                        ])->schema([static::getBeneficiarySupport()]),
                ])->columnSpan(['md' => fn (?Zamuka $record) => $record === null ? 3 : 2]),
                Section::make('Data change Information')->schema([
                    Placeholder::make('created_at')
                        ->label('Created Date')
                        ->content(fn (?Zamuka $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                    Placeholder::make('updated_at')
                        ->label('Last Modified Date')
                        ->content(fn (?Zamuka $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                ])->columnSpan(['lg' => 1])
                    ->hidden(fn (?Zamuka $record) => $record === null),

            ])->columns(3);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('head_of_household_name'),

                TextColumn::make('household_id_number'),

                TextColumn::make('spouse_name'),

                TextColumn::make('spouse_id_number'),

                TextColumn::make('sector'),

                TextColumn::make('cell'),

                TextColumn::make('village'),

                TextColumn::make('house_hold_phone'),

                TextColumn::make('family_size'),

                TextColumn::make('main_source_of_income'),

                TextColumn::make('entrance_year'),
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
            'index' => Pages\ListZamukas::route('/'),
            'create' => Pages\CreateZamuka::route('/create'),
            'edit' => Pages\EditZamuka::route('/{record}/edit'),
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
            'head_of_household_name',
            'household_id_number',
            'house_hold_phone',
        ];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'House Hold Id' => $record->household_id_number,
            'Contact' => $record->house_hold_phone ?? 'Not Available',
        ];
    }

    private static function getBeneficiaryInformations(): array
    {
        return [
            TextInput::make('head_of_household_name')
                ->required(),

            TextInput::make('household_id_number')
                ->integer(),

            TextInput::make('spouse_name'),

            TextInput::make('spouse_id_number')
                ->integer(),

            TextInput::make('sector'),

            TextInput::make('cell'),

            TextInput::make('village'),

            TextInput::make('house_hold_phone'),

            TextInput::make('family_size')
                ->integer(),

            TextInput::make('main_source_of_income'),

            TextInput::make('entrance_year')
                ->required(),

        ];
    }

    private static function getBeneficiarySupport(): Repeater
    {
        return Repeater::make('zamukaSupports')->relationship()->schema([
            CheckboxList::make('support_given')->options([
                'house' => '<span class="text-blue-500">House</span>',
                'equipments' => '<span class="text-green-500">Home Equipments</span>',
                'bicycle' => '<span class="text-red-500">Bicycle</span>',
                'cowshed' => '<span class="text-pink-500">Cowshed</span>',
                'cow' => '<span class="text-pink-500">Cow</span>',
                'goats' => '<span class="text-pink-500">Goat</span>',
                'furnitures' => '<span class="text-pink-500">Furnitures</span>',
                'school-feeding' => '<span class="text-pink-500">School Feeding Kids</span>',
                'food' => '<span class="text-pink-500">Food Support</span>',
            ])->columns(2)
                ->searchable()
                ->allowHtml(),
            Textarea::make('notes'),
        ]);
    }
}
