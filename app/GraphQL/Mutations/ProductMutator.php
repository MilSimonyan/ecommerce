<?php

namespace App\GraphQL\Mutations;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use GraphQL\Type\Definition\ObjectType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Factory;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class ProductMutator
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
     * @return Product
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(?ObjectType $rootValue, array $args, GraphQLContext $context): Product
    {
        $this->validator->validate($args, [
            'name' => 'min:3|max:50',
            'description' => 'min:5|max:500'
        ]);

        $product = Product::create([
            'name' => $args['name'],
            'description' => $args['description']
        ]);

        if (isset($args['categories']) && $category = Category::find($args['categories'])) {
            $product->categories()->sync($category);
        }

        if (isset($args['attributes']) && Attribute::find($args['attributes'])) {
            $attributes = [];
            $count = count($args['values']);

            for ($i = 0; $i < $count; $i++) {
                $attributes[$args['attributes'][$i]]['value'] = $args['values'][$i];
            }

            $product->attributes()->sync($attributes);
        }

        return $product;
    }

    /**
     * @param ObjectType|null $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @return Product
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(?ObjectType $rootValue, array $args, GraphQLContext $context): Product
    {
        $product = Product::find($args['id']);

        $this->validator->validate($args, [
            'name' => 'min:3|max:50',
            'description' => 'min:10',
        ]);

        if (isset($args['name'])) {
            $product->name = $args['name'];
        }

        if (isset($args['name'])) {
            $product->description = $args['description'];
        }

        if (isset($args['categories']) && $category = Category::find($args['categories'])) {
            $product->categories()->sync($category);
        }

        if (isset($args['attributes']) && $attribute = Attribute::find($args['attributes'])) {
            $product->attributes()->sync($attribute);
        }

        $product->save();

        return $product;
    }

    /**
     * @param ObjectType|null $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @return bool
     */
    public function delete(?ObjectType $rootValue, array $args, GraphQLContext $context): bool
    {
        try {
            return Product::findOrFail($args['id'])->delete();
        } catch (ModelNotFoundException) {
            return false;
        }
    }
}
