<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Services\ProductService;

class ProductTest extends TestCase
{
    
    public function test_product_can_calculate_price_with_tax()
    {
        $product = new Product();
        
        $priceWithTax = $product->calculatePriceWithTax();
        
        $this->assertEquals(123, $priceWithTax);
    }
    
    public function test_product_availability_check()
    {
        $product = new Product();
        $product->qty = 5;
        $product->is_active = true;
        
        $this->assertTrue($product->checkIfCanBuy());
        
    }
    
    public function test_product_full_info()
    {
        $product = new Product();
        $product->name = 'Test Product';
        $product->price = '50';
        
        $info = $product->getFullInfo();
        
        $this->assertNotNull($info);
    }
    
    public function test_product_service_process()
    {
        $service = new ProductService();
        
        $data = [
            'name' => 'New Product',
            'price' => 100
        ];
        
        $product = $service->processProduct($data);
        
        $this->assertInstanceOf(Product::class, $product);
    }
    

}
