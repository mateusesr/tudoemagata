<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public function getFeaturedProducts(): Collection
    {
        return Product::query()
            ->with(['category', 'variants', 'images'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();
    }

    public function getActiveProducts(): Collection
    {
        return Product::query()
            ->with(['category', 'variants', 'images'])
            ->where('is_active', true)
            ->latest()
            ->get();
    }

    public function getByCategory(Category $category): Collection
    {
        $categoryIds = $category->children->isNotEmpty()
            ? [$category->id, ...$category->children->pluck('id')]
            : [$category->id];

        return Product::query()
            ->with(['category', 'variants', 'images'])
            ->where('is_active', true)
            ->whereIn('category_id', $categoryIds)
            ->latest()
            ->get();
    }

    public function search(string $term): Collection
    {
        return Product::query()
            ->with(['category', 'variants', 'images'])
            ->where('is_active', true)
            ->where(function ($query) use ($term) {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('short_description', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
            })
            ->latest()
            ->get();
    }

    public function findBySlug(string $slug): ?Product
    {
        return Product::query()
            ->with(['category', 'variants', 'images', 'relatedProducts.variants', 'relatedProducts.images'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();
    }

    public function getCategories(): Collection
    {
        return Category::query()->whereNull('parent_id')->whereHas('products')->get();
    }
}
