<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CouponCode extends Model
{

    protected $table = 'coupon_codes';

    // 用常量的方式定义支持的优惠券类型
    const TYPE_FIXED = 'fixed';
    const TYPE_RATE = 'rate';

    //  券类型
    const COUPON_TYPE = [
        self::TYPE_FIXED => '固定金额',
        self::TYPE_RATE => '比例'
    ];

    //  生成优惠券码
    public static function findAndGenerateCouponCode($length = 16)
    {
        do {
            $code = strtoupper(Str::random($length));
        } while (self::query()->where('code', $code)->exists());

        return $code;
    }
}
