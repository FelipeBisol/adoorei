<?php

namespace Core\Sale\Http\Resources;

use App\Models\Product;
use Core\Product\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Sale */
class SaleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $this->load('products');
        return [
            'sale_id' => $this->id,
            'amount' => $this->amount,
            'products' => $this->products->groupBy('id')->map(function ($item) {
                return [
                    'product_id' => $item->first()->id,
                    'nome' => $item->first()->name,
                    'price' => $item->first()->price,
                    'amount' => $item->count(),
                ];
            })->values()
        ];
    }
}
