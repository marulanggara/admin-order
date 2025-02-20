<?php

namespace App\Http\Controllers;

use App\Models\OrderProduct;
use DB;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer', 'orderProducts.product')->get();
        return response()->json([
            'status' => 200,
            'message' => 'Order list',
            'data' => $orders
        ], 200);
    }

    public function show($id)
    {
        $order = Order::with('customer', 'orderProducts.product')->findOrFail($id);
        return response()->json([
            'status' => 200,
            'message' => 'Order found',
            'data' => $order
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:master_tables.customers,id',
            'order_date' => 'required',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:master_tables.products,id',
            'products.*.quantity' => 'required|numeric',
            'products.*.price' => 'required|numeric',
            'created_at' => now(),
        ]);
        try {
            DB::beginTransaction();

            // Buat order baru
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'order_date' => $request->order_date,
            ]);

            $totalPrice = 0;
            foreach ($request->products as $product) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    ]);
                // $totalPrice += $product['price'] * $product['quantity'];
            }

            DB::commit();
            return response()->json([
                'status' => 201,
                'message' => 'Order created',
                'data' => $order
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // public function update(Request $request, $id)
    // {
    //     $order = Order::findOrFail($id);
    //     $order->update($request->all());
    //     return response()->json([
    //         'status' => 200,
    //         'message' => 'Order updated',
    //         'data' => $order
    //     ]);
    // }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Order deleted',
            'data' => $order
        ]);
    }
}
