<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Biografi;
use Illuminate\Support\Facades\DB;

class BiografiChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Biografi Submissions (Last 6 Months)';
    
    protected static ?int $sort = 2;
    
    // Make chart full width
    protected int | string | array $columnSpan = 'full';
    
    // Make chart taller
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // Get biografi count per month for last 6 months
        $data = Biografi::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $counts = [];
        
        foreach ($data as $item) {
            $labels[] = date('M Y', strtotime($item->month . '-01'));
            $counts[] = $item->count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Biografi Submissions',
                    'data' => $counts,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.8)', // Solid blue for bars
                    'borderColor' => 'rgba(0, 95, 248, 1)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Changed from 'line' to 'bar'
    }
}
