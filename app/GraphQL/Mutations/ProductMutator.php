<?php

namespace App\GraphQL\Mutations;

use App\Models\Category;
use App\Models\Product;
use GraphQL\Type\Definition\ObjectType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;
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
     * @throws ValidationException
     */
    public function create(?ObjectType $rootValue, array $args, GraphQLContext $context): Product
    {
        $this->validator->validate($args, [
            'name' => 'min:3|max:50',
            'description' => 'min:5|max:500',
            'category_id' => 'exists:categories,id',
            'attributeValue.*.attribute_id' => 'required|exists:attributes,id',
            'attributeValue.*.value' => 'required|string',
        ]);

        $product = new Product();
        $product->user_id = auth()->user()->id;
        $product->name = $args['name'];
        $product->description = $args['description'];
        $product->save();

        $category = Category::find($args['category_id']);
        $product->categories()->sync($category);

        $attributes = $args['attributeValue'];
        $product->attributes()->sync($attributes);

        return $product;
    }

    /**
     * @param ObjectType|null $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @return Product
     * @throws ValidationException
     */
    public function update(?ObjectType $rootValue, array $args, GraphQLContext $context): Product
    {
        $this->validator->validate($args, [
            'id' => 'required|exists:products,id',
            'name' => 'min:3|max:50',
            'description' => 'min:10',
            'category_id' => 'exists:categories,id',
            'attributeValue.*.attribute_id' => 'exists:attributes,id',
            'attributeValue.*.value' => 'string',
        ]);

        $product = Product::find($args['id']);
        $product->name = $args['name'];
        $product->description = $args['description'];
        $product->save();

        $category = Category::find($args['category_id']);
        $product->categories()->sync($category);

        $attribute = [];
        foreach ($args['attributeValue'] as $arg) {
            $attribute[$arg['attribute_id']]['value'] = $arg['value'];
        }
        $product->attributes()->sync($attribute, false);

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
