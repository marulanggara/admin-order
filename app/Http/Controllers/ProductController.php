<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Queries\QProduct;

class ProductController extends Controller
{
    protected $productQuery;

    public function index(QProduct $productQuery)
    {
        return response()->json([
            'status' => 200,
            'message' => 'Product list',
            'data' => $productQuery->getAllProducts()
        ], 200);
    }

    public function show(QProduct $productQuery, $id)
    {
        return response()->json([
            'status' => 200,
            'message' => 'Product found',
            'data' => $productQuery->getProductById($id)
        ], 200);
    }

    public function store(Request $request, QProduct $productQuery)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:products,code',
            'description' => 'required',
            'selling_price' => 'required',
        ]);
        return response()->json([
            'status' => 201,
            'message' => 'Product created successfully',
            'data' => $productQuery->storeProduct($request)
        ], 201);
    }

    public function update(Request $request, $id, QProduct $productQuery)
    {
        $product = Product::findOrFail($id);
        return response()->json([
            'status' => 200,
            'message' => 'Product updated successfully',
            'data' => $productQuery->updateProduct($request, $id)
        ], 200);
    }

    public function destroy($id, QProduct $productQuery)
    {
        $product = Product::findOrFail($id);
        return response()->json([
            'status' => 200,
            'message' => 'Product deleted successfully',
            'data' => $productQuery->destroyProduct($id)
        ], 200);
    }
}
