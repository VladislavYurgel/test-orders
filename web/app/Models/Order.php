<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $user_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Good[] $goods
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereGoodId($id)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order active()
 * @property float $amount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereAmount($value)
 */
class Order extends Model
{
    const STATUS_CREATED = 1;
    const STATUS_PROCESSED = 2;
    const STATUS_COURIER = 3;
    const STATUS_COMPLETED = 4;
    const STATUS_CANCELED = 5;

    protected $fillable = [
        'user_id',
        'status',
        'amount',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|Good[]|Collection
     */
    public function goods()
    {
        return $this->belongsToMany(Good::class, 'order_goods');
    }

    /**
     * @param Builder $query
     * @param $id
     * @return Builder
     */
    public function scopeWhereGoodId(Builder $query, $id)
    {
        return $query->whereHas('goods', function (Builder $query) use ($id) {
            $query->where('goods.id', $id);
        });
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('status', '<>', static::STATUS_COMPLETED);
    }
}
