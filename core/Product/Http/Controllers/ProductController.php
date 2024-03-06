<?php

namespace Core\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Core\Product\Contracts\ProductRepositoryInterface;
use Core\Product\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {

    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $data = $this->productRepository->getAll();

        return response()->json(
            $this->restFormatSuccess(ProductResource::collection($data)->jsonSerialize())
        );
    }
}
