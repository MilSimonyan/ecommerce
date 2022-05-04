<?php

namespace App\GraphQL\Mutations;


use App\Models\Product;
use App\Models\Rate;
use Illuminate\Validation\Factory;

final class CreateRate
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */

    protected Factory $validation;

    public function __construct(Factory $validation)
    {
        $this->validation = $validation;
    }

    public function __invoke($_, array $args)
    {
        $this->validation->validate($args, [
            'rating' => 'min:1|max:5'
        ]);

        if(isset($args['product']) && $product = Product::find($args['product'])){
            $rate = $product->rates()->create([
                'rating' => $args['rating']
            ]);

            return $rate;
        }
    }
}
