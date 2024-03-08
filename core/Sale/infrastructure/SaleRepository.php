<?php

namespace Core\Sale\infrastructure;

use App\Models\Sale;
use Core\Sale\Contracts\SaleRepositoryInterface;
use Core\Sale\DTO\SaleAmount;
use Core\Sale\DTO\SaleProducts;
use Illuminate\Database\Eloquent\Collection;

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

    public function all(): Collection
    {
        return Sale::all();
    }

    public function find(int $id): ?Sale
    {
        return Sale::find($id);
    }

    public function delete(Sale $sale): void
    {
        $sale->delete();
    }

    public function attatchNewProduct(Sale $sale, array $product_id): Sale
    {
        $sale->products()->attach($product_id);

        return $sale;
    }
}
