<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CouponCode extends Model
{

    protected $table = 'coupon_codes';

    //  券类型
    const TYPE = [
        'fixed' =>  '固定金额',
        'rate'  =>  '比例'
    ];
}
