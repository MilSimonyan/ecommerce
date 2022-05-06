<?php

namespace App\GraphQL\Mutations;


use App\Models\Product;
use App\Models\Rate;
use Illuminate\Validation\Factory;

final class CreateRate
{
    /**
     * @param null $_
     * @param array{} $args
     */

    protected Factory $validation;

    public function __construct(Factory $validation)
    {
        $this->validation = $validation;
    }

    public function __invoke($_, array $args): Rate
    {
        $this->validation->validate($args, [
            'rating' => 'min:1|max:5'
        ]);

        $rate = Product::find($args['product'])->rate();
        $count = $rate->value('count') ?: 0;
        $sum = $rate->value('sum') ?: 0;
        $rate->updateOrCreate(['product_id' => $args['product']], [
            'count' => ++$count,
            'sum' => $sum += $args['rating']
        ]);
        $rateModel = Rate::where('product_id', $args['product'])->first();
        $rateModel->rating = round($sum / $count, 1);
        return $rateModel;

    }
}
