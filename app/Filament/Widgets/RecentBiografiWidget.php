<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Biografi;

/**
 * Widget Tabel untuk Menampilkan 10 Biografi Terbaru
 * 
 * Widget ini menampilkan tabel dengan 10 biografi yang baru disubmit,
 * dilengkapi dengan informasi:
 * - Nama tokoh
 * - Submitted by (user yang submit)
 * - Kategori matematika
 * - Status (draft/pending/approved/rejected/published)
 * - Tanggal submission
 * 
 * Widget ini membantu admin untuk quick access ke submissions terbaru
 * dan melakukan review dengan cepat.
 */
class RecentBiografiWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    
    protected int | string | array $columnSpan = 'full';

    /**
     * Konfigurasi tabel untuk widget
     * 
     * Method ini mengkonfigurasi:
     * - Query: 10 biografi terbaru dengan relasi user dan category
     * - Columns: Nama, submitted by, category, status, tanggal
     * - Default sort: created_at descending (terbaru di atas)
     * 
     * Tabel menggunakan full width untuk menampilkan semua informasi dengan jelas.
     * 
     * @param Table $table Instance tabel Filament
     * @return Table Tabel yang sudah dikonfigurasi
     */
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Biografi::query()
                    ->with(['user', 'category'])
                    ->latest()
                    ->limit(10)
            )
            ->heading('Recent Biografi Submissions')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Tokoh')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Submitted By')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color('info'),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'secondary' => 'draft',
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'primary' => 'published',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
