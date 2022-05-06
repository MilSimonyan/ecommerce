<?php

namespace App\GraphQL\Mutations;

use App\Models\Review;
use Illuminate\Validation\Factory;

final class UpdateReview
{
    protected $validation;

    public function __construct(Factory $validation)
    {
        $this->validation = $validation;
    }

    /**
     * @param null $_
     * @param array{} $args
     */
    public function __invoke($_, array $args)
    {
        $this->validation->validate($args, [
            'description' => 'min:5|max:500'
        ]);

        if ($review = Review::find($args['id'])) {
            if (!empty($args['description'])) {
                $review->update([
                    'description' => $args['description']
                ]);
            } else {
                $review->delete();
            }
        }
        return $review;
    }
}
