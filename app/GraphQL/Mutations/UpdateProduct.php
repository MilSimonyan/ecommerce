<?php

namespace App\GraphQL\Mutations;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Validation\Factory;

final class UpdateProduct
{
    protected $validation;
    public function __construct(Factory $validation)
    {
        $this->validation = $validation;
    }

    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args): Product
    {
        if($product = Product::find($args['id'])){
            $this->validation->validate($args, [
                'name' => 'min:3|max:50',
                'description' => 'min:10',
            ]);
            if (isset($args['name'])){
                $product->name = $args['name'];
            }
            if (isset($args['name'])){
                $product->description = $args['description'];
            }
            if($category = Category::find(isset($args['categories']))) {
                $product->categories()->attach($category);
            }
            if($attribute = Attribute::find(isset($args['attributes']))) {
                $product->attributes()->attach($attribute);
            }
            $product->save();
        }

        return $product;
    }
}
