<?php

namespace App\GraphQL\Queries;

use App\Models\Product;

final class Products
{
    /**
     * @param $_
     * @param array $args
     * @return \Illuminate\Database\Eloquent\Collection
     */
        public function __invoke($_, array $args)
    {
        return Product::all();
    }

}
