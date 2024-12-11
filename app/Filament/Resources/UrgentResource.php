<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UrgentResource\Pages;
use App\Models\Urgent;
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

class UrgentResource extends Resource
{
    protected static ?string $model = Urgent::class;

    protected static ?string $slug = 'urgent-community-supports';

    protected static ?string $navigationLabel = 'Urgent Community Supports';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make()->schema(
                        static::getBeneficiaryInformationSchema())->columns(2),
                    Section::make('Support Received')
                        ->headerActions([
                            Action::make('reset')
                                ->modalHeading('Are you sure?')
                                ->modalDescription('All existing items will be removed from the order.')
                                ->requiresConfirmation()
                                ->color('danger')
                                ->action(fn (Set $set) => $set('items', [])),
                        ])
                        ->schema([
                            static::getSupportReceived()->columns(2),
                        ]),
                ])
                    ->columnSpan(['lg' => fn (?Urgent $record) => $record === null ? 3 : 2]),

                Section::make()
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Urgent $record): ?string => $record->created_at?->diffForHumans()),

                        Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Urgent $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Urgent $record) => $record === null),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('national_id_number'),

                TextColumn::make('district'),

                TextColumn::make('sector'),

                TextColumn::make('cell'),

                TextColumn::make('village'),

                TextColumn::make('phone_number'),
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
            'index' => Pages\ListUrgents::route('/'),
            'create' => Pages\CreateUrgent::route('/create'),
            'edit' => Pages\EditUrgent::route('/{record}/edit'),
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
        return ['name', 'national_id_number'];
    }

    public static function getBeneficiaryInformationSchema(): array
    {
        return [
            TextInput::make('name')
                ->required(),

            TextInput::make('national_id_number'),

            TextInput::make('district'),

            TextInput::make('sector'),

            TextInput::make('cell'),

            TextInput::make('village'),

            TextInput::make('phone_number')
                ->required(),
        ];
    }

    public static function getSupportReceived(): Repeater
    {
        return Repeater::make('supports')
            ->relationship()->schema([
                Select::make('support_received')
                    ->options([
                        'Food support' => 'Food Support',
                        'Medical Support' => 'Medical Support',
                        'Housing Material Support' => 'Housing Material Support',
                        'other-support' => 'Other Support',

                    ])->native(false),
                DatePicker::make('done_at')->native(false)->displayFormat('d/m/Y')->maxDate(now()),
                Textarea::make('notes')->maxLength(600)->columnSpanFull(),
            ]);

    }
}
