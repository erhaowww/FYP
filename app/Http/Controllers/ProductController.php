<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Enums\ProductCategory;
use App\Enums\ProductType;
use App\Enums\ProductColor;
use App\Enums\ProductSize;
use App\Enums\CartItemStatus;
use Illuminate\Support\Facades\Log;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\CartItemRepositoryInterface;

use App\Models\Product;
class ProductController extends Controller
{
    protected $productRepository;
    protected $cartItemRepository;
    public function __construct(ProductRepositoryInterface $productRepository,CartItemRepositoryInterface $cartItemRepository)
    {
        $this->productRepository = $productRepository;
        $this->cartItemRepository = $cartItemRepository;
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

        // Return the view with the main product and related products
        return view('user/product-detail', [
            'mainProduct' => $mainProduct,
            'relatedProducts' => $relatedProducts,
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

    public function displayAllProduct() {
        $products = $this->productRepository->getAll();
        return view('/admin/all-product', [
            'products' => $products,
        ]);
    }

    public function create()
    {
        $productTypes = ProductType::cases();
        $categories = ProductCategory::cases();
        $colors = ProductColor::cases();
        $sizes = ProductSize::cases();
        return view('/admin/add-product', compact('productTypes', 'categories','colors', 'sizes'));
    }

    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'productName' => 'required|max:255',
            'productType' => 'required',
            'category' => 'required',
            'productDesc' => 'required|max:255',
            'productPrice' => 'required',
            'color' => 'required|array',
            'size' => 'required|array',
            'stock' => 'required|array',
        ]);
        $validatedData['productPrice'] = str_replace(['RM', ' '], '', $validatedData['productPrice']);

        $sizeCounts = json_decode($request->input('sizeCountData'), true);
        if (is_null($sizeCounts)) {
            $sizeCounts = [1 => 1];
        }
        $sizes = $validatedData['size'];
        $stocks = $validatedData['stock'];
        $sizeString = '';
        $stockString = '';
        $currentIndex = 0;

        foreach ($sizeCounts as $colorId => $count) {
            $sizesForColor = array_slice($sizes, $currentIndex, $count);
            $stocksForColor = array_slice($stocks, $currentIndex, $count);

            list($sortedSizesForColor, $sortedStocksForColor) = $this->sortSizesAndStocks($sizesForColor, $stocksForColor);

            $sizeString .= ($sizeString === '' ? '' : '|') . implode(',', $sortedSizesForColor);
            $stockString .= ($stockString === '' ? '' : '|') . implode(',', $sortedStocksForColor);

            $currentIndex += $count;
        }

        $qrFileName  = '';
        $images = array();
        if ($files = $request->input('filepond')) {
            foreach ($files as $file) {
                $json_string = json_decode($file, true);
                $data_column = $json_string['data'];
                $image = base64_decode($data_column);
                $imageName = time() . '_' . $json_string['name']; // timestamp_imageName
                file_put_contents('../public/user/images/product/'.$imageName, $image);
                $images[] = $imageName;
            }
            $product_image = implode("|", $images);
        }

        if ($modelFile = $request->input('productModel')) {
            $json_string = json_decode($modelFile, true);
            $data_column = $json_string['data'];

            $model = base64_decode($data_column);
            $modelName = time() . '_' . $json_string['name']; // timestamp_imageName
            file_put_contents('../public/user/images/product/'.$modelName, $model);
            $product_image .= '|' . $modelName;
        }

        // Handle virtual try-on QR upload
        if ($qrFile = $request->input('virtualTryOnQR')) {
            $json_string = json_decode($qrFile, true);
            $data_column = $json_string['data'];

            $qr = base64_decode($data_column);
            $qrName = time() . '_QR_' . $json_string['name']; // timestamp_QR_imageName
            file_put_contents('../public/user/images/product/'.$qrName, $qr);
            $qrFileName = $qrName; 
        }

        $productData = [
            'productName' => $validatedData['productName'],
            'productType' => $validatedData['productType'],
            'category' => $validatedData['category'],
            'productDesc' => $validatedData['productDesc'],
            'price' => $validatedData['productPrice'],
            'color' => implode('|', $validatedData['color']),
            'size' => $sizeString,
            'stock' => $stockString,
            'productImgObj' => $product_image, 
            'productTryOnQR' => $qrFileName,
            'deleted'=>0,
        ];
        $this->productRepository->create($productData);
        return redirect()->route('all-products')->with('success', 'Product processed successfully.');
    }

    private function sortSizesAndStocks(array $sizes, array $stocks)
    {
        $sizeOrder = [ProductSize::S->value, ProductSize::M->value, ProductSize::L->value, ProductSize::XL->value, ProductSize::XXL->value];
        
        // Combine sizes and stocks into an array of pairs
        $combined = array_map(null, $sizes, $stocks);
        
        // Sort the combined array based on the size order
        usort($combined, function($a, $b) use ($sizeOrder) {
            return array_search($a[0], $sizeOrder) - array_search($b[0], $sizeOrder);
        });

        // Separate the sorted sizes and stocks
        $sortedSizes = array_column($combined, 0);
        $sortedStocks = array_column($combined, 1);

        return [$sortedSizes, $sortedStocks];
    }

