<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\BiografiStatsWidget;
use Filament\Pages\Dashboard as BaseDashboard;

/**
 * Halaman Dashboard Custom untuk Filament Admin Panel
 * 
 * Dashboard ini menampilkan berbagai widget untuk monitoring dan statistik:
 * - Header: Widget statistik biografi
 * - Footer: Chart submissions dan tabel biografi terbaru
 * 
 * Dashboard ini menggunakan full-width layout untuk menampilkan
 * informasi secara maksimal kepada admin/superadmin.
 */
class Dashboard extends BaseDashboard
{
    /**
     * Mendapatkan widget yang ditampilkan di header dashboard
     * 
     * Widget di header menampilkan statistik overview seperti:
     * - Total users
     * - Total biografi
     * - Pending approvals
     * - Kategori terpopuler
     * 
     * @return array Array of widget classes
     */
    public function getHeaderWidgets(): array
    {
        return [
            BiografiStatsWidget::class,
        ];
    }
    
    /**
     * Mendapatkan widget yang ditampilkan di footer dashboard
     * 
     * Widget di footer menampilkan:
     * - Chart biografi submissions (6 bulan terakhir)
     * - Tabel 10 biografi terbaru dengan detail status
     * 
     * @return array Array of widget classes
     */
    public function getFooterWidgets(): array
    {
        return [
            \App\Filament\Widgets\BiografiChartWidget::class,
            \App\Filament\Widgets\RecentBiografiWidget::class,
        ];
    }
}
