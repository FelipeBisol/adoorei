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
}
