<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderGood
 *
 * @property int $order_id
 * @property int $good_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGood newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGood newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGood query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGood whereGoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGood whereOrderId($value)
 * @mixin \Eloquent
 * @property int $id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Good $good
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGood whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGood whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGood whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGood whereUpdatedAt($value)
 */
class OrderGood extends Model
{
    protected $fillable = [
        'order_id',
        'good_id',
        'quantity',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|Good
     */
    public function good()
    {
        return $this->hasOne(Good::class, 'id', 'good_id');
    }
}
