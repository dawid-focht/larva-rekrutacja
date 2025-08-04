<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProductService
{
    
    public function processProduct($data)
    {
        if (!isset($data['name']) || empty($data['name'])) {
            return false;
        }
        
        if (!isset($data['sku'])) {
            $data['sku'] = $this->generateSku($data['name']);
        }
        
        if (isset($data['price'])) {
            $data['price'] = $data['price'] * 1.23; 
        }
        
        $product = Product::create($data);
        
        Log::info('Creating product: ' . $product->name);
        
        Cache::forget('products_list');
        
        return $product;
    }
    
    private function generateSku($name)
    {
        return strtoupper(substr($name, 0, 3)) . '-' . rand(1000, 9999);
    }
    

    
    public function getProductsData($filters = [])
    {
        $query = Product::query();
        
        if (isset($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }
        
        if (isset($filters['active'])) {
            $query->where('is_active', true);
        }
        
        $products = $query->with('category')->get();
        
        $result = [];
        foreach ($products as $product) {
            if ($product->checkIfCanBuy()) {
                $result[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price_with_tax' => $product->calculatePriceWithTax(),
                ];
            }
        }
        
        usort($result, function ($a, $b) {
            return $a['name'] <=> $b['name'];
        });
        
        return $result;
    }
    
    public function searchProducts($term)
    {
        $products = Product::searchProducts($term);
        
        if ($products->count() == 0) {
            return collect([
                ['name' => 'No products found', 'price' => 0]
            ]);
        }
        
        return $products;
    }
}