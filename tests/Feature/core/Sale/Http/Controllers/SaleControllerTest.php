<?php

namespace Tests\Feature\core\Sale\Http\Controllers;

use App\Models\Product;
use Tests\TestCase;

class SaleControllerTest extends TestCase
{
    public function test_it_should_be_create_an_sale_successfully(): void
    {
        //arrange
        $request = [
            'products' => [1, 1, 2, 3]
        ];

        //act
        $response = $this->post(route('create-sale', $request));

        //assert
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'status',
            'data' => [
                'sale_id',
                'amount',
                'products' => [
                    '*' => [
                        'product_id',
                        'nome',
                        'price',
                        'amount',
                    ]
                ]
            ]
        ]);
    }

    public function test_it_should_be_create_a_sale_with_the_exact_value(): void
    {
        //arrange
        $products = Product::query()->whereIn('id', [1, 3])->get();
        $request = [
            'products' => $products->pluck('id')->toArray()
        ];

        $amount = array_sum($products->pluck('price')->toArray());

        //act
        $response = $this->post(route('create-sale', $request));

        //assert
        $response->assertSuccessful();
        $this->assertEquals($amount, $response->json()['data']['amount']);
    }
}
