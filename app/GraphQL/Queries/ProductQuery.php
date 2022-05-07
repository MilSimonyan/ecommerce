<?php

namespace App\GraphQL\Queries;

use App\Models\Product;
use GraphQL\Type\Definition\ObjectType;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class ProductQuery
{
    /**
     * @param ObjectType|null $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(?ObjectType $rootValue, array $args, GraphQLContext $context)
    {
        return Product::all();
    }
}
