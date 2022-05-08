<?php

namespace App\GraphQL\Mutations;

use App\Models\Category;
use App\Models\Product;
use GraphQL\Type\Definition\ObjectType;
use Illuminate\Validation\Factory;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;


final class CategoryMutator
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
     * @param ObjectType|null $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @return Category
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeCategory(?ObjectType $rootValue, array $args, GraphQLContext $context): Category
    {
        $this->validator->validate($args, [
            'name' => 'required|min:3|max:50',
            'description' => 'required|max:500'
        ]);

        $category = new Category();
        $category->name = $args['name'];
        $category->description = $args['description'];

        if (isset($args['products']) && $product = Product::find($args['products'])) {
            $category->products()->sync($product);
        }

        $category->save();

        return $category;
    }

    /**
     * @param ObjectType|null $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @return Category
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateCategory(?ObjectType $rootValue, array $args, GraphQLContext $context): Category
    {
        $this->validator->validate($args, [
            'name' => 'min:3|max:50',
            'description' => 'max:500'
        ]);

        if ($category = Category::find($args['id'])) {
            if (isset($args['name'])) {
                $category->name = $args['name'];
            }

            if (isset($args['description'])) {
                $category->description = $args['description'];
            }
            $category->save();
        }

        return $category;
    }

    /**
     * @param ObjectType|null $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @return Category
     */
    public function deleteCategory(?ObjectType $rootValue, array $args, GraphQLContext $context): Category
    {
        if ($category = Category::find($args['id'])) {
            $category->delete();
        }

        return $category;
    }
}
