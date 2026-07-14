<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ProductRepository
{
    public function getFeaturedProducts(): Collection
    {
        return Product::query()
            ->with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();
    }

    public function getActiveProducts(): Collection
    {
        return Product::query()
            ->with('category')
            ->where('is_active', true)
            ->latest()
            ->get();
    }

    public function findBySlug(string $slug): ?Product
    {
        return Product::query()
            ->with(['category', 'variants'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();
    }

    public function getCategories(): Collection
    {
        return Category::query()->whereHas('products')->get();
    }
}
