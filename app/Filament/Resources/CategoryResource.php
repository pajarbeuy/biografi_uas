<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * Resource untuk Manajemen Kategori Matematika
 * 
 * Resource ini hanya dapat diakses oleh SUPERADMIN.
 * Digunakan untuk mengelola kategori cabang matematika seperti:
 * - Aljabar
 * - Geometri
 * - Kalkulus
 * - Statistika
 * - dll.
 * 
 * Kategori digunakan untuk mengklasifikasikan tokoh matematikawan
 * berdasarkan bidang keahlian utama mereka.
 */
class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Kategori';

    /**
     * Tentukan apakah navigation item harus ditampilkan
     * 
     * Resource ini hanya muncul di sidebar untuk SUPERADMIN.
     * 
     * @return bool True jika user adalah superadmin
     */
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
    }

    /**
     * Form untuk create/edit kategori
     * 
     * Form fields:
     * - Name: Nama kategori (required, max 255)
     * - Slug: URL-friendly identifier (required, unique, max 255)
     * - Description: Deskripsi kategori (optional, textarea full width)
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
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(Category::class, 'slug', ignoreRecord: true),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }

    /**
     * Tabel untuk list semua kategori
     * 
     * Columns:
     * - Name: Nama kategori (searchable, sortable)
     * - Slug: URL identifier (searchable, sortable)
     * - Created_at & Updated_at: Toggleable, default hidden
     * 
     * Actions:
     * - Edit: Update kategori
     * - Delete: Bulk delete
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
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
