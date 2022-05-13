<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Doctrine\DBAL\Types\ObjectType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Factory;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use phpDocumentor\Reflection\Types\Boolean;

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

        $product = Product::find($args['product_id']);
        $user = User::find($args['user_id']);

        $review = new Review();
        $review->description = $args['description'];
        $review->product()->associate($product);
        $review->user()->associate($user);
        $review->save();

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
     * @return bool
     */
    public function deleteReview(?ObjectType $objectType, array $args, GraphQLContext $context): bool
    {
        try {
            $review = Review::findOrFail($args['id']);
            return $review->delete();
        } catch (ModelNotFoundException){
            return false;
        }
    }
}
