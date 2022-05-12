<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereUserId($value)
 * @property int $rate
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereRate($value)
 * @property-read \App\Models\Product $product
 */
class Rate extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'rate',
        'user_id',
        'product_id',
        'rating',
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
