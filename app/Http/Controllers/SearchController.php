<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __construct(protected ProductService $productService) {}

    public function __invoke(Request $request): View
    {
        $term = trim((string) $request->query('q', ''));

        $products = $term !== '' ? $this->productService->search($term) : collect();

        return view('pages.search', [
            'term' => $term,
            'products' => $products,
        ]);
    }
}
