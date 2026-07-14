<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Produtos';

    public static function getModelLabel(): string
    {
        return 'produto';
    }

    public static function getPluralModelLabel(): string
    {
        return 'produtos';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações principais')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Categoria')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('type')
                            ->label('Tipo de produto')
                            ->options([
                                'standard' => 'Padrão (imagem ilustrativa)',
                                'variant' => 'Com variação (SKU)',
                                'unique' => 'Peça única',
                                'kit' => 'Kit / conjunto',
                            ])
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpan(2),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Destaque'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Ativo')
                            ->default(true),
                    ]),

                Forms\Components\Section::make('Descrição')
                    ->schema([
                        Forms\Components\Textarea::make('short_description')
                            ->label('Descrição curta')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->label('Descrição completa')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('SEO')
                    ->collapsed()
                    ->schema([
                        Forms\Components\TextInput::make('seo_title')
                            ->label('Título SEO')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('seo_description')
                            ->label('Descrição SEO')
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoria')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'standard' => 'Padrão',
                        'variant' => 'Com variação',
                        'unique' => 'Peça única',
                        'kit' => 'Kit',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('variants_count')
                    ->label('Variações')
                    ->counts('variants'),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Destaque')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'standard' => 'Padrão',
                        'variant' => 'Com variação',
                        'unique' => 'Peça única',
                        'kit' => 'Kit',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Ativo'),
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
            RelationManagers\VariantsRelationManager::class,
            RelationManagers\ImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
