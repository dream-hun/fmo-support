<?php

namespace App\Filament\Resources\EcdResource\Pages;

use App\Filament\Resources\EcdResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEcd extends CreateRecord
{
    protected static string $resource = EcdResource::class;

    protected static ?string $title = 'Add New Student';
}
