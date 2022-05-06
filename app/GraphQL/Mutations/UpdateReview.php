<?php

namespace App\GraphQL\Mutations;

use App\Models\Review;
use Illuminate\Validation\Factory;

final class UpdateReview
{
    /**
     * @var Factory
     */
    protected Factory $validation;

    /**
     * @param Factory $validation
     */
    public function __construct(Factory $validation)
    {
        $this->validation = $validation;
    }

    /**
     * @param $_
     * @param array $args
     * @return Review|Review[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed|null
     * @throws \Illuminate\Validation\ValidationException
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
