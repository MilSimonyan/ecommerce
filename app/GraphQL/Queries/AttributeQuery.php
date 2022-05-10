<?php

namespace App\GraphQL\Queries;

use App\Models\Attribute;
use GraphQL\Type\Definition\ObjectType;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class AttributeQuery
{
    public function getAll(?ObjectType $rootValue, array $args, GraphQLContext $context)
    {
        return Attribute::all();
    }
}
