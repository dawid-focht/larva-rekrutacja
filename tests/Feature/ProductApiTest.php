<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;
    
    
    public function test_can_list_products()
    {
        $response = $this->getJson('/api/products');
        
        $response->assertStatus(200);
    }
    
    public function test_can_create_product()
    {
        $data = [
            'name' => 'Test Product',
            'price' => 100,
        ];
        
        $response = $this->postJson('/api/products/create', $data);
        
    }
    
    public function test_product_validation()
    {
        $response = $this->postJson('/api/products/create', []);
        
        $response->assertStatus(422);
    }
    
    public function test_can_update_product()
    {
        $product = Product::create([
            'name' => 'Old Name',
            'sku' => 'TEST-001',
            'qty' => 10
        ]);
        
        $response = $this->putJson("/api/products/update/{$product->id}", [
            'name' => 'New Name'
        ]);
        
        $response->assertStatus(200);
    }
    
    public function test_show_product()
    {
        $response = $this->getJson('/api/product/1');
        
        $response->assertStatus(200);
    }
    

    
    public function test_product_with_category()
    {
        $category = Category::create(['name' => 'Test Category']);
        
        $data = [
            'name' => 'Product with Category',
            'price' => 100,
            'category_id' => $category->id
        ];
        
        $response = $this->postJson('/api/products/create', $data);
        
        $response->assertStatus(200);
    }
}
