<?php

namespace App\GraphQL\Queries;

use App\Models\Rate as ModelRate;

final class Rate
{
    /**
     * @param $_
     * @param array $args
     * @return float
     */
    public function getAvg($_, array $args): float
    {
        return round(ModelRate::where('product_id', $args['product_id'])->get()->avg('rating'),1);
    }

    /**
     * @param $_
     * @param array $args
     * @return int
     */
    public function getCount($_, array $args):int
    {
        return ModelRate::where('product_id', $args['product_id'])->where('rating',$args['rating'])->get()->count();
    }
}
