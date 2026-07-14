<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Pedidos';

    public static function getModelLabel(): string
    {
        return 'pedido';
    }

    public static function getPluralModelLabel(): string
    {
        return 'pedidos';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Pedido')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->label('Número do pedido')
                            ->disabled(),
                        Forms\Components\Select::make('customer_id')
                            ->label('Cliente')
                            ->relationship('customer.user', 'name')
                            ->disabled(),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pendente',
                                'paid' => 'Pago',
                                'separating' => 'Em separação',
                                'shipped' => 'Enviado',
                                'completed' => 'Concluído',
                                'cancelled' => 'Cancelado',
                            ])
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('grand_total')
                            ->label('Total')
                            ->numeric()
                            ->prefix('R$')
                            ->disabled(),
                    ]),

                Forms\Components\Section::make('Envio')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('shipping_provider')
                            ->label('Transportadora'),
                        Forms\Components\TextInput::make('shipping_service')
                            ->label('Serviço'),
                        Forms\Components\TextInput::make('tracking_code')
                            ->label('Código de rastreio'),
                        Forms\Components\TextInput::make('shipping_deadline_days')
                            ->label('Prazo (dias)')
                            ->numeric(),
                    ]),

                Forms\Components\Section::make('Endereço de entrega')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        Forms\Components\TextInput::make('shipping_recipient_name')
                            ->label('Destinatário')
                            ->disabled(),
                        Forms\Components\TextInput::make('shipping_zip_code')
                            ->label('CEP')
                            ->disabled(),
                        Forms\Components\TextInput::make('shipping_street')
                            ->label('Rua')
                            ->disabled(),
                        Forms\Components\TextInput::make('shipping_number')
                            ->label('Número')
                            ->disabled(),
                        Forms\Components\TextInput::make('shipping_complement')
                            ->label('Complemento')
                            ->disabled(),
                        Forms\Components\TextInput::make('shipping_neighborhood')
                            ->label('Bairro')
                            ->disabled(),
                        Forms\Components\TextInput::make('shipping_city')
                            ->label('Cidade')
                            ->disabled(),
                        Forms\Components\TextInput::make('shipping_state')
                            ->label('UF')
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('Pedido')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer.user.name')
                    ->label('Cliente')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pendente',
                        'paid' => 'Pago',
                        'separating' => 'Em separação',
                        'shipped' => 'Enviado',
                        'completed' => 'Concluído',
                        'cancelled' => 'Cancelado',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'paid', 'completed' => 'success',
                        'cancelled' => 'danger',
                        'pending' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('grand_total')
                    ->label('Total')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tracking_code')
                    ->label('Rastreio'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pendente',
                        'paid' => 'Pago',
                        'separating' => 'Em separação',
                        'shipped' => 'Enviado',
                        'completed' => 'Concluído',
                        'cancelled' => 'Cancelado',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
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
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
