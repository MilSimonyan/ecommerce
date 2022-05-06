<?php

namespace App\GraphQL\Mutations;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Validation\Factory;

final class CreateAttribute
{
    /**
     * @var Factory
     */
    protected Factory $validator;

    /**
     * @param Factory $validator
     */
    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param $_
     * @param array $args
     * @return Attribute|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke($_, array $args)
    {
        $this->validator->validate($args, [
            'name' => 'required|min:2|max:30'
        ]);

        $attribute = Attribute::create([
            'name' => $args['name']
        ]);

        if (isset($args['products']) && $product = Product::find($args['products'])) {
            $attribute->products()->sync($product);
        }

        return $attribute;
    }
}
