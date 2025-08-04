<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $categories = [
            ['name' => 'Electronics', 'is_hidden' => false],
            ['name' => 'Clothing', 'is_hidden' => false],
            ['name' => 'Hidden Category', 'is_hidden' => true],
        ];
        
        DB::table('categories')->insert($categories);
        
        $electronicsId = DB::table('categories')->where('name', 'Electronics')->first()->id;
        $clothingId = DB::table('categories')->where('name', 'Clothing')->first()->id;
        
        for ($i = 1; $i <= 50; $i++) {
            Product::create([
                'name' => "Product $i",
                'qty' => rand(0, 100),
                'category_id' => rand(1, 2) == 1 ? $electronicsId : $clothingId,
            ]);
        }
        
        Product::create([
            'name' => 'Product with negative price',
            'sku' => 'NEGATIVE',
            'qty' => 10,
        ]);
        
        Product::create([
            'name' => 'Product with huge quantity',
            'price' => '100',
            'sku' => 'HUGE-QTY',
        ]);
        
    }
}
