<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ToolkitResource\Pages;
use App\Models\Toolkit;
use Exception;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class ToolkitResource extends Resource
{
    protected static ?string $model = Toolkit::class;

    protected static ?string $navigationIcon = 'gameicon-mighty-spanner';

    protected static ?string $navigationLabel = 'Toolkits Beneficiaries';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('gender')
                        ->options([
                            'F' => 'Female',
                            'M' => 'Male',
                        ])->native(false),
                    TextInput::make('identification_number')
                        ->numeric(),
                    TextInput::make('phone_number')->minLength(10)->maxLength(14)
                        ->maxLength(255),
                    Forms\Components\TextInput::make('tvet_attended')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('option')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('level')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('training_intake')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('reception_date')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('toolkit_received')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('toolkit_cost')
                        ->numeric(),
                    Forms\Components\TextInput::make('subsidized_percent')
                        ->numeric(),
                    Forms\Components\TextInput::make('sector')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('total')
                        ->numeric(),
                ])->columns(2),

            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->searchable(),
                Tables\Columns\TextColumn::make('identification_number')
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tvet_attended')
                    ->searchable(),
                Tables\Columns\TextColumn::make('option')
                    ->searchable(),
                Tables\Columns\TextColumn::make('level')
                    ->searchable(),
                Tables\Columns\TextColumn::make('training_intake')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reception_date')
                    ->hidden()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gender')->options([
                    'M' => 'Male',
                    'F' => 'Female',
                ])->native(false),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()->label('Edit Beneficiary')->icon('heroicon-o-pencil'),
                    Tables\Actions\DeleteAction::make()->label('Delete Beneficiary')

                        ->icon('heroicon-o-trash')->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Beneficiary Removed')
                                ->body('Beneficiary deleted successfully.'),
                        ),

                ]),

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
            'index' => Pages\ListToolkits::route('/'),
            'create' => Pages\CreateToolkit::route('/create'),
            'edit' => Pages\EditToolkit::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return $record->name;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'identification_number', 'phone_number'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Id Number' => $record->identification_number,
            'Phone' => $record->phone_number,
            'Sector' => $record->sector,
        ];
    }
}
