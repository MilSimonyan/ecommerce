<?php

namespace Tests\Unit\GraphQL\Mutation\Product;

use Tests\TestCase;

class CreateProductTest extends TestCase
{
    public function testCreateProduct(): void
    {
        $name = "Car";
        $description = "The car is BMW";

        $response = $this->postGraphQL(/** @lang GraphQL */ '
        mutation {
                    createProduct(
                        input: {
                            name: "' . $name . '"
                            description: "' . $description . '"
                        }
                    ) {
                        id
                        name
                        description
                    }
                }
        ');

        $product = $response->json('data.createProduct');
        $this->assertEquals($product['name'], $name);
        $this->assertEquals($product['description'], $description);
    }
}
