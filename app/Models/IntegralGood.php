<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

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
