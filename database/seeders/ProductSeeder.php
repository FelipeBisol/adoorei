<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                "name" => "Celular 1",
                "price" => 1.800,
                "description" => "Lorenzo Ipsulum",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name" => "Celular 2",
                "price" => 3.200,
                "description" => "Lorem ipsum dolor",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name" => "Celular 3",
                "price" => 9.800,
                "description" => "Lorem ipsum dolor sit amet",
                "created_at" => now(),
                "updated_at" => now()
            ],
        ]);
    }
}
