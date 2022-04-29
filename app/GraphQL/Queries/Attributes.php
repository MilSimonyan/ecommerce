<?php

namespace App\GraphQL\Queries;

use App\Models\Attribute;

final class Attributes
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        return Attribute::all();
    }
}
