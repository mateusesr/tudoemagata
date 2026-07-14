<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    public function __construct(protected ProductRepository $repository)
    {
    }

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

    public function getProductBySlug(string $slug): mixed
    {
        return $this->repository->findBySlug($slug);
    }
}
