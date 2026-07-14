<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    public function __construct(protected ProductRepository $repository) {}

    public function getHomePageData(): array
    {
        return [
            'featured_products' => $this->repository->getFeaturedProducts(),
            'categories' => $this->repository->getCategories(),
        ];
    }

    public function getCatalog(): Collection
    {
        return $this->repository->getActiveProducts();
    }

    public function getByCategory(Category $category): Collection
    {
        return $this->repository->getByCategory($category);
    }

    public function search(string $term): Collection
    {
        return $this->repository->search($term);
    }

    public function getProductBySlug(string $slug): mixed
    {
        return $this->repository->findBySlug($slug);
    }
}
