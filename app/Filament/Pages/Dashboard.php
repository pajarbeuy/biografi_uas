<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\BiografiStatsWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getHeaderWidgets(): array
    {
        return [
            BiografiStatsWidget::class,
        ];
    }
    
    public function getFooterWidgets(): array
    {
        return [
            \App\Filament\Widgets\BiografiChartWidget::class,
            \App\Filament\Widgets\RecentBiografiWidget::class,
        ];
    }
}
