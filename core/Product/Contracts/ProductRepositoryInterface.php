<?php

namespace Core\Product\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function getAll(): Collection;
}
