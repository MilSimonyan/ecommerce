<?php

namespace App\GraphQL\Mutations;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Validation\Factory;

final class UpdateAttribute
{
    /**
     * @param null $_
     * @param array{} $args
     */

    protected Factory $validator;

    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    public function __invoke($_, array $args)
    {
        $this->validator->validate($args, [
            'name' => 'min:2',
            'type' => 'min:2',
        ]);

        if ($attribute = Attribute::find($args['id'])) {
            if (isset($args['name'])) {
                $attribute->name = $args['name'];
            }

            if (isset($args['type'])) {
                $attribute->name = $args['type'];
            }

            if ($product = Product::find(isset($args['products']))) {
                $attribute->products()->sync($product);
            }
            $attribute->save();
        }

        return $attribute;
    }
}
