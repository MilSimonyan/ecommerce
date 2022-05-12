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

    public function storeRate(?ObjectType $rootValue, array $args, GraphQLContext $context): float
    {
        $this->validator->validate($args, [
            'rate' => 'numeric|min:1|max:5'
        ]);
        $rate = new Rate();
        $rate->rate = $args['rate'];

        $user = User::find($args['user']);
        $product = Product::find($args['product']);

        $rate->user()->associate($user);
        $rate->product()->associate($product);

        $rate->save();
        $rateAvg = round(Rate::where('product_id', $args['product'])->get()->avg('rate'),1);

        return $rateAvg;
    }

    public function updateRate(?ObjectType $rootValue, array $args, GraphQLContext $context): Rate
    {
        $this->validator->validate($args, [
            'rate' => 'numeric|min:1|max:5'
        ]);
        if($rate = Rate::find($args['id']))
        {
            if(!empty($args['rate'])) {
                $rate->rate = $args['rate'];
            }
        }
        $rate->save();

        $rateAvg = round(Rate::where('product_id', $args['product'])->get()->avg('rate'),1);
        return $rate;
    }



    public function deleteRate(?ObjectType $rootValue, array $args, GraphQLContext $context): bool
    {
        if($rate = $this->rate->find($args['id'])){
            $rate->delete();
            return true;
        }

        return false;
    }
}
