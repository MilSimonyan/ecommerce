<?php

namespace App\GraphQL\Mutations;

use App\Models\Attribute;

final class DeleteAttribute
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        if($attribute = Attribute::find($args['id'])) {
            $attribute->delete();
        }

        return $attribute;
    }
}
