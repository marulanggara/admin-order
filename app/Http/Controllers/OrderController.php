<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
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
            'customer_id' => [
                'required',
                Rule::exists('pgsql.master_tables.customers', 'id')
            ],
            'order_date' => 'required|date',
            'products' => 'required|array',
            'products.*.product_id' => [
                'required',
                Rule::exists('pgsql.master_tables.products', 'id')
            ],
            'products.*.quantity' => 'required|numeric',
            'products.*.price' => 'required|numeric',
            'created_at' => now(),
        ]);
        try {
            DB::beginTransaction();

            // Buat order baru
            $order = Order::create([
                'order_id' => rand(1000, 9999),
                'customer_id' => $request->customer_id,
                'order_date' => $request->order_date,
            ]);

            // $totalPrice = 0;
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

    public function update(Request $request, $id)
    {
        // Validasi
        $request->validate([
            'customer_id' => 'required|exists:pgsql.master_tables.customers,id',
            'order_date' => 'required|date',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:pgsql.master_tables.products,id',
            'products.*.quantity' => 'required|numeric',
            'products.*.price' => 'required|numeric',
        ]);
        try {
            DB::beginTransaction();
            // Cari order
            $order = Order::find($id);
            if (!$order) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Order not found',
                ], 404);
            }

            // Update order
            $order->update([
                'customer_id' => $request->customer_id,
                'order_date' => $request->order_date,
            ]);

            // Hapus semua produk dari order
            OrderProduct::where('order_id', $order->id)->forceDelete();

            // $totalPrice = 0;
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
                'status' => 200,
                'message' => 'Order updated',
                'data' => $order
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

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
