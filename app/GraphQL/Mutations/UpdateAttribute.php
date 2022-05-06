<?php

namespace App\GraphQL\Mutations;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Validation\Factory;

final class UpdateAttribute
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
     * @return Attribute|Attribute[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed|null
     * @throws \Illuminate\Validation\ValidationException
     */
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

            if ($product = Product::find($args['products'])) {
                $attribute->products()->sync($product);
            }

            $attribute->save();
        }

        return $attribute;
    }
}
