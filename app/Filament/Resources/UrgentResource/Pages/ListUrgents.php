<?php

namespace App\Filament\Resources\UrgentResource\Pages;

use App\Filament\Resources\UrgentResource;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Excel;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListUrgents extends ListRecords
{
    protected static string $resource = UrgentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ExcelImportAction::make()
                ->color("info")->icon('heroicon-o-arrow-down-on-square-stack'),
            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename(fn ($resource) => $resource::getModelLabel().'-'.date('Y-m-d'))
                        ->withWriterType(Excel::CSV)
                        ->withColumns([
                            Column::make('updated_at'),
                        ]),
                ])->color('success')->icon('heroicon-o-arrow-up-on-square-stack'),
        ];
    }
}
