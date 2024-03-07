<?php

namespace Core\Sale\DTO;

use Core\Sale\UseCases\SumSaleAmount;

class SaleAmount
{
    private function __construct(private readonly SumSaleAmount $amount)
    {

    }

    public static function make(SumSaleAmount $amount): self
    {
        return new self($amount);
    }

    public function getAmount(): int
    {
        return $this->amount->getAmount();
    }
}
