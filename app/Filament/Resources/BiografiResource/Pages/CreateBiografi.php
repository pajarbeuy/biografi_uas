<?php

namespace App\Filament\Resources\BiografiResource\Pages;

use App\Filament\Resources\BiografiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateBiografi extends CreateRecord
{
    protected static string $resource = BiografiResource::class;

    protected function beforeCreate(): void
    {
        // Validasi ukuran foto sebelum create
        $data = $this->form->getState();
        
        if (!empty($data['image_path'])) {
            $filePath = storage_path('app/public/' . $data['image_path']);
            
            if (file_exists($filePath)) {
                $fileSizeInMB = filesize($filePath) / 1024 / 1024;
                
                if ($fileSizeInMB > 2) {
                    // Hapus file yang terlalu besar
                    @unlink($filePath);
                    
                    // Tampilkan notifikasi error yang bagus
                    Notification::make()
                        ->title('Ukuran Foto Terlalu Besar!')
                        ->body('Ukuran foto maksimal 2MB. File Anda: ' . number_format($fileSizeInMB, 2) . 'MB. Silakan upload foto dengan ukuran lebih kecil.')
                        ->danger()
                        ->duration(8000)
                        ->send();
                    
                    // Stop proses create
                    $this->halt();
                }
            }
        }
    }
}
