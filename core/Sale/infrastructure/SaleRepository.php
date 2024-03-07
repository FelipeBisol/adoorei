<?php

namespace Core\Sale\infrastructure;

use App\Models\Sale;
use Core\Sale\Contracts\SaleRepositoryInterface;
use Core\Sale\DTO\SaleAmount;
use Core\Sale\DTO\SaleProducts;

class SaleRepository implements SaleRepositoryInterface
{
    public function create(SaleAmount $amount): Sale
    {
        return Sale::create([
            'amount' => $amount->getAmount()
        ]);
    }

    public function attachProducts(SaleProducts $amount, Sale $sale): Sale
    {
        $sale->products()->attach($amount->getProductsIds());
        return $sale;
    }
}
