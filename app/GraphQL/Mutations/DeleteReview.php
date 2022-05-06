<?php

namespace App\GraphQL\Mutations;

use App\Models\Review;

final class DeleteReview
{
    /**
     * @param null $_
     * @param array{} $args
     */
    public function __invoke($_, array $args)
    {
        if ($review = Review::find($args['id'])) {
            $review->delete();
        }

        return $review;
    }
}
