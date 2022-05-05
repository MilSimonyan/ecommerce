<?php

namespace App\GraphQL\Mutations;

use App\Models\Rate;
use Illuminate\Validation\Factory;

final class UpdateRate
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

        if($rate = Rate::find($args['id'])){
            if(isset($args['rating'])){
                $rate->rating = $args['rating'];
            }

            $rate->save();
        }

        return $rate;
    }
}
