<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Biografi;
use Illuminate\Support\Facades\DB;

/**
 * Widget Chart untuk Biografi Submissions Timeline
 * 
 * Widget ini menampilkan bar chart yang menunjukkan jumlah
 * biografi yang disubmit dalam 6 bulan terakhir.
 * 
 * Chart membantu admin untuk:
 * - Melihat trend submissions dari waktu ke waktu
 * - Mengidentifikasi bulan dengan aktivitas tinggi/rendah
 * - Monitoring user engagement
 * 
 * Chart menggunakan full width dan tinggi 300px untuk visibility optimal.
 */
class BiografiChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Biografi Submissions (Last 6 Months)';
    
    protected static ?int $sort = 2;
    
    // Make chart full width
    protected int | string | array $columnSpan = 'full';
    
    // Make chart taller
    protected static ?string $maxHeight = '300px';

    /**
     * Mendapatkan data untuk chart
     * 
     * Method ini:
     * 1. Query database untuk menghitung jumlah biografi per bulan (6 bulan terakhir)
     * 2. Group by bulan menggunakan DATE_FORMAT
     * 3. Format data menjadi array labels dan counts
     * 4. Return dalam format Chart.js dataset
     * 
     * @return array Array dengan 'datasets' dan 'labels' untuk Chart.js
     */
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

    /**
     * Mendapatkan tipe chart
     * 
     * Menggunakan 'bar' chart untuk better visualization dari data diskrit (per bulan).
     * Bar chart lebih mudah dibaca dibanding line chart untuk data monthly.
     * 
     * @return string Tipe chart ('bar')
     */
    protected function getType(): string
    {
        return 'bar'; // Changed from 'line' to 'bar'
    }
}
