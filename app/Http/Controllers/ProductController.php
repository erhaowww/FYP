<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Enums\ProductCategory;
use App\Enums\ProductType;
use App\Enums\ProductColor;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepository;
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function show(Request $request)
    {
        $products = $this->productRepository->allWithFilters($request);

        // Retrieve all enum cases for filters
        $categories = ProductCategory::cases();
        $types = ProductType::cases();
        $colors = ProductColor::cases();

        // Return the view with the products and enums
        return view('user/product', compact('products', 'categories', 'types', 'colors'));
    }

    // ProductController.php
    public function showDetail($id)
    {
        $mainProduct = $this->productRepository->find($id);
        $relatedProducts = $this->productRepository->findRelatedProducts($mainProduct->category, $id);

        // Return the view with the main product and related products
        return view('user/product-detail', [
            'mainProduct' => $mainProduct,
            'relatedProducts' => $relatedProducts,
        ]);
    }


}

