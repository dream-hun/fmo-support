<?php

namespace App\Filament\Resources\MvtcResource\Pages;

use App\Filament\Resources\MvtcResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditMvtc extends EditRecord
{
    protected static string $resource = MvtcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
