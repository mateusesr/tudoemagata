<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(protected ProductService $productService) {}

    public function __invoke(): View
    {
        $data = $this->productService->getHomePageData();

        return view('pages.home', $data);
    }
}
