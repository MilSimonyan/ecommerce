<?php

namespace App\GraphQL\Queries;

use App\Models\Attribute;

final class Attributes
{
    /**
     * @param $_
     * @param array $args
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function __invoke($_, array $args)
    {
        return Attribute::all();
    }
}
