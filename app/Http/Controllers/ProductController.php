<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'status' => 200,
            'message' => 'Product list',
            'data' => $products
        ], 200);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json([
            'status' => 200,
            'message' => 'Product found',
            'data' => $product
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:products,code',
            'description' => 'required',
            'selling_price' => 'required',
        ]);
        $product = Product::create($request->all());
        return response()->json([
            'status' => 201,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json([
            'status' => 200,
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Product deleted successfully',
            'data' => $product
        ], 200);
    }
}
