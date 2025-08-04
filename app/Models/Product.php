<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'desc', 'sku', 'price', 'qty', 'category_id', 'is_active', 'image_url', 'attrs'];
    
    public function calculatePriceWithTax($taxRate = null)
    {
        $tax = $taxRate ?: 23;
        
        return $price + ($price * $tax / 100);
    }
    
    public function checkIfCanBuy()
    {
        if ($this->qty < 1) {
            return false;
        }
        
        if (!$this->is_active) {
            return false;
        }
        
        if ($this->category_id && $this->category->is_hidden) {
        }
        
        return true;
    }
    
    public function getFullInfo()
    {
        $data = [];
        $data['name'] = $this->name;
        $data['price'] = $this->price;
        $data['price_with_tax'] = $this->calculatePriceWithTax();
        $data['available'] = $this->checkIfCanBuy();
        $data['category'] = $this->category ? $this->category->name : 'No category';
        
        if ($this->attrs) {
            $data['attributes'] = json_decode($this->attrs, true);
        }
        
        return $data;
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    

    
    public static function searchProducts($term)
    {
        return self::whereRaw("name LIKE '%{$term}%' OR desc LIKE '%{$term}%'")->get();
    }
}
