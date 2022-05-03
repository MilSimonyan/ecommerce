<?php

namespace App\GraphQL\Mutations;

use App\Models\Attribute;
use App\Models\Attribute_Product;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
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

        if (isset($args['categories']) && $category = Category::find($args['categories'])) {
            $product->categories()->sync($category);
        }

        if (isset($args['attributes']) && $attribute = Attribute::whereIn('id',$args['attributes'])->get()) {
            $product->attributes()->sync($attribute);
        }

        return $product;
    }
}
