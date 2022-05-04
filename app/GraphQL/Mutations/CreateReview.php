<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Validation\Factory;

final class CreateReview
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
    public function __invoke($_, array $args)
    {
        $this->validation->validate($args, [
            'description' => 'min:5|max:500'
        ]);

        if (isset($args['product']) && $product = Product::find($args['product'])) {
            $review = Review::create([
                'description' => $args['description'],
                'product_id' => $args['product']
            ]);
            return $review;
        }
    }
}
