<?php

namespace App\GraphQL\Mutations;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Validation\Factory;

final class CreateAttribute
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
            'name' => 'required|min:2|max:30',
            'type' => 'required|min:2|max:30',
        ]);

        $attribute = Attribute::create([
            'name' => $args['name'],
            'type' => $args['type'],
        ]);

        if (isset($args['products']) && $product = Product::find($args['products'])) {
            $attribute->products()->sync($product);
        }

        return $attribute;
    }
}
