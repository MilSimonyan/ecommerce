<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;
use App\Models\Rate;
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

    public function store(?ObjectType $rootValue, array $args, GraphQLContext $context): Rate
    {
        $this->validator->validate($args, [
            'rating' => 'numeric|min:1|max:5'
        ]);

        $rate = Product::find($args['product'])->rate();

        $count = $rate->value('count') ?: 0;
        $sum = $rate->value('sum') ?: 0;

        $rate->updateOrCreate(['product_id' => $args['product']], [
            'count' => ++$count,
            'sum' => $sum += $args['rating']
        ]);

        $rateModel = $this->rate->where('product_id', $args['product'])->first();
        $rateModel->rating = round($sum / $count, 1);
        return $rateModel;
    }

    public function destroy(?ObjectType $rootValue, array $args, GraphQLContext $context): bool
    {
        if($rate = $this->rate->find($args['id'])){
            $rate->delete();
            return true;
        }

        return false;
    }
}
