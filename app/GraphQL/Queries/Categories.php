<?php

namespace App\GraphQL\Queries;

use App\Models\Category;

final class Categories
{
    /**
     * @param $_
     * @param array $args
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function __invoke($_, array $args)
    {
        return Category::all();
    }
}
