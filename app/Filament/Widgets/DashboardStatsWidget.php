<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Biografi;
use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalUsers = User::count();
        $totalBiografi = Biografi::count();
        $publishedBiografi = Biografi::where('status', 'published')->count();
        $draftBiografi = Biografi::where('status', 'draft')->count();
        $totalKategori = Category::count();

        return [
            Stat::make('Total Users', $totalUsers)
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
            Stat::make('Total Biografi', $totalBiografi)
                ->description('All biographies')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
            Stat::make('Published', $publishedBiografi)
                ->description('Published biographies')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Draft', $draftBiografi)
                ->description('Draft biographies')
                ->descriptionIcon('heroicon-m-document-duplicate')
                ->color('warning'),
            Stat::make('Total Kategori', $totalKategori)
                ->description('Categories available')
                ->descriptionIcon('heroicon-m-tag')
                ->color('danger'),
        ];
    }
}
