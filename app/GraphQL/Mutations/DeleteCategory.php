<?php

namespace App\GraphQL\Mutations;

use App\Models\Category;
use function PHPUnit\Framework\isNull;

final class DeleteCategory
{
    /**
     * @param $_
     * @param array $args
     * @return Category|null
     */
    public function __invoke($_, array $args): ?Category
    {
        if($category = Category::find($args['id'])) {
            $category->delete();
        }

        return $category;
    }

}
