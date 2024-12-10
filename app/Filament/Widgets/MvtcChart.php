<?php

namespace App\Filament\Widgets;

use App\Models\Mvtc;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class MvtcChart extends ApexChartWidget
{
    /**
     * Chart Id
     */
    protected static ?string $chartId = 'mvtcChart';

    /**
     * Widget Title
     */
    protected static ?string $heading = 'MVTC Students Registration';

    protected int|string|array $columnSpan = 'full';

    protected static ?string $footer = 'Total MVTC student registered on every intake.';

    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = '10s';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     */
    protected function getOptions(): array
    {
        $data = Mvtc::query()
            ->selectRaw('intake, COUNT(*) as count')
            ->groupBy('intake')
            ->orderBy('intake')
            ->get();

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'data' => $data->pluck('count'),
                    'name' => 'Registered students',

                ],
            ],
            'xaxis' => [
                'categories' => $data->pluck('intake'),
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#b2071b'],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                    'horizontal' => false,
                ],
            ],
        ];
    }
}
