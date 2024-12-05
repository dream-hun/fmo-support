<?php

namespace App\Filament\Resources\SchoolFeedingResource\Pages;

use App\Filament\Resources\SchoolFeedingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSchoolFeedings extends ListRecords
{
    protected static string $resource = SchoolFeedingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
