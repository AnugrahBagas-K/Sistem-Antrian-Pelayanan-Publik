<?php

namespace App\Filament\Widgets;

use App\Models\Instansi;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class AntrianChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'antrianChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Total Antrian';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected int|string|array $columnSpan = 'full';

    protected function getOptions(): array
    {
        $datainstansi = Instansi::withCount('antrian')
        ->orderByDesc('antrian_count')->get();
        return [
            'chart' => [
                'type' => 'bar',
                'height' => 200,
            ],
            'series' => [
                [
                    'name' => 'BasicBarChart',
                    'data' => $datainstansi->pluck('antrian_count')->toArray(),
                ],
            ],
            'xaxis' => [
                'categories' => $datainstansi->pluck('instansi')->toArray(),
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
                    'horizontal' => true,
                ],
            ],
        ];
    }
}
