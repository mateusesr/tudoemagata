<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'price',
        'stock_quantity',
        'weight_grams',
        'height_cm',
        'width_cm',
        'length_cm',
        'color',
        'size',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'weight_grams' => 'integer',
        'height_cm' => 'integer',
        'width_cm' => 'integer',
        'length_cm' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(InventoryReservation::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function activeReservedQuantity(): int
    {
        return $this->reservations()
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->sum('quantity');
    }

    public function availableQuantity(): int
    {
        return max(0, $this->stock_quantity - $this->activeReservedQuantity());
    }
}
