<?php

namespace Core\Sale\Contracts;

use App\Models\Sale;
use Core\Sale\DTO\SaleAmount;
use Core\Sale\DTO\SaleProducts;

interface SaleRepositoryInterface
{
    public function create(SaleAmount $amount): Sale;
    public function attachProducts(SaleProducts $amount, Sale $sale): Sale;
}
