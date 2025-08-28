<?php

namespace App\Filament\Widgets;

use App\Models\Antrian;
use App\Models\Instansi;
use App\Models\Layanan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $instansi = Instansi::count();
        $layanan = Layanan::count();
        $antrian = Antrian::count();

        $topinstansi = Instansi::withCount('antrian')
        ->orderByDesc('antrian_count')->first();

        return [
            Stat::make('Jumlah Instansi', $instansi),
            Stat::make('Jumlah Layanan', $layanan),
            Stat::make('Total Antrian', $antrian),
            
        ];
    }
}
