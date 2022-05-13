<?php

namespace Tests\Unit\GraphQL\Queries\Product;


use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class GetProductTest extends TestCase
{
    /**
     * @var Product
     */
    private Product $product;

    private User $user;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->count(1)->create()->first();
        $this->product = Product::factory(['user_id' => $this->user->id])->count(1)->create()->first();
    }

    /**
     * @return void
     */
    public function testGetProduct(): void
    {
        $response = $this->graphql(/** @lang GraphQL */'
        query{
            product(user_id:' .$this->user->id. '){
                id
                name
                description
            }
        }
        ');
        $product = $response->json('data.product.0');
        $this->assertEquals($product['id'], $this->product->id);
        $this->assertEquals($product['name'], $this->product->name);
        $this->assertEquals($product['description'], $this->product->description);
    }
}
