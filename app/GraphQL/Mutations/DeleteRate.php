<?php

namespace App\GraphQL\Mutations;

use App\Models\Rate;

final class DeleteRate
{
    /**
     * @param $_
     * @param array $args
     * @return Rate|Rate[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed|null
     */
    public function __invoke($_, array $args)
    {
        if($rate = Rate::find($args['id'])) {
            $rate->delete();
        }

        return $rate;
    }
}
