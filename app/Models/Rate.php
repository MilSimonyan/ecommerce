<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Rate
 *
 * @property int $id
 * @property string $rating
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Rate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rate query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating'
    ];
}
