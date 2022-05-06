<?php

namespace App\GraphQL\Queries;

use App\Models\Review;

final class Reviews
{
    /**
     * @param $_
     * @param array $args
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function __invoke($_, array $args)
    {
        return Review::all();
    }
}
