<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;
use App\Models\Rate;
use App\Models\User;
use App\Repositories\RateRepository;
use GraphQL\Type\Definition\ObjectType;
use Illuminate\Validation\Factory;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class RateMutator
{
    /**
     * @var RateRepository
     */
    protected RateRepository $rateRepository;

    /**
     * @var Factory
     */
    protected Factory $validator;

    /**
     * @param Factory $validator
     * @param RateRepository $rateRepository
     */
    public function __construct(Factory $validator, RateRepository $rateRepository)
    {
        $this->validator = $validator;
        $this->rateRepository = $rateRepository;
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
            'user_id' => 'required|exists:users,id',
        ]);
        $rate = $this->rateRepository->model();
        $rate->rate = $args['rate'];

        $user = User::find($args['user_id']);
        $product = Product::find($args['product_id']);

        $rate->user()->associate($user);
        $rate->product()->associate($product);

        $rate->save();
        $rate->rating = round($rate->where('product_id', $args['product_id'])->get()->avg('rate'), 1);

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
            'user_id' => '|exists:users,id',
        ]);

        $rate = $this->rateRepository;

        $rate = $rate->where('user_id', $args['user_id'])->where('product_id', $args['product_id'])->first();
        $rate->rate = $args['rate'];
        $rate->save();

        $rate->rating = round($rate->where('product_id', $args['product_id'])->get()->avg('rate'), 1);

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
        if ($rate = $this->rateRepository->find($args['id'])) {
            $rate->delete();
            return true;
        }

        return false;
    }
}
