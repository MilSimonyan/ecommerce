<?php

namespace App\GraphQL\Mutations;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Validation\Factory;

final class CreateProduct
{
    public $validation;

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

        if ($category = Category::find(isset($args['categories']))) {
            $product->categories()->sync($category);
        }

        if ($attribute = Attribute::find(isset($args['attributes']))) {
            $product->attributes()->sync($attribute);
        }

        return $product;
    }
}
