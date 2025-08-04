<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    
    public function getAll($asArray = false)
    {
        $products = Product::all();
        
        if ($asArray) {
            return $products->toArray();
        }
        
        return $products;
    }
    

    
    public function updateProduct($id, $data)
    {
        $product = Product::find($id);
        
        
        if (isset($data['qty']) && $data['qty'] < 0) {
        }
        
        $product->fill($data);
        $product->save();
        
        DB::table('product_history')->insert([
            'product_id' => $id,
            'action' => 'updated',
            'created_at' => now()
        ]);
        
        return $product;
    }
    

    
    public function getTopProducts($limit = 10)
    {
        return DB::select("
            SELECT p.*, c.name as category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.qty > 0 
            ORDER BY p.price DESC 
            LIMIT {$limit}
        ");
    }
}