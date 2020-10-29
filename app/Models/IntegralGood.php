<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\IntegralGood
 *
 * @property int $id
 * @property string $title 商品名称
 * @property float $price 商品价格
 * @property int $on_sale 上架状态
 * @property string|null $thumb 商品封面图
 * @property string|null $pictures 商品轮播图
 * @property string $description 商品详情
 * @property int $type 兑换类型
 * @property float $money 兑换金额
 * @property int $number 兑换积分
 * @property int $stock 库存
 * @property int $is_limit 兑换限制
 * @property int $limit_number 限制数量
 * @property int $exchange_number 已兑换数量
 * @property int $sort 排序
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood whereExchangeNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood whereIsLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood whereLimitNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood whereOnSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood wherePictures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGood whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class IntegralGood extends Model
{

    protected $table = 'integral_goods';

    //  直接兑换
    const DISTINCT_EXCHANGE = 0;
    const MONEY_EXCHANGE = 1;

    //  兑换类型数组
    const TYPE = [
        self::DISTINCT_EXCHANGE => '直接兑换',
        self::MONEY_EXCHANGE => '积分换购',
    ];

    public function setPicturesAttribute($value)
    {
        $this->attributes['pictures'] = json_encode($value);
    }

    public function setMoneyAttribute($value)
    {
        $this->attributes['money'] = $value ?: 0.00;
    }
}
