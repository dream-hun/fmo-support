<?php

namespace App\Filament\Resources\EcdResource\Pages;

use App\Filament\Resources\EcdResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEcd extends EditRecord
{
    protected static string $resource = EcdResource::class;

    protected static ?string $title = 'Update Information';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
