<?php

namespace Tests\Feature\core\Product\Http\Controllers;

use App\Models\Product;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    public function test_it_should_be_return_all_products_successfully(): void
    {
        //arrange
        $products = Product::all();

        //act
        $response = $this->get(route('get-all-products'));

        //assert
        $response->assertSuccessful();
        $this->assertCount($products->count(), $response->json()['data']);
    }
}
