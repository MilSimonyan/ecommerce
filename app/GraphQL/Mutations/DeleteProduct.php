<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;

final class DeleteProduct
{
    /**
     * @param $_
     * @param array $args
     * @return Product|null
     */
    public function __invoke($_, array $args): ?Product
    {
        if($product = Product::find($args['id'])){
            $product->delete();
        }

        return $product;
    }
}
