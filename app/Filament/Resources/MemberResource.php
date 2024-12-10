<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\Member;
use Exception;
use Filament\Forms\Components\Actions\Action;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $slug = 'members';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Micro Credit Management';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema(static::getMemberInformations())
                            ->columns(2),

                        Section::make('Loan Received')
                            ->headerActions([
                                Action::make('reset')
                                    ->modalHeading('Are you sure?')
                                    ->modalDescription('All existing loan information will be removed from vsla member.')
                                    ->requiresConfirmation()
                                    ->color('danger')
                                    ->action(fn (Set $set) => $set('items', [])),
                            ])
                            ->schema([
                                static::loanPaymanet(),
                            ]),
                    ])
                    ->columnSpan(['lg' => fn (?Member $record) => $record === null ? 3 : 2]),

                Section::make()
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Member $record): ?string => $record->created_at?->diffForHumans()),

                        Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Member $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Member $record) => $record === null),
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
                TextColumn::make('vsla.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('gender')->sortable(),

                TextColumn::make('id_number')->searchable(),

                TextColumn::make('mobile'),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('gender')->options([
                    'male' => 'Male',
                    'female' => 'Female',
                ])->native(false)->label('Choose gender'),
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
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['vsla']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'vsla.name', 'id_number'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->vsla) {
            $details['Vsla'] = $record->vsla->name;
            $details['Id Number'] = $record->id_number;
        }

        return $details;
    }

    private static function getMemberInformations(): array
    {
        return [
            Select::make('vsla_id')
                ->relationship('vsla', 'name')
                ->preload()
                ->label('Select Vsla a member belongs in.')
                ->searchable()
                ->required(),

            TextInput::make('name')
                ->label('Enter both names of member')
                ->required(),

            Select::make('gender')->options([
                'male' => 'Male',
                'female' => 'Female',
            ])->label('Gender')
                ->native(false)
                ->label('Choose gender')
                ->required(),

            TextInput::make('id_number')->unique()
                ->required()
                ->maxLength(16)
                ->minLength(16)
                ->label('National Id'),

            TextInput::make('sector'),

            TextInput::make('cell'),

            TextInput::make('village'),

            TextInput::make('mobile'),
            Select::make('status')->options(['active' => 'Active', 'active_and_transfered' => 'Active And Transfered', 'inactive' => 'Inactive'])->native(false),
            Textarea::make('notes')
                ->label('Some Notes')
                ->placeholder('Give us simple useful information. such as why he/she is transfered etc.')
                ->maxLength(300),
        ];
    }

    private static function loanPaymanet(): Repeater
    {
        return Repeater::make('loans')->relationship()->schema([
            TextInput::make('amount')->numeric()->label('Loan Amount'),

        ]);
    }
}
