<?php

namespace App\Filament\Resources\SchoolFeedingResource\Pages;

use App\Filament\Resources\SchoolFeedingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSchoolFeeding extends CreateRecord
{
    protected static string $resource = SchoolFeedingResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
