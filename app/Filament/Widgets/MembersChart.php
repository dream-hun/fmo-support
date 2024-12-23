<?php

namespace App\Filament\Widgets;

use App\Models\Vsla;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class MembersChart extends ApexChartWidget
{
    /**
     * Chart Id
     */
    protected static ?string $chartId = 'vslaMemberChart';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected static ?string $footer = 'Vslas with their total number of members.';

    /**
     * Widget Title
     */
    protected static ?string $heading = 'VSLA Members Chart';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     */
    protected function getOptions(): array
    {
        $data = Vsla::withCount('members')->get();

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Total Members',
                    'data' => $data->pluck('members_count')->toArray(),
                ],
            ],
            'xaxis' => [
                'categories' => $data->pluck('name')->toArray(),
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
