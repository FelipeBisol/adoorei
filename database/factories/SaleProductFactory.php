<?php

namespace Database\Factories;

use App\Models\SaleProduct;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SaleProductFactory extends Factory
{
    protected $model = SaleProduct::class;

    public function definition()
    {
        return [
            'sale_id' => $this->faker->randomNumber(),
            'product_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
