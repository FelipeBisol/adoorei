<?php

namespace Core\Sale\UseCases;

use App\Models\Product;
use Illuminate\Support\Collection;

class SumSaleAmount
{
    private Collection $products;
    private int $amount = 0;

    private function __construct()
    {
        $this->products = collect([]);
    }

    public static function make(): self
    {
        return new self();
    }

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
        $this->amount += $product->price;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getProductsIds(): array
    {
        return $this->products->pluck('id')->toArray();
    }
}
