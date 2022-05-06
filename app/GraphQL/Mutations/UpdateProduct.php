<?php

namespace App\GraphQL\Mutations;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Validation\Factory;

final class UpdateProduct
{
    /**
     * @var Factory
     */
    protected Factory $validation;

    /**
     * @param Factory $validation
     */
    public function __construct(Factory $validation)
    {
        $this->validation = $validation;
    }

    /**
     * @param $_
     * @param array $args
     * @return Product
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke($_, array $args): Product
    {
        if ($product = Product::find($args['id'])) {
            $this->validation->validate($args, [
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
        }

        return $product;
    }
}
