<?php

namespace App\Filament\Resources\EcdResource\Pages;

use App\Filament\Resources\EcdResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditEcd extends EditRecord
{
    protected static string $resource = EcdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
