<?php

namespace App\GraphQL\Mutations;

use App\Models\Category;
use function PHPUnit\Framework\isNull;

final class DeleteCategory
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args): ?Category
    {
        if($category = Category::find($args['id'])) {
            $category->delete();
        }

        return $category;

    }

}
