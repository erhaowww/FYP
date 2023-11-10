<?php
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ProductRepositoryInterface;
class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        return Product::available();
    }

    public function allWithFilters(Request $request)
    {
        $query = Product::available();

        // Apply sorting based on the provided criteria
        $sort = $request->query('sort');
        switch ($sort) {
            case 'popularity':
                // $query->orderBy('popularity', 'desc');
                break;
            case 'rating':
                // $query->orderBy('average_rating', 'desc');
                break;
            case 'newness':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('id');
                break;
        }

        // Filter by price range if specified
        $price = $request->query('price');
        if ($price) {
            [$minPrice, $maxPrice] = explode('-', $price);
            $query->whereBetween('price', [(float)$minPrice, (float)$maxPrice]);
        }

        // Filter by colors if specified
        $colors = $request->query('color', []);
        if (!empty($colors)) {
            $query->where(function($q) use ($colors) {
                foreach ($colors as $color) {
                    $q->orWhere('color', 'LIKE', "%{$color}%");
                }
            });
        }

        // Filter by category if specified
        $category = $request->query('category');
        if ($category) {
            $query->where('category', $category);
        }
        
        $searchTerm = $request->query('search-product');
        if ($searchTerm) {
            $query->where('productName', 'LIKE', "%{$searchTerm}%")
                ->orWhere('productDesc', 'LIKE', "%{$searchTerm}%");
            }

        return $query->get();
    }

    public function find($id)
    {
        return Product::available()->findOrFail($id);
    }

    public function findRelatedProducts($type,$category, $excludeId)
    {
        
        $query = Product::available()
                ->where(function ($query) use ($category, $type) {
                    $query->where('category', $category)
                          ->orWhere('productType', $type);
                })
                ->where('id', '!=', $excludeId);

        return $query->get();         
    }

}
