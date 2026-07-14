<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\ProductService;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(protected ProductService $productService) {}

    public function show(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = $this->productService->getByCategory($category);

        return view('pages.category', [
            'category' => $category,
            'products' => $products,
        ]);
    }
}
