<?php

namespace App\GraphQL\Queries;

use App\Models\Review;
use GraphQL\Type\Definition\ObjectType;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class ReviewQuery
{
    public function getAllReviews(?ObjectType $rootValue, array $args, GraphQLContext $context)
    {
        return Review::all();
    }
}
