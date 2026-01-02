<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageService
{
    protected $manager;
    
    public function __construct()
    {
        // Create ImageManager with GD driver
        $this->manager = new ImageManager(new Driver());
    }
    
    /**
     * Compress and store an uploaded image
     * 
     * @param UploadedFile $file
     * @param string $directory
     * @param int $maxWidth
     * @param int $quality
     * @return string Path to stored image
     */
    public function compressAndStore(UploadedFile $file, string $directory = '', int $maxWidth = 1200, int $quality = 80): string
    {
        // Validate file is image
        if (!$file->isValid() || !str_starts_with($file->getMimeType(), 'image/')) {
            throw new \Exception('Invalid image file');
        }
        
        // Read image
        $image = $this->manager->read($file->getRealPath());
        
        // Resize if too large (maintain aspect ratio)
        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }
        
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.webp';
        $path = $directory ? $directory . '/' . $filename : $filename;
        
        // Encode to WebP format with compression
        $encoded = $image->toWebp($quality);
        
        // Store in public disk
        Storage::disk('public')->put($path, $encoded);
        
        return $path;
    }
    
    /**
     * Delete an image from storage
     * 
     * @param string $path
     * @return bool
     */
    public function delete(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        
        return false;
    }
}
