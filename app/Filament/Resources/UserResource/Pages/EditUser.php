<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Jika password kosong, hapus dari data untuk tidak mengupdate field password
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            // Jika password diisi, hash password sebelum disimpan
            $data['password'] = bcrypt($data['password']);
        }

        return $data;
    }
}
