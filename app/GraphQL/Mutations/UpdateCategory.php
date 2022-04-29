<?php

namespace App\GraphQL\Mutations;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Validation\Factory;

final class UpdateCategory
{

    protected $validation;
    public function __construct(
        Factory $validation
    ){
        $this->validation = $validation;
    }
    /**
     * @param  null  $_
     * @param  array{}  $args
     */

    public function __invoke($_, array $args)
    {
        $this->validation->validate($args, [
            'name' => 'min:3|max:50',
            'description' => 'min:10',
        ]);
        if( $category = Category::find($args['id'])) {
            if(isset($args['name'])) {
                $category->name = $args['name'];
            }
            if(isset($args['description'])) {
                $category->name = $args['description'];
            }
            if($product = Product::find(isset($args['products']))) {
                $category->products()->attach($product);
            }

            $category->save();
        }



        return $category;
    }
}
