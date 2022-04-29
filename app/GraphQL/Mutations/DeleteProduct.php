<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;

final class DeleteProduct
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args): ?Product
    {
        if($product = Product::find($args['id'])){
            $product->delete();
        }
        return $product;
    }
}
