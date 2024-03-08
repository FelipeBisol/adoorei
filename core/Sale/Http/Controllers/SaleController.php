<?php

namespace Core\Sale\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Core\Product\Contracts\ProductRepositoryInterface;
use Core\Sale\Contracts\SaleRepositoryInterface;
use Core\Sale\DTO\SaleAmount;
use Core\Sale\DTO\SaleProducts;
use Core\Sale\Http\Requests\CreateSaleRequest;
use Core\Sale\Http\Resources\SaleResource;
use Core\Sale\UseCases\SumSaleAmount;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct(
        private readonly SaleRepositoryInterface $saleRepository,
        private readonly ProductRepositoryInterface $productRepository
    )
    {
    }

    public function all(): \Illuminate\Http\JsonResponse
    {
        $sales = $this->saleRepository->all();

        return response()->json(
            $this->restFormatSuccess(SaleResource::collection($sales)->jsonSerialize())
        );
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
            $this->restFormatSuccess(SaleResource::make($sale)->jsonSerialize())
        );
    }

    public function get(int $id)
    {
        $sale = $this->saleRepository->find($id);

        if ($sale){
            return response()->json(
                $this->restFormatSuccess(SaleResource::make($sale)->jsonSerialize())
            );
        }

        return response()->json(
            $this->restFormatNotFound(), 404
        );
    }

    public function delete(int $id)
    {
        $sale = $this->saleRepository->find($id);

        if (!$sale){
            return response()->json(
                $this->restFormatNotFound(), 404
            );
        }

        $this->saleRepository->delete($sale);

        return response(
            $this->restFormatEmptyData()
        );
    }

    public function addProduct(int $id, CreateSaleRequest $request)
    {
        $sale = $this->saleRepository->find($id);

        if (!$sale){
            return response()->json(
                $this->restFormatNotFound(), 404
            );
        }

        $sale = $this->saleRepository->attatchNewProduct($sale, $request->input('products'));

        return response()->json(
            $this->restFormatSuccess(SaleResource::make($sale->refresh())->jsonSerialize())
        );
    }
}