    public function edit($id)
    {
        $product = $this->productRepository->find($id);
        $allColors = explode('|', $product->color);
        $allSizes = explode('|', $product->size);
        $allStocks = explode('|', $product->stock);

        $sizeCount = [];
        foreach ($allSizes as $index => $sizesForColor) {
            $sizesArray = explode(',', $sizesForColor);
            $sizeCount[$index + 1] = count($sizesArray);
    
            $allSizes[$index] = $sizesArray;
            $allStocks[$index] = explode(',', $allStocks[$index]);
        }
        Log::info('Processed product details:', [
            'colors' => $allColors,
            'sizes' => $allSizes,
            'stocks' => $allStocks,
            'sizeCount' => $sizeCount
        ]);
        $productTypes = ProductType::cases();
        $categories = ProductCategory::cases();
        $colors = ProductColor::cases();
        $sizes = ProductSize::cases();
        return view('/admin/edit-product', compact('productTypes', 'categories','colors', 'sizes','product', 'sizeCount','allColors','allSizes','allStocks'));
    }

    public function update(Request $request, $id)
    {
        $product = $this->productRepository->find($id);
        $validatedData = $request->validate([
            'productName' => 'required|max:255',
            'productType' => 'required',
            'category' => 'required',
            'productDesc' => 'required|max:255',
            'productPrice' => 'required',
            'color' => 'required|array',
            'size' => 'required|array',
            'stock' => 'required|array',
        ]);
        $validatedData['productPrice'] = str_replace(['RM', ' '], '', $validatedData['productPrice']);

        $sizeCounts = json_decode($request->input('sizeCountData'), true);
        if (is_null($sizeCounts)) {
            $sizeCounts = [1 => 1];
        }
        $sizes = $validatedData['size'];
        $stocks = $validatedData['stock'];
        $sizeString = '';
        $stockString = '';
        $currentIndex = 0;

        foreach ($sizeCounts as $colorId => $count) {
            $sizesForColor = array_slice($sizes, $currentIndex, $count);
            $stocksForColor = array_slice($stocks, $currentIndex, $count);

            // Sort the sizes and stocks for this color
            list($sortedSizesForColor, $sortedStocksForColor) = $this->sortSizesAndStocks($sizesForColor, $stocksForColor);

            $sizeString .= ($sizeString === '' ? '' : '|') . implode(',', $sortedSizesForColor);
            $stockString .= ($stockString === '' ? '' : '|') . implode(',', $sortedStocksForColor);

            $currentIndex += $count;
        }

        $qrFileName  = '';
        $images = array();
        $product_image = $product->productImgObj;
        if ($files = $request->input('filepond')) {
            foreach ($files as $file) {
                $json_string = json_decode($file, true);
                $data_column = $json_string['data'];
                $image = base64_decode($data_column);
                $imageName = time() . '_' . $json_string['name']; // timestamp_imageName
                file_put_contents('../public/user/images/product/'.$imageName, $image);
                $images[] = $imageName;
            }
            $product_image = implode("|", $images);
        }
        

        if ($modelFile = $request->input('productModel')) {
            $json_string = json_decode($modelFile, true);
            $data_column = $json_string['data'];

            $model = base64_decode($data_column);
            $modelName = time() . '_' . $json_string['name'];
            file_put_contents('../public/user/images/product/'.$modelName, $model);
            $product_image .= '|' . $modelName;
        } else {
            $modelName = $product->productImgObj;
        }

        if ($qrFile = $request->input('virtualTryOnQR')) {
            $json_string = json_decode($qrFile, true);
            $data_column = $json_string['data'];

            $qr = base64_decode($data_column);
            $qrName = time() . '_QR_' . $json_string['name'];
            file_put_contents('../public/user/images/product/'.$qrName, $qr);
            $qrFileName = $qrName; 
        } else {
            $qrFileName = $product->productTryOnQR;
        }

        $capitalizedColors = array_map(function($color) {
            return ucwords($color);
        }, $validatedData['color']);
        
        $colorString = implode('|', $capitalizedColors);
        
        $productData = [
            'productName' => $validatedData['productName'],
            'productType' => $validatedData['productType'],
            'category' => $validatedData['category'],
            'productDesc' => $validatedData['productDesc'],
            'price' => $validatedData['productPrice'],
            'color' => implode('|', $validatedData['color']),
            'size' => $sizeString,
            'stock' => $stockString,
            'productImgObj' => $product_image, 
            'productTryOnQR' => $qrFileName,
            'deleted'=>0,
        ];
        $this->productRepository->update($productData,$id);
        return redirect()->route('all-products')->with('success', 'Product updated successfully.');
    }
    public function delete($id) {
        $this->productRepository->delete($id);
        return redirect()->route('all-products')->with('success', 'Product updated successfully.');
    }
}

