<?php

namespace App\GraphQL\Queries;

use App\Models\Review;

final class Reviews
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        return Review::all();
    }
}
