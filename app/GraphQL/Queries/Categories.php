<?php

namespace App\GraphQL\Queries;

use App\Models\Category;

final class Categories
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        return Category::all();
    }
}
