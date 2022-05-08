<?php

namespace App\GraphQL\Queries;


use App\Models\Category;
use GraphQL\Type\Definition\ObjectType;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class CategoryQuery
{
    /**
     * @param ObjectType|null $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCategories(?ObjectType $rootValue, array $args, GraphQLContext $context)
    {
        return Category::all();
    }
}
