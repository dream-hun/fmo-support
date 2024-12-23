<?php

namespace App\Filament\Resources\EcdResource\Pages;

use App\Filament\Resources\EcdResource;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Excel;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListEcds extends ListRecords
{
    protected static string $resource = EcdResource::class;

    protected static ?string $title = 'ECD Beneficiaries';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add new student'),
            ExcelImportAction::make()
                ->color('info')->icon('heroicon-o-arrow-down-on-square-stack'),
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

    protected function getHeaderWidgets(): array
    {
        return EcdResource::getWidgets();
    }
}
