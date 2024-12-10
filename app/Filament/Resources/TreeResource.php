<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TreeResource\Pages;
use App\Models\Tree;
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

class TreeResource extends Resource
{
    protected static ?string $model = Tree::class;

    protected static ?string $slug = 'fruit-trees';

    protected static ?string $navigationLabel = 'Fruits Trees';

    protected static ?string $navigationIcon = 'ri-tree-fill';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make()->schema(static::getBeneficiaryInformations())->columns(2),
                    Section::make('Support Given')
                        ->headerActions([
                            Action::make('reset')
                                ->modalHeading('Are you sure?')
                                ->modalDescription('All existing support will be removed from the beneficiary.')
                                ->requiresConfirmation()
                                ->color('danger')
                                ->action(fn (Set $set) => $set('supports', [])),
                        ])->schema([static::getTreeInformations()]),
                ])->columnSpan(['md' => fn (?Tree $record) => $record === null ? 3 : 2]),
                Section::make('Data changes Info')
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Data recorded at')
                            ->content(fn (Tree $record): ?string => $record->created_at?->diffForHumans()),

                        Placeholder::make('updated_at')
                            ->label('Last Updated at')
                            ->content(fn (Tree $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Tree $record) => $record === null),
            ])
            ->columns(3);
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

                TextColumn::make('gender')->sortable(),

                TextColumn::make('national_id_number')->label('ID Number'),

                TextColumn::make('phone'),
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
            'index' => Pages\ListTrees::route('/'),
            'create' => Pages\CreateTree::route('/create'),
            'edit' => Pages\EditTree::route('/{record}/edit'),
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
        return ['name', 'national_id_number', 'phone'];
    }

    private static function getBeneficiaryInformations(): array
    {
        return [
            TextInput::make('name')
                ->required(),

            Select::make('gender')->options([
                'M' => 'Male',
                'F' => 'Female',
            ])->native(false),

            TextInput::make('national_id_number')->minLength(16)->maxLength(16)->unique(),

            TextInput::make('sector'),

            TextInput::make('cell'),

            TextInput::make('village'),

            TextInput::make('phone'),

        ];
    }

    private static function getTreeInformations(): Repeater
    {
        return Repeater::make('treeSupports')->relationship()->schema([
            TextInput::make('avocadoes')->numeric(),
            TextInput::make('mangoes')->numeric(),
            TextInput::make('oranges')->numeric(),
            TextInput::make('papaya')->numeric(),
        ]);
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Name' => $record->name,
            'Id number' => $record->national_id_number,
            'Phone' => $record->phone,
        ];
    }
}
