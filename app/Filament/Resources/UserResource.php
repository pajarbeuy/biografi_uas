<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * Resource untuk Manajemen User
 * 
 * Resource ini hanya dapat diakses oleh SUPERADMIN.
 * Digunakan untuk mengelola semua user dalam sistem dengan fitur:
 * - CRUD user (Create, Read, Update, Delete)
 * - Atur role user (user/admin/superadmin)
 * - Password handling yang aman (optional saat edit)
 * 
 * Navigation item otomatis hidden untuk non-superadmin
 * menggunakan method shouldRegisterNavigation().
 */
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'User Management';
    
    protected static ?int $navigationSort = 1;

    /**
     * Tentukan apakah navigation item harus ditampilkan
     * 
     * Resource ini hanya muncul di sidebar untuk SUPERADMIN.
     * Admin biasa tidak dapat melihat atau mengakses user management.
     * 
     * @return bool True jika user adalah superadmin
     */
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
    }

    /**
     * Form untuk create/edit user
     * 
     * Form fields:
     * - Name: Required, max 255 char
     * - Email: Required, email format, unique
     * - Password: 
     *   - Required saat CREATE
     *   - Optional saat EDIT (kosongkan jika tidak ingin ubah)
     *   - Dehydrated only jika diisi
     * - Role: Dropdown (user/admin/superadmin), required
     * 
     * @param Form $form Instance form Filament
     * @return Form Form yang sudah dikonfigurasi
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(User::class, 'email', ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->maxLength(255)
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(fn ($state) => filled($state))
                    ->helperText(fn (string $operation): ?string => 
                        $operation === 'edit' ? 'Kosongkan jika tidak ingin mengubah password' : null
                    ),
                Forms\Components\Select::make('role')
                    ->options([
                        'user' => 'User',
                        'admin' => 'Admin',
                        'superadmin' => 'Super Admin',
                    ])
                    ->required(),
            ]);
    }

    /**
     * Tabel untuk list semua user
     * 
     * Columns:
     * - Name: Searchable, sortable
     * - Email: Searchable, sortable
     * - Role: Badge dengan color coding
     *   - Red (danger): superadmin
     *   - Yellow (warning): admin
     *   - Blue (info): user
     * - Created_at & Updated_at: Toggleable, default hidden
     * 
     * Actions:
     * - Edit: Untuk update user
     * - Delete: Bulk delete dengan konfirmasi
     * 
     * @param Table $table Instance tabel Filament
     * @return Table Tabel yang sudah dikonfigurasi
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('role')
                    ->colors([
                        'danger' => 'superadmin',
                        'warning' => 'admin',
                        'info' => 'user',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
