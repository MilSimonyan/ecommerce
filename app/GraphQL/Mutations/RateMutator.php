<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;
use App\Models\Rate;
use App\Models\User;
use GraphQL\Type\Definition\ObjectType;
use Illuminate\Validation\Factory;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class RateMutator
{
    /**
     * @var Rate
     */
    protected Rate $rate;

    /**
     * @var Factory
     */
    protected Factory $validator;

    /**
     * @param Factory $validator
     * @param Rate $rate
     */
    public function __construct(Factory $validator, Rate $rate)
    {
        $this->validator = $validator;
        $this->rate = $rate;
    }

    /**
     * @param ObjectType|null $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @return Rate
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeRate(?ObjectType $rootValue, array $args, GraphQLContext $context): Rate
    {
        $this->validator->validate($args, [
            'rate' => 'numeric|min:1|max:5',
            'product_id' => 'required|exists:products,id',
            'user_id' => 'exists:users,id',
        ]);
        $rate = new Rate();
        $rate->user_id = auth()->user()->id;
        $rate->rate = $args['rate'];

        $product = Product::find($args['product_id']);
        $rate->product()->associate($product);

        $rate->save();
        $rate->rating = round(Rate::where('product_id', $args['product_id'])->get()->avg('rate'), 1);

        return $rate;
    }

    /**
     * @param ObjectType|null $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @return Rate
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateRate(?ObjectType $rootValue, array $args, GraphQLContext $context): Rate
    {
        $this->validator->validate($args, [
            'rate' => 'numeric|min:1|max:5',
            'product_id' => 'exists:products,id',
            'user_id' => 'exists:users,id',
        ]);

        $user_id  = auth()->user()->id;
        $rate = Rate::where('user_id', $user_id)->where('product_id', $args['product_id'])->first();
//        dd($rate);
        $rate->rate = $args['rate'];
        $rate->save();

        $rate->rating = round(Rate::where('product_id', $args['product_id'])->get()->avg('rate'), 1);

        return $rate;
    }

    /**
     * @param ObjectType|null $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @return bool
     */
    public function deleteRate(?ObjectType $rootValue, array $args, GraphQLContext $context): bool
    {
        $user_id = auth()->user()->id;
        $rate = Rate::where('product_id', $args['product_id'])->where('user_id', $user_id)->first();
        if($rate){{
                $rate->delete();
                return true;
            }
        }
        return false;
    }
}
