<?php

namespace App\GraphQL\Mutations;


use App\Models\Category;

use App\Models\Product;
use Illuminate\Validation\Factory;

final class CreateCategory
{
    protected $validator;

    public function __construct(
        Factory $validator
    )
    {
        $this->validator = $validator;
    }

    /**
     * @param null $_
     * @param array{} $args
     * @param $validator
     * @return Category
     */
    public function __invoke($_, array $args, $validator): Category
    {
        $this->validator->validate($args, [
            'name' => 'required|min:3|max:50',
            'description' => 'required|max:255',
        ]);

        $category = Category::create([
            'name' => $args['name'],
            'description' => $args['description'],
        ]);

        if ($product = Product::find(isset($args['products']))) {
            $category->products()->sync($product);
        }

        return $category;
    }
}
