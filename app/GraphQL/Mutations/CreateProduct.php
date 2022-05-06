<?php

namespace App\GraphQL\Mutations;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Validation\Factory;

final class CreateProduct
{
    /**
     * @var Factory
     */
    public Factory $validation;

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
        $this->validation->validate($args, [
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
            $count = count($args['value']);

            for ($i = 0; $i < $count; $i++) {
                $attributes[$args['attributes'][$i]]['value'] = $args['value'][$i];
            }

            $product->attributes()->sync($attributes);
        }

        return $product;
    }
}
