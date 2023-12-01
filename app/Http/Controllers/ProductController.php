<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Enums\ProductCategory;
use App\Enums\ProductType;
use App\Enums\ProductColor;
use App\Enums\CartItemStatus;
use Illuminate\Support\Facades\Log;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\CartItemRepositoryInterface;
use App\Repositories\Interfaces\CommentRepositoryInterface;
class ProductController extends Controller
{
    protected $productRepository;
    protected $cartItemRepository;
    protected $commentmRepository;

    public function __construct(ProductRepositoryInterface $productRepository,CartItemRepositoryInterface $cartItemRepository, CommentRepositoryInterface $commentmRepository)
    {
        $this->productRepository = $productRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->commentmRepository = $commentmRepository;
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
        $relatedProducts = $this->productRepository->findRelatedProducts($mainProduct->productType,$mainProduct->category, $id);
        $comments = $this->commentmRepository->allCommentByProductId($id);
        $totalReviews = count($comments);

        // Return the view with the main product and related products
        return view('user/product-detail', [
            'mainProduct' => $mainProduct,
            'relatedProducts' => $relatedProducts,
            'comments' => $comments,
            'totalReviews' => $totalReviews,
        ]);
    }

    public function checkStock(Request $request) {
        Log::info('Checking stock with request data:', $request->all());
    
        // Split cartItemIds string into an array
        $cartItemIds = explode('|', $request->input('cartItemIds', ''));
        $isInStock = true;
    
        // Retrieve cart items including associated products
        $cartItems = $this->cartItemRepository->getByIds($cartItemIds, CartItemStatus::inCart->value);
        Log::info('Retrieved cart items:', ['cartItems' => $cartItems]);
    
        foreach ($cartItems as $cartItem) {
            // Log each cart item and its associated product
            Log::info('Cart Item:', ['cartItem' => $cartItem]);
    
            // Check if product is deleted
            if ($cartItem->product->deleted) {
                Log::info('Product is deleted', ['productId' => $cartItem->productId]);
                $isInStock = false;
                break;
            }
    
            // Parse and log the stock information
            $stockInfo = $this->parseStockInfo($cartItem->product->color, $cartItem->product->size, $cartItem->product->stock);
            Log::info('Parsed stock info', ['stockInfo' => $stockInfo]);
    
            // Check if stock is sufficient
            if (!$this->isStockSufficient($stockInfo, $cartItem->color, $cartItem->size, $cartItem->quantity)) {
                Log::info('Stock insufficient', ['product' => $cartItem->product->id, 'requested' => ['color' => $cartItem->color, 'size' => $cartItem->size, 'quantity' => $cartItem->quantity]]);
                $isInStock = false;
                break;
            }
        }
    
        // Log the final result of the stock check
        Log::info('Stock check result', ['inStock' => $isInStock]);
        return response()->json(['success' => true, 'inStock' => $isInStock]);
    }
    
    protected function parseStockInfo($colors, $sizes, $stocks) {
        $colorArray = explode('|', $colors);
        $sizeArray = array_map('explode', array_fill(0, count($colorArray), ','), explode('|', $sizes));
        $stockArray = array_map('explode', array_fill(0, count($colorArray), ','), explode('|', $stocks));
    
        $stockInfo = [];
        foreach ($colorArray as $colorIndex => $color) {
            foreach ($sizeArray[$colorIndex] as $sizeIndex => $size) {
                $stockInfo[$color][$size] = $stockArray[$colorIndex][$sizeIndex];
            }
        }
        return $stockInfo;
    }
    
    protected function isStockSufficient($stockInfo, $color, $size, $quantity) {
        return isset($stockInfo[$color][$size]) && $stockInfo[$color][$size] >= $quantity;
    }

}

