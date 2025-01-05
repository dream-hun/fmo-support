<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CreditTopUpResource\Pages;
use App\Models\CreditTopUp;
use App\Models\Loan;
use Exception;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CreditTopUpResource extends Resource
{
    protected static ?string $model = CreditTopUp::class;

    protected static ?string $slug = 'vslas-top-ups';
    protected static ?string $navigationLabel='Vslas Top Up';

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Micro Credit Management';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([Group::make()
                ->schema([
                    // Select for VSLA
                    Forms\Components\Select::make('vsla_id')
                        ->relationship('vsla', 'name')
                        ->native(false)
                        ->searchable()
                        ->preload()
                        ->required()
                        ->reactive(),

                    // Select for done_at
                    Forms\Components\Select::make('done_at')
                        ->native(false)
                        ->searchable()
                        ->preload()
                        ->options(function (callable $get) {
                            $vslaId = $get('vsla_id');

                            if (! $vslaId) {
                                return [];
                            }

                            return Loan::query()
                                ->where('vsla_id', $vslaId)
                                ->distinct()
                                ->get(['done_at'])
                                ->mapWithKeys(function ($loan) {
                                    $date = $loan->done_at->format('Y-m-d');

                                    return [
                                        $date => $loan->done_at->format('d M Y'),
                                    ];
                                })
                                ->toArray();
                        })
                        ->reactive()
                        ->afterStateUpdated(function (Forms\Set $set, $state, $get) {
                            if (! $state) {
                                $set('amount', 0);

                                return;
                            }

                            $vslaId = $get('vsla_id');

                            if (! $vslaId) {
                                $set('amount', 0);
                                throw new Exception('VSLA ID is not set or invalid.');
                            }

                            $totalAmount = Loan::query()
                                ->where('vsla_id', $vslaId)
                                ->where('done_at', '=', $state)
                                ->sum('amount');

                            $set('amount', max(0, $totalAmount)); // Ensure amount is non-negative
                        })
                        ->required(),

                    // Amount field
                    TextInput::make('amount')
                        ->numeric()
                        ->readOnly() // Changed from disabled to readOnly
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vsla.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('done_at')
                    ->date()
                    ->sortable(),
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
                //
            ])
            ->actions([

                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCreditTopUps::route('/'),
            'create' => Pages\CreateCreditTopUp::route('/create'),
            'edit' => Pages\EditCreditTopUp::route('/{record}/edit'),
        ];
    }
}
