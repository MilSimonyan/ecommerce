<?php

namespace App\GraphQL\Mutations;

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
            $product->update([
                'name' => $args['name'],
                'description' => $args['description']
            ]);
        }
        return $product;
    }
}
