<?php

namespace App\Filament\Resources\SchoolFeedingResource\Pages;

use App\Filament\Resources\SchoolFeedingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditSchoolFeeding extends EditRecord
{
    protected static string $resource = SchoolFeedingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
