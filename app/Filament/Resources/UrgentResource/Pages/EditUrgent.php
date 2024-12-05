<?php

namespace App\Filament\Resources\UrgentResource\Pages;

use App\Filament\Resources\UrgentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditUrgent extends EditRecord
{
    protected static string $resource = UrgentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
