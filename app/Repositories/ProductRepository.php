<?php
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ProductRepositoryInterface;
class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        return Product::all();
    }

    public function allWithFilters(Request $request)
    {
        $query = Product::query();

        // Apply sorting based on the provided criteria
        $sort = $request->query('sort');
        switch ($sort) {
            case 'popularity':
                $query->orderBy('popularity', 'desc');
                break;
            case 'rating':
                $query->orderBy('average_rating', 'desc');
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

        return $query->get();
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }

    public function findRelatedProducts($category, $excludeId)
    {
        return Product::where('category', $category)
                      ->where('id', '!=', $excludeId)
                      ->get();
    }
}
