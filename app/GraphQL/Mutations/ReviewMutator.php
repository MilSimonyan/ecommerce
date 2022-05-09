<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;
use App\Models\Review;
use Doctrine\DBAL\Types\ObjectType;
use Illuminate\Validation\Factory;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class ReviewMutator
{
    /**
     * @var Factory
     */
    protected Factory $validator;

    /**
     * @param Factory $validator
     */
    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param ObjectType|null $objectType
     * @param array $args
     * @param GraphQLContext $context
     * @return Review
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeReview(?ObjectType $objectType, array $args, GraphQLContext $context): Review
    {
        $this->validator->validate($args, [
            'description' => 'required|min:5|max:500'
        ]);

        if ($product = Product::find($args['product'])) {
            $review = new Review();
            $review->description = $args['description'];
            $review->product_id = $args['product'];

            $review->save();
        }

        return $review;
    }

    /**
     * @param ObjectType|null $objectType
     * @param array $args
     * @param GraphQLContext $context
     * @return Review
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateReview(?ObjectType $objectType, array $args, GraphQLContext $context): Review
    {
        $this->validator->validate($args, [
            'description' => 'min:5|max:500'
        ]);

        if ($review = Review::find($args['id'])) {
            if (isset($args['description'])) {
                $review->description = $args['description'];
            }

            $review->save();
        }

        return $review;
    }

    /**
     * @param ObjectType|null $objectType
     * @param array $args
     * @param GraphQLContext $context
     * @return Review
     */
    public function deleteReview(?ObjectType $objectType, array $args, GraphQLContext $context): Review
    {
        if ($review = Review::find($args['id'])) {
            $review->delete();
        }

        return $review;
    }
}
