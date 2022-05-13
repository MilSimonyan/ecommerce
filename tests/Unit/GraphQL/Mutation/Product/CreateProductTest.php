<?php

namespace Tests\Unit\GraphQL\Mutation\Product;

use App\Models\User;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    public function testCreateProduct(): void
    {
        $name = "Car";
        $description = "The car is BMW";
        $user = User::factory()->count(1)->create();
        $id = $user->first()->id;
        $response = $this->postGraphQL([
            'query' => /** @lang GraphQL */ '
            mutation createProduct($name: String!, $description: String!, $user_id: Int!){
                    createProduct(
                        input: {
                            user_id: $user_id
                            name: $name
                            description: $description
                        }
                    ) {
                        id
                        name
                        description
                    }
                }',
            'variables' => [
                'user_id' => $id,
                'name' => $name,
                'description' => $description,
            ]
        ]);
        $product = $response->json('data.createProduct');
        $this->assertEquals($product['name'], $name);
        $this->assertEquals($product['description'], $description);
    }
}
