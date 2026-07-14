<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService) {}

    public function show(string $slug): View
    {
        $product = $this->productService->getProductBySlug($slug);

        abort_if(! $product, Response::HTTP_NOT_FOUND);

        return view('pages.product', [
            'product' => $product,
        ]);
    }
}
