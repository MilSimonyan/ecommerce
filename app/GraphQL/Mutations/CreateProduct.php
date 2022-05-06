<?php

namespace App\GraphQL\Mutations;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Factory;

final class CreateProduct
{
    public Factory $validation;

    public function __construct(Factory $validation)
    {
        $this->validation = $validation;
    }

    /**
     * @param null $_
     * @param array{} $args
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
