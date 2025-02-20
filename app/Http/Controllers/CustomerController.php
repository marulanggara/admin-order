<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return response()->json([
            'status' => 200,
            'message' => 'Customer list',
            'data' => $customers
        ], 200);   
    }

    public function create()
    {
        return view('customers.add');
    }

    public function store(Request $request)
    {
        try {
            // Validasi request
            $request->validate([
                'no_customer' => 'required|unique:customers,no_customer',
                'name' => 'required',
                'email' => 'required|email|unique:customers,email',
                'phone' => 'required',
                'address' => 'required',
                'created_at' => now(),
            ]);

            // Simpan data customer ke database
            $customer = Customer::create($request->all());

            return response()->json([
                'status' => 201,
                'message' => 'Customer created successfully',
                'data' => $customer
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        if (!$customer) {
            return response()->json([
                'status' => 404,
                'message' => 'Customer not found'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Customer found',
            'data' => $customer
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        if (!$customer) {
            return response()->json([
                'status' => 404,
                'message' => 'Customer not found'
            ], 404);
        }
        $customer->update($request->all());
        return response()->json([
            'status' => 200,
            'message' => 'Customer updated successfully',
            'data' => $customer
        ], 200);
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        if (!$customer) {
            return response()->json([
                'status' => 404,
                'message' => 'Customer not found'
            ], 404);
        }
        $customer->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Customer deleted successfully'
        ], 200);
    }
}
