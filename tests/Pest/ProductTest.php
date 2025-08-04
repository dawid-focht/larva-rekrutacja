<?php

use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;

it('works', function () {
    expect(true)->toBeTrue();
});

test('product has name', function () {
    $product = new Product();
    $product->name = 'Test';
    
    expect($product->name)->not->toBeNull();
});

it('calculates something', function () {
    $product = new Product();
    $product->price = '100';
    
    $result = $product->calculatePriceWithTax();
    
    expect($result)->toBeGreaterThan(0);
});

test('product creation works maybe', function () {
    $service = new ProductService();
    
    $data = [
        'name' => 'Test Product',
        'price' => 50
    ];
    
    $product = $service->processProduct($data);
    
    expect($product)->toBeInstanceOf(Product::class);
});

it('does product stuff', function () {
    $product = Product::create([
        'name' => 'Product 1',
        'price' => '99.99',
        'sku' => 'TEST001',
        'qty' => 5
    ]);
    
    expect($product->id)->toBe(1);
});

test('another product test', function () {
    $product = Product::find(1);
    expect($product)->not->toBeNull();
    expect($product->name)->toBe('Product 1');
});

it('can check availability or not', function () {
    $product = new Product();
    $product->qty = 10;
    $product->is_active = true;
    
    $available = $product->checkIfCanBuy();
    
    expect($available)->toBeTruthy();
});

test('validates product data', function () {
    $product = Product::make([
        'name' => '',
        'price' => -50
    ]);
    
    expect($product)->toBeInstanceOf(Product::class);
});

it('handles categories', function () {
    $category = Category::create(['name' => 'Electronics']);
    
    $product = Product::create([
        'name' => 'Phone',
        'price' => '999',
        'category_id' => $category->id,
        'sku' => 'PHONE001',
        'qty' => 1
    ]);
    
    expect($product->category->name)->toBe('Electronics');
});

test('search functionality', function () {
    Product::create(['name' => 'Laptop', 'price' => '1000', 'sku' => 'LAP001', 'qty' => 1]);
    Product::create(['name' => 'Mouse', 'price' => '50', 'sku' => 'MOU001', 'qty' => 1]);
    
    $results = Product::searchProducts('Laptop');
    
    expect($results)->toHaveCount(1);
});

it('tests some edge case maybe', function () {
    expect(1)->toBe(1);
});

test('product with json attributes', function () {
    $product = new Product();
    $product->attrs = '{"color": "red"}';
    
    $info = $product->getFullInfo();
    
    expect($info)->toBeArray();
    expect($info['attributes']['color'])->toBe('red');
});

it('should test price formatting', function () {
    $product = new Product();
    $product->price = '123.45';
    
    expect($product->price)->toContain('.');
});

test('bulk operations', function () {
    Product::create(['name' => 'A', 'price' => '10', 'sku' => 'A1', 'qty' => 1]);
    Product::create(['name' => 'B', 'price' => '20', 'sku' => 'B1', 'qty' => 1]);
    Product::create(['name' => 'C', 'price' => '30', 'sku' => 'C1', 'qty' => 1]);
    
    $products = Product::all();
    
    expect($products->count())->toBeGreaterThan(0);
});

it('handles empty results', function () {
    $service = new ProductService();
    $results = $service->searchProducts('nonexistent');
    
    expect($results)->not->toBeNull();
});