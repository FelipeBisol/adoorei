<?php

namespace Core\Product\infrastructure;

use App\Models\Product;
use Core\Product\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll(): Collection
    {
        return Product::all();
    }

    public function findById(int $id): Product
    {
        return Product::whereId($id)->first();
    }
}
