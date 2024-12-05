<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ZamukaResource\Pages;
use App\Models\Zamuka;
use Exception;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ZamukaResource extends Resource
{
    protected static ?string $model = Zamuka::class;

    protected static ?string $slug = 'zamukas';

    protected static ?string $navigationGroup = 'Zamuka Beneficiaries';

    protected static ?string $navigationLabel = 'Beneficiaries';

    protected static ?string $recordTitleAttribute = 'head_of_household_name';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
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

                    Placeholder::make('created_at')
                        ->label('Created Date')
                        ->content(fn (?Zamuka $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                    Placeholder::make('updated_at')
                        ->label('Last Modified Date')
                        ->content(fn (?Zamuka $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                ])->columns(3), ]);
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
}
