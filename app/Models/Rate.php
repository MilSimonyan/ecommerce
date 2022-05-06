<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property int $count
 * @property int $sum
 * @property-read \App\Models\Product|null $products
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereSum($value)
 */
class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'count',
        'sum',
        'rating'
    ];

    public function products(): BelongsTo
    {
        return $this->BelongsTo(Product::class);
    }
}
