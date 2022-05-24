<?php

namespace App\GraphQL\Mutations;

use App\Models\Category;
use App\Models\Product;
use GraphQL\Type\Definition\ObjectType;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Rule;
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
        $category->user_id =  auth()->user()->id;
        $category->save();

        if (isset($args['products']) && $product = Product::find($args['products'])) {
            $category->products()->sync($product);
        }

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
            'id' => ['required',
                Rule::exists('categories', 'id')->where(
                    fn(Builder $query) => $query->where('user_id', auth()->user()->id)
                )],
            'name' => 'min:3|max:50',
            'description' => 'max:500'
        ]);

            $category = Category::find($args['id']);
            $category->name = Arr::get($args, 'name', $category->name);
            $category->description = Arr::get($args, 'description', $category->description);

            $category->save();


        return $category;
    }

    /**
     * @param ObjectType|null $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @return bool
     */
    public function deleteCategory(?ObjectType $rootValue, array $args, GraphQLContext $context): bool
    {
        $category = Category::where('user_id', auth()->user()->id)->where('id', $args['id'])->first();
        if ($category) {
            $category->delete();
            return true;
        }
        return false;
    }
}
