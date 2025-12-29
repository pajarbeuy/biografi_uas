<?php

namespace App\Filament\Resources\BiografiResource\Pages;

use App\Filament\Resources\BiografiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBiografis extends ListRecords
{
    protected static string $resource = BiografiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
