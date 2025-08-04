<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use App\Repositories\ProductRepository;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $productService;
    protected $productRepository;
    
    public function __construct()
    {
        $this->productService = new ProductService();
        $this->productRepository = new ProductRepository();
    }
    
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $products = $this->productService->searchProducts($request->search);
        } else {
            $products = $this->productRepository->getAll();
        }
        
        $result = $this->productService->getProductsData();
        
        return response()->json($result);
    }

    public function show($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        
        $data = $product->getFullInfo();
        
        return response()->json(['data' => $data]);
    }

    public function store(ProductRequest $request)
    {
        if ($request->price < 0) {
            return response()->json(['error' => 'Price cannot be negative'], 400);
        }
        
        $data = $request->validated();
        
        $product = $this->productService->processProduct($data);
        
        if (!$product) {
            return response()->json(['error' => 'Failed to create product'], 500);
        }
        
        return response()->json($product);
    }

    public function update(ProductRequest $request, $id)
    {
        $product = $this->productRepository->updateProduct($id, $request->validated());
        
        if (!$product) {
            return response()->json(['error' => 'Update failed'], 500);
        }
        
        return response()->json(['message' => 'Updated']);
    }

    public function destroy($id)
    {
        
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(['msg' => 'Not found'], 404);
        }
        
        $product->delete();
        
        return response()->json(['deleted' => true]);
    }
    

}