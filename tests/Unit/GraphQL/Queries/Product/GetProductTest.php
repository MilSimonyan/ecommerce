<?php

namespace Tests\Unit\GraphQL\Queries\Product;


use App\Models\Product;
use Tests\TestCase;

class GetProductTest extends TestCase
{
    /**
     * @var Product
     */
    private Product $product;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->count(1)->create()->first();
    }

    /**
     * @return void
     */
    public function testGetProduct(): void
    {
        $response = $this->graphql(/** @lang GraphQL */'
        query{
            product(id:' .$this->product->id. '){
                id
                name
                description
            }
        }
        ');

        $product = $response->json('data.product');

        $this->assertEquals($product['id'], $this->product->id);
        $this->assertEquals($product['name'], $this->product->name);
        $this->assertEquals($product['description'], $this->product->description);
    }
}
