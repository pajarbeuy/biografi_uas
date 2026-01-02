<?php

namespace App\Filament\Widgets;

use App\Models\Biografi;
use App\Models\User;
use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BiografiStatsWidget extends BaseWidget
{
    // Use 2 columns instead of default 4 = bigger cards!
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $pollingInterval = null;
    
    protected function getColumns(): int
    {
        return 2; // 2 cards per row instead of 4 = each card 2x bigger!
    }
    
    protected function getStats(): array
    {
        // Count biografis by status
        $totalBiografis = Biografi::count();
        $draftCount = Biografi::where('status', 'draft')->count();
        $pendingCount = Biografi::where('status', 'pending')->count();
        $approvedCount = Biografi::where('status', 'approved')->count();
        $publishedCount = Biografi::where('status', 'published')->count();
        $rejectedCount = Biografi::where('status', 'rejected')->count();
        
        // Total users
        $totalUsers = User::count();
        
        // Most popular category
        $popularCategory = Category::withCount('biografis')
            ->orderBy('biografis_count', 'desc')
            ->first();
        
        // Extract values to avoid null-safe operator in string interpolation
        $categoryName = $popularCategory?->name ?? 'N/A';
        $categoryCount = $popularCategory?->biografis_count ?? 0;
        
        return [
            Stat::make('Total Users', $totalUsers)
                ->description('Registered users')
                ->descriptionIcon('heroicon-o-users')
                ->color('success')
                ->chart([5,10, 90,50,  100, 20, 15, $totalUsers]),
                
            Stat::make('Total Biografi', $totalBiografis)
                ->description("{$publishedCount} published, {$pendingCount} pending")
                ->descriptionIcon('heroicon-o-document-text')
                ->color('primary')
                ->chart([3, 5, 4, 6, 7, 6, 8]),
                
            Stat::make('Pending Approvals', $pendingCount)
                ->description('Need review')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning')
                ->chart([2, 3, 1, 4, 3, 2, $pendingCount]),
                
            Stat::make('Kategori Terpopuler', $categoryName)
                ->description("{$categoryCount} biografi")
                ->descriptionIcon('heroicon-o-star')
                ->color('info'),

            Stat::make('Biografi Draft', $draftCount)
                ->description('Draft')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('secondary')
                ->chart([2, 3, 1, 4, 3, 2, $draftCount]),
            
            Stat::make('Biografi Rejected', $rejectedCount)
                ->description('Rejected')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger')
                ->chart([2, 3, 1, 4, 3, 2, $rejectedCount]),
        ];
    }
}
