<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * App\Models\CouponCode
 *
 * @property int $id
 * @property string $name 优惠券名称
 * @property string $code 优惠券码
 * @property string $type 券类型
 * @property string $value 折扣
 * @property int $total 券总量
 * @property int $used 券使用量
 * @property float $min_amount 最低使用金额
 * @property string|null $before_time 开始时间
 * @property string|null $after_time 结束时间
 * @property int $enable 是否启动 1-是 0-否
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $value_show
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereAfterTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereBeforeTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereMinAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereValue($value)
 * @mixin \Eloquent
 */
class CouponCode extends Model
{

    protected $table = 'coupon_codes';

    // 定义支持的优惠券类型
    const TYPE_FIXED = 'fixed';
    const TYPE_RATE = 'rate';

    // 定义优惠券的使用范围
    const USE_ALL = 'all';
    const USE_GRAND = 'grand';
    const USE_PARENT = 'parent';
    const USE_SON = 'son';


    //  券类型
    const COUPON_TYPE = [
        self::TYPE_FIXED => '固定金额',
        self::TYPE_RATE => '比例'
    ];

    //  优惠券使用范围
    const USE_TYPE = [
        self::USE_ALL => '全品类',
        self::USE_GRAND => '顶级类目商品',
        self::USE_PARENT => '二级类目',
        self::USE_SON => '指定商品'
    ];

    protected $appends = ['value_show'];

    //  生成优惠券码
    public static function findAndGenerateCouponCode($length = 16)
    {
        do {
            $code = strtoupper(Str::random($length));
        } while (self::query()->where('code', $code)->exists());

        return $code;
    }

    //  优惠信息描述
    public function getValueShowAttribute()
    {
        $str = '';

        if ($this->type == self::TYPE_FIXED){
            $str = '满' . $this->min_amount . '立减' .$this->value . '元';
        }

        if ($this->type == self::TYPE_RATE){
            $str = '满' .$this->min_amount . '尊享' . $this->value/10 . '折';
        }

        return $str;
    }
}
