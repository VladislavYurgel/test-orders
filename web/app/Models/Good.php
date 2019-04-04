<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Good
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Good extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
    ];
}
