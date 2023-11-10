<?php
namespace App\Repositories\Interfaces;
use Illuminate\Http\Request;
interface ProductRepositoryInterface
{
    public function getAll();
    public function allWithFilters(Request $request);
    public function find($id);
    public function findRelatedProducts($type, $category, $excludeId);
}
