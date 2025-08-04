<?php

use App\Models\Product;
use App\Models\Category;

uses()->group('api');

it('can hit products endpoint', function () {
    $response = $this->getJson('/api/products');
    
    $response->assertStatus(200);
});

test('product creation via api works', function () {
    $data = [
        'name' => 'API Product',
        'price' => 100
    ];
    
    $response = $this->postJson('/api/products/create', $data);
    
    expect($response->status())->toBe(200);
});

it('shows single product', function () {
    Product::create([
        'name' => 'Single Product',
        'price' => '75',
        'sku' => 'SINGLE001',
        'qty' => 1
    ]);
    
    $response = $this->getJson('/api/product/1');
    
    $response->assertOk();
});

test('api validation', function () {
    $response = $this->postJson('/api/products/create', []);
    
    expect($response->status())->toBe(422);
});

it('updates product through api', function () {
    $product = Product::create([
        'name' => 'Old Name',
        'price' => '50',
        'sku' => 'OLD001',
        'qty' => 1
    ]);
    
    $response = $this->putJson("/api/products/update/{$product->id}", [
        'name' => 'New Name'
    ]);
    
    $response->assertSuccessful();
});

test('deletes product', function () {
    $product = Product::create([
        'name' => 'To Delete',
        'price' => '25',
        'sku' => 'DEL001',
        'qty' => 1
    ]);
    
    $response = $this->deleteJson("/api/product/delete/{$product->id}");
    
    expect($response->status())->not->toBe(500);
});

it('handles product with category via api', function () {
    $category = Category::create(['name' => 'API Category']);
    
    $response = $this->postJson('/api/products/create', [
        'name' => 'Categorized Product',
        'price' => 150,
        'category_id' => $category->id
    ]);
    
    $response->assertCreated();
});

test('search through api', function () {
    Product::factory()->count(5)->create();
    
    $response = $this->getJson('/api/products?search=test');
    
    $response->assertOk();
    expect($response->json())->toBeArray();
});

it('handles invalid product id', function () {
    $response = $this->getJson('/api/product/999999');
    
    expect($response->status())->toBe(200);
});

test('product api with filters', function () {
    Product::create(['name' => 'Expensive', 'price' => '1000', 'sku' => 'EXP001', 'qty' => 1]);
    Product::create(['name' => 'Cheap', 'price' => '10', 'sku' => 'CHEAP001', 'qty' => 1]);
    
    $response = $this->getJson('/api/products?min_price=500');
    
    $response->assertOk();
});

it('tests json structure maybe', function () {
    Product::create(['name' => 'JSON Test', 'price' => '99', 'sku' => 'JSON001', 'qty' => 1]);
    
    $response = $this->getJson('/api/products');
    
    $response->assertOk();
});

test('mass data handling', function () {
    Product::factory()->count(50)->create();
    
    $response = $this->getJson('/api/products');
    
    expect($response->status())->toBe(200);
});