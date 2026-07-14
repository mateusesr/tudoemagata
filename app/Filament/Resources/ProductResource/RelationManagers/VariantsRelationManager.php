<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class VariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'variants';

    protected static ?string $title = 'Variações / SKUs';

    public static function getModelLabel(): string
    {
        return 'variação';
    }

    public static function getPluralModelLabel(): string
    {
        return 'variações';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome da variação')
                    ->helperText('Ex: "Único", "Pequeno", "Bandeja M - Marrom"')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('sku')
                    ->label('SKU')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->label('Preço')
                    ->numeric()
                    ->prefix('R$')
                    ->required(),
                Forms\Components\TextInput::make('stock_quantity')
                    ->label('Estoque')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->helperText('Para peça única, deixe como 1.'),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Ativo',
                        'inactive' => 'Inativo',
                        'sold_out' => 'Esgotado',
                    ])
                    ->default('active')
                    ->required()
                    ->native(false),
                Forms\Components\TextInput::make('weight_grams')
                    ->label('Peso (g)')
                    ->numeric(),
                Forms\Components\TextInput::make('height_cm')
                    ->label('Altura (cm)')
                    ->numeric(),
                Forms\Components\TextInput::make('width_cm')
                    ->label('Largura (cm)')
                    ->numeric(),
                Forms\Components\TextInput::make('length_cm')
                    ->label('Comprimento (cm)')
                    ->numeric(),
                Forms\Components\TextInput::make('color')
                    ->label('Cor'),
                Forms\Components\TextInput::make('size')
                    ->label('Tamanho'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome'),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Preço')
                    ->money('BRL'),
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->label('Estoque'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Ativo',
                        'inactive' => 'Inativo',
                        'sold_out' => 'Esgotado',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'sold_out' => 'danger',
                        default => 'gray',
                    }),
            ])
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
