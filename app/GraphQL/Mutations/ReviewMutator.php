<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Doctrine\DBAL\Types\ObjectType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Rule;
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
            'description' => 'required|min:5|max:500',
            'product_id' => 'exists:products,id'
        ]);

        $product = Product::find($args['product_id']);

        $review = new Review();
        $review->user_id = auth()->user()->id;
        $review->description = $args['description'];
        $review->product()->associate($product);
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
            'id' => [ 'required', Rule::exists('reviews', 'id')->where(
                fn(Builder $query) => $query->where('user_id', auth()->user()->id)
            )],
            'description' => 'required|min:5|max:500',
            'product_id' => 'exists:products,id'
        ]);


        $review = Review::find($args['id']);
        $review->description = $args['description'];

            $review->save();

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
        $user_id = auth()->user()->id;
        $review = Review::where('user_id', $user_id)->where('id', $args['id'])->first();
            if($review){
                $review->delete();
                return true;
            }
            return false;
    }
}
