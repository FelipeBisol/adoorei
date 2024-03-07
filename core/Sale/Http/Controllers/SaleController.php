<?php

namespace Core\Sale\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Core\Product\Contracts\ProductRepositoryInterface;
use Core\Sale\Contracts\SaleRepositoryInterface;
use Core\Sale\DTO\SaleAmount;
use Core\Sale\DTO\SaleProducts;
use Core\Sale\Http\Requests\CreateSaleRequest;
use Core\Sale\Http\Resources\SaleResource;
use Core\Sale\UseCases\SumSaleAmount;

class SaleController extends Controller
{
    public function __construct(
        private readonly SaleRepositoryInterface $saleRepository,
        private readonly ProductRepositoryInterface $productRepository
    )
    {
    }

    public function create(CreateSaleRequest $request)
    {
        $sale_amount = SumSaleAmount::make();

        foreach ($request->input('products') as $item) {
            $product = $this->productRepository->findById($item);
            $sale_amount->addProduct($product);
        }

        $sale = $this->saleRepository->create(SaleAmount::make($sale_amount));
        $this->saleRepository->attachProducts(SaleProducts::make($sale_amount), $sale);

        return response()->json(
        $this->restFormatSuccess(SaleResource::make($sale->load('products'))->jsonSerialize())
    );
    }
}
