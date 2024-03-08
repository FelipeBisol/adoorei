<?php

namespace Tests\Feature\core\Sale\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
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

    public function test_it_should_be_failed_because_products_id_are_invalid(): void
    {
        //arrange
        $product_id = random_int(999, 9999);
        $request = [
            'products' => [$product_id]
        ];

        //assert
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Produto ID $product_id inválido!");

        //act
        $response = $this->post(route('create-sale', $request))->json();
    }

    public function test_it_should_be_return_all_sales(): void
    {
        //arrange
        $sales = Sale::all();

        //act
        $response = $this->get(route('get-all-sales'));

        //assert
        $response->assertSuccessful();

        $this->assertCount($sales->count(), $response['data']);
    }

    public function test_it_should_be_possible_return_a_exact_sale_by_id(): void
    {
        //arrange
        $sale = Sale::inRandomOrder()->get()->first();

        //act
        $response = $this->get(route('get-sale', ['id' => $sale->id]));

        //assert
        $response->assertSuccessful();
        $this->assertEquals($sale->id, $response->json()['data']['sale_id']);
    }

    public function test_it_should_be_return_empty_because_the_sale_does_not_exist_for_this_id(): void
    {
        //arrange
        $id = random_int(999, 1000);

        //act
        $response = $this->get(route('get-sale', ['id' => $id]));

        //assert
        $response->assertNotFound();
    }

    public function test_it_should_be_delete_a_exact_sale(): void
    {
        //arrange
        $sale = Sale::inRandomOrder()->first();

        //act
        $response = $this->put(route('cancel-sale', ['id' => $sale->id]));

        //assert
        $response->assertSuccessful();
    }

    public function test_it_should_be_verify_if_sale_is_actually_excluded(): void
    {
        //arrange
        $sale = Sale::create(['amount' => 19990]);

        //act
        $response = $this->put(route('cancel-sale', ['id' => $sale->id]));

        //assert
        $response->assertSuccessful();
        $this->assertNotEmpty(Sale::query()->withTrashed()->where('id', $sale->id)->first());
    }

    public function test_it_should_be_possible_to_add_a_new_product_to_an_existing_sale(): void
    {
        //arrange
        $product = Product::inRandomOrder()->first();
        $sale = Sale::inRandomOrder()->first();
        $beforeProductsCount = $sale->products->count();

        //act
        $response = $this->post(route('add-product-sale', ['id' => $sale->id]), ['products' => [$product->id]]);

        //assert
        $saleUpdated = Sale::find($sale->id);
        $response->assertSuccessful();
        $this->assertCount($beforeProductsCount + 1, $saleUpdated->products);
    }
}
