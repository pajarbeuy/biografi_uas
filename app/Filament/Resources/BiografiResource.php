<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BiografiResource\Pages;
use App\Filament\Resources\BiografiResource\RelationManagers;
use App\Models\Biografi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BiografiResource extends Resource
{
    protected static ?string $model = Biografi::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'Biografi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Tokoh')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(Biografi::class, 'slug', ignoreRecord: true)
                    ->disabled()
                    ->dehydrated(),
                
                Forms\Components\TextInput::make('birth_place')
                    ->label('Tempat Lahir')
                    ->nullable()
                    ->maxLength(255),
                
                Forms\Components\Textarea::make('education')
                    ->label('Pendidikan')
                    ->nullable()
                    ->rows(4)
                    ->placeholder('Contoh: S1 Matematika di Universitas Göttingen (1799)')
                    ->columnSpanFull(),
                
                Forms\Components\DatePicker::make('birth_date')
                    ->label('Tanggal Lahir')
                    ->nullable()
                    ->displayFormat('d/m/Y'),
                
                Forms\Components\DatePicker::make('death_date')
                    ->label('Tanggal Meninggal')
                    ->nullable()
                    ->displayFormat('d/m/Y')
                    ->after('birth_date'),
                
                Forms\Components\Select::make('category_id')
                    ->label('Cabang Matematika')
                    ->relationship('category', 'name')
                    ->nullable()
                    ->searchable()
                    ->preload(),
                
                Forms\Components\Textarea::make('achievements')
                    ->label('Prestasi')
                    ->nullable()
                    ->rows(4)
                    ->columnSpanFull(),
                
                Forms\Components\RichEditor::make('life_story')
                    ->label('Kisah Hidup')
                    ->required()
                    ->columnSpanFull(),
                
                Forms\Components\Repeater::make('references')
                    ->relationship('references')
                    ->label('Referensi atau Sumber')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Referensi')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('author')
                            ->label('Penulis')
                            ->nullable(),
                        Forms\Components\TextInput::make('year')
                            ->label('Tahun')
                            ->nullable()
                            ->maxLength(4),
                        Forms\Components\TextInput::make('url')
                            ->label('URL')
                            ->url()
                            ->nullable()
                            ->columnSpanFull(),
                        Forms\Components\Select::make('type')
                            ->label('Tipe')
                            ->options([
                                'website' => 'Website',
                                'book' => 'Buku',
                                'paper' => 'Paper/Jurnal',
                                'article' => 'Artikel',
                                'other' => 'Lainnya',
                            ])
                            ->default('website')
                            ->required(),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->cloneable()
                    ->columnSpanFull()
                    ->defaultItems(0),
                
                Forms\Components\FileUpload::make('image_path')
                    ->label('Foto Tokoh')
                    ->disk('public')
                    ->directory('biografi-images')
                    ->visibility('public')
                    ->image()
                    ->imagePreviewHeight('200')  // Optimal preview height
                    ->maxSize(2048)  // Max 2MB to prevent large file issues
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                    ->getUploadedFileNameForStorageUsing(function ($file, $get) {
                        // Get slug from form state
                        $slug = $get('slug');
                        
                        // If slug is empty (shouldn't happen due to auto-generation), use original name
                        if (empty($slug)) {
                            $slug = \Illuminate\Support\Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                        }
                        
                        // Get file extension
                        $extension = $file->getClientOriginalExtension();
                        
                        // Return formatted filename: slug.extension
                        return "{$slug}.{$extension}";
                    })
                    ->previewable(false)  // Disable preview to fix loading issue
                    ->downloadable()
                    ->openable()
                    ->nullable(),
                
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'pending' => 'Pending Review',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'published' => 'Published',
                    ])
                    ->default('draft')
                    ->required()
                    ->helperText('Draft: Belum selesai | Pending: Menunggu review | Approved: Disetujui | Rejected: Ditolak | Published: Dipublikasikan'),
                
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Tokoh')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('birth_place')
                    ->label('Tempat Lahir')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->label('Tanggal Lahir')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Cabang Matematika')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Dibuat Oleh')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'secondary' => 'draft',
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'primary' => 'published',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'draft' => 'Draft',
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'published' => 'Published',
                        default => $state,
                    })
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Foto')
                    ->getStateUsing(function ($record) {
                        if (!$record->image_path) {
                            return null;
                        }
                        return asset('storage/' . $record->image_path);
                    })
                    ->square()
                    ->size(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'pending' => 'Pending Review',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'published' => 'Published',
                    ]),
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('Kategori'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->approve())
                    ->visible(fn ($record) => in_array($record->status, ['pending', 'draft'])),
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->reject())
                    ->visible(fn ($record) => $record->status === 'pending'),
                Tables\Actions\Action::make('publish')
                    ->label('Publish')
                    ->icon('heroicon-o-globe-alt')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->publish())
                    ->visible(fn ($record) => $record->status === 'approved'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('approve')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->approve();
                            }
                        }),
                    Tables\Actions\BulkAction::make('reject')
                        ->label('Reject Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->reject();
                            }
                        }),
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-globe-alt')
                        ->color('primary')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->publish();
                            }
                        }),
                ]),
            ])
            ->defaultPaginationPageOption(5) // Default 10 items per halaman
            ->paginationPageOptions([5, 10, 25, 50, 100]); // Options yang bisa dipilih
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
            'index' => Pages\ListBiografis::route('/'),
            'create' => Pages\CreateBiografi::route('/create'),
            'edit' => Pages\EditBiografi::route('/{record}/edit'),
        ];
    }
}
