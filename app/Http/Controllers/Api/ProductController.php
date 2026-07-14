<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'products' => $this->productService->getCatalog(),
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $product = $this->productService->getProductBySlug($slug);

        if (! $product) {
            return response()->json(['message' => 'Produto não encontrado.'], 404);
        }

        return response()->json(['product' => $product]);
    }
}
