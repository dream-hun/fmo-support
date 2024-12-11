<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VslaResource\Pages;
use App\Filament\Resources\VslaResource\RelationManagers\CreditTopUpsRelationManager;
use App\Models\Vsla;
use Exception;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
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

class VslaResource extends Resource
{
    protected static ?string $model = Vsla::class;

    protected static ?string $slug = 'vslas';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Micro Credit Management';

    protected static ?string $navigationIcon = 'ri-organization-chart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema(static::getVslaInformation())
                            ->columns(2),

                    ])
                    ->columnSpan(['lg' => fn (?Vsla $record) => $record === null ? 3 : 2]),

                Section::make()
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Vsla $record): ?string => $record->created_at?->diffForHumans()),

                        Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Vsla $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Vsla $record) => $record === null),
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

                TextColumn::make('representative_phone'),

                TextColumn::make('sector')->searchable()->sortable(),

                TextColumn::make('entrance_year'),

                TextColumn::make('mou_sign_date'),
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
            'index' => Pages\ListVslas::route('/'),
            'create' => Pages\CreateVsla::route('/create'),
            'edit' => Pages\EditVsla::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            CreditTopUpsRelationManager::class,
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
        return ['name', 'representative_name', 'representative_phone'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Representative name' => $record->name,
            'Sector' => $record->sector,
        ];
    }

    private static function getVslaInformation(): array
    {
        return [
            TextInput::make('code')
                ->required(),

            TextInput::make('name')
                ->required(),

            TextInput::make('representative_name')
                ->required(),

            TextInput::make('representative_id')
                ->required(),

            TextInput::make('representative_phone'),

            TextInput::make('sector'),

            TextInput::make('cell'),

            TextInput::make('village'),

            TextInput::make('entrance_year')
                ->required(),

            TextInput::make('mou_sign_date'),
        ];
    }
}
