<?php

namespace App\GraphQL\Mutations;

use App\Models\Rate;

final class DeleteRate
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        if($rate = Rate::find($args['id'])) {
            $rate->delete();
        }

        return $rate;
    }
}
