<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardStatsWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getHeaderWidgets(): array
    {
        return [
            DashboardStatsWidget::class,
        ];
    }
}
