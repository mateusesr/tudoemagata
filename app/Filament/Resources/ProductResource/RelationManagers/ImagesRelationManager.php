<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $title = 'Imagens';

    public static function getModelLabel(): string
    {
        return 'imagem';
    }

    public static function getPluralModelLabel(): string
    {
        return 'imagens';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('path')
                    ->label('Imagem')
                    ->image()
                    ->directory('products')
                    ->required(),
                Forms\Components\Select::make('product_variant_id')
                    ->label('Variação (opcional)')
                    ->relationship('variant', 'name'),
                Forms\Components\TextInput::make('alt_text')
                    ->label('Texto alternativo (SEO)')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_primary')
                    ->label('Imagem principal'),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Ordem')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('path')
            ->columns([
                Tables\Columns\ImageColumn::make('path')
                    ->label('Imagem'),
                Tables\Columns\TextColumn::make('variant.name')
                    ->label('Variação'),
                Tables\Columns\TextColumn::make('alt_text')
                    ->label('Alt text'),
                Tables\Columns\IconColumn::make('is_primary')
                    ->label('Principal')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Ordem'),
            ])
            ->defaultSort('sort_order')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
