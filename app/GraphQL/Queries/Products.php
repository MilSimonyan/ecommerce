<?php

namespace App\GraphQL\Queries;

use App\Models\Product;

final class Products
{


    /**
     * @param  null  $_
     * @param  array{}  $args
     */
        public function __invoke($_, array $args)
    {
        return Product::all();
    }

}
