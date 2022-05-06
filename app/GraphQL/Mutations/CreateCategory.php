<?php

namespace App\GraphQL\Mutations;


use App\Models\Category;

use App\Models\Product;
use Illuminate\Validation\Factory;

final class CreateCategory
{
    /**
     * @var Factory
     */
    protected Factory $validator;

    /**
     * @param Factory $validator
     */
    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param $_
     * @param array $args
     * @param $validator
     * @return Category
     * @throws \Illuminate\Validation\ValidationException
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

        if (isset($args['products']) && $product = Product::find($args['products'])) {
            $category->products()->sync($product);
        }

        return $category;
    }
}
