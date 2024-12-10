<?php

namespace App\Filament\Resources\ZamukaResource\Pages;

use App\Filament\Resources\ZamukaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditZamuka extends EditRecord
{
    protected static string $resource = ZamukaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
