<?php

namespace App\GraphQL\Mutations;

use App\Models\Attribute;
use App\Models\Product;

final class CreateAttribute
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $attribute = Attribute::create([
            'name' => $args['name'],
            'type' => $args['type'],
        ]);

        if($product= Product::find(isset($args['products']))) {
            $attribute->products()->attach($product);
        }

        return $attribute;
    }
}
