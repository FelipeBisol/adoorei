<?php

namespace Core\Sale\DTO;

use Core\Sale\UseCases\SumSaleAmount;

class SaleProducts
{
    private function __construct(private readonly SumSaleAmount $amount)
    {

    }

    public static function make(SumSaleAmount $amount): self
    {
        return new self($amount);
    }

    public function getProductsIds(): array
    {
        return $this->amount->getProductsIds();
    }
}
