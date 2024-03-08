<?php

namespace Core\Sale\Contracts;

use App\Models\Sale;
use Core\Sale\DTO\SaleAmount;
use Core\Sale\DTO\SaleProducts;
use Illuminate\Database\Eloquent\Collection;

interface SaleRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Sale;
    public function delete(Sale $sale): void;
    public function create(SaleAmount $amount): Sale;
    public function attachProducts(SaleProducts $amount, Sale $sale): Sale;
    public function attatchNewProduct(Sale $sale, array $product_id): Sale;
}
