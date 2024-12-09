<?php

namespace App\Filament\Widgets;

use App\Models\Mvtc;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class MvtcChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'mvtcChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'MVTC Students Registration';

    protected static ?string $footer = 'Total MVTC student registered on every intake.';
    protected static ?string $pollingInterval = '10s';


    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
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
                    'data'=>$data->pluck('count'),
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
            'colors' => ['#f59e0b'],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                    'horizontal' => false,
                ],
            ],
        ];
    }
}