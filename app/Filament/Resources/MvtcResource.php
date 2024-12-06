<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MvtcResource\Pages;
use App\Models\Mvtc;
use Exception;
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
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MvtcResource extends Resource
{
    protected static ?string $model = Mvtc::class;

    protected static ?string $slug = 'mvtc-students';

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    TextInput::make('reg_no'),

                    TextInput::make('name')
                        ->required(),

                    TextInput::make('gender'),

                    TextInput::make('dob'),

                    TextInput::make('student_id'),

                    TextInput::make('student_contact'),

                    TextInput::make('trade'),

                    TextInput::make('resident_district'),

                    TextInput::make('sector'),

                    TextInput::make('cell'),

                    TextInput::make('village'),

                    TextInput::make('education_level'),

                    TextInput::make('scholar_type'),

                    TextInput::make('intake'),
                    TextInput::make('graduation_date'),

                    TextInput::make('status'),

                    Placeholder::make('created_at')
                        ->label('Created Date')
                        ->content(fn (?Mvtc $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                    Placeholder::make('updated_at')
                        ->label('Last Modified Date')
                        ->content(fn (?Mvtc $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                ])->columns(3)]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reg_no'),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('gender'),
                TextColumn::make('trade')->sortable(),
                TextColumn::make('scholar_type')->sortable(),
                TextColumn::make('intake'),
                TextColumn::make('status')->sortable(),
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
            'index' => Pages\ListMvtcs::route('/'),
            'create' => Pages\CreateMvtc::route('/create'),
            'edit' => Pages\EditMvtc::route('/{record}/edit'),
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
        return ['name', 'student_id', 'student_contact'];
    }

    public static function getGlobalSearchResultTitle(Model $record): Htmlable|string
    {
        return $record->name;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'National Id' => $record->student_id,
            'Contact' => $record->student_contact,
        ];
    }
}
