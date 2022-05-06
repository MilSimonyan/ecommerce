<?php

namespace App\GraphQL\Mutations;

use App\Models\Review;

final class DeleteReview
{
    /**
     * @param $_
     * @param array $args
     * @return Review|Review[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed|null
     */
    public function __invoke($_, array $args)
    {
        if ($review = Review::find($args['id'])) {
            $review->delete();
        }

        return $review;
    }
}
