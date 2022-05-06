<?php

namespace App\GraphQL\Mutations;

use App\Models\Rate;
use Illuminate\Validation\Factory;

final class UpdateRate
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
     * @return Rate|Rate[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed|null
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke($_, array $args)
    {
        $this->validation->validate($args, [
            'rating' => 'min:1|max:5'
        ]);

        if ($rate = Rate::find($args['id'])) {
            $rate->update([
                'rating' => $args['rating']
            ]);
        }

        return $rate;
    }
}
