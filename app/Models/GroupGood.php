<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GroupGood
 *
 * @property int $id
 * @property string $title 商品标题
 * @property string|null $thumb 商品封面图
 * @property string|null $images 商品轮播图
 * @property string $description 商品描述
 * @property float $old_price 原价
 * @property float $group_price 拼团价
 * @property int $stock 库存
 * @property int $group_number 成团人数设置
 * @property int $on_sale 上架状态
 * @property int $sale_number 销量
 * @property int $open_group_number 已开团数量
 * @property string $end_time 拼团截止日期
 * @property int $is_auto 自动成团
 * @property int $auto_hour 自动成团时间,以小时为单位
 * @property int $sort 数值越大展示越靠前
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood whereAutoHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood whereGroupNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood whereGroupPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood whereIsAuto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood whereOldPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood whereOnSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood whereOpenGroupNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood whereSaleNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupGood whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GroupGood extends Model
{

    protected $table = 'group_goods';

    public function getImagesAttribute($value)
    {
        return json_decode($value, true);
    }

}
