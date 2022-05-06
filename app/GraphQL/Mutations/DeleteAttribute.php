<?php

namespace App\GraphQL\Mutations;

use App\Models\Attribute;

final class DeleteAttribute
{
    /**
     * @param $_
     * @param array $args
     * @return Attribute|Attribute[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed|null
     */
    public function __invoke($_, array $args)
    {
        if($attribute = Attribute::find($args['id'])) {
            $attribute->delete();
        }

        return $attribute;
    }
}
