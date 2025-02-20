<?php

namespace App\Queries;

use App\Models\Product;

class QProduct
{
    public function getAllProducts()
    {
        return Product::query()->get();
    }

    public function getProductById($id)
    {
        return Product::query()->findOrFail($id);
    }

    public function storeProduct($request)
    {
        return Product::query()->create($request->all());
    }

    public function updateProduct($request, $id)
    {
        return Product::query()->findOrFail($id)->update($request->all());
    }

    public function destroyProduct($id)
    {
        return Product::query()->findOrFail($id)->delete();
    }
}