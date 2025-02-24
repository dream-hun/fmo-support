<?php

namespace App\Filament\Resources\EcdAcademicInfoResource\Pages;

use App\Filament\Resources\EcdAcademicInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEcdAcademicInfo extends EditRecord
{
    protected static string $resource = EcdAcademicInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
