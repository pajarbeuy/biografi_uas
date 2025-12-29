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
                
                Forms\Components\FileUpload::make('image_path')
                    ->label('Foto Tokoh')
                    ->disk('public')
                    ->visibility('public')
                    ->image()
                    ->imageEditor()
                    ->nullable(),
                
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ])
                    ->default('draft')
                    ->required(),
                
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
                        'danger' => 'draft',
                        'success' => 'published',
                    ])
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Foto')
                    ->disk('public')
                    ->square()
                    ->size(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
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
            'index' => Pages\ListBiografis::route('/'),
            'create' => Pages\CreateBiografi::route('/create'),
            'edit' => Pages\EditBiografi::route('/{record}/edit'),
        ];
    }
}
