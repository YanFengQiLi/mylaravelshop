<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Website
 *
 * @property int $id
 * @property string $key_name 配置标识
 * @property string|null $key_value 标识值
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Website newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Website newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Website query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Website whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Website whereKeyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Website whereKeyValue($value)
 * @mixin \Eloquent
 */
class Website extends Model
{
    protected $table = 'website';

    public $timestamps = false;

    protected $fillable = ['key_name', 'key_value'];

    /**
     * @return array
     * 获取全部配置
     * @author zhenhong~
     */
    public static function getWebSiteConfig()
    {
       return self::all()->pluck('key_value', 'key_name')->toArray();
    }

    /**
     * @param string $key
     * @return mixed
     * 获取单个配置
     * @author zhenhong~
     */
    public static function getOnlyWebSiteConfig(string $key)
    {
        return self::query()->where('key_name', $key)->value('key_value');
    }

    /**
     * @param mixed ...$params
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     * 获取多个配置
     * @author zhenhong~
     */
    public static function getMoreWebSiteConfig(...$params)
    {
        return self::query()->whereIn('key_name', $params)->pluck('key_value', 'key_name')->toArray();
    }

    /**
     * @return string
     * 获取下单送积分规则描述
     * @author zhenhong~
     */
    public static function getWebSiteConsumeIntegralDesc()
    {
        $arr = self::getWebSiteConfig();

        $desc = $arr['consume_integral_sign'] == '0' ? '获得(' . $arr['consume_integral']. ')个固定积分' : '获得实际下单支付金额的(' . $arr['consume_integral_percent']. '%)';

        $array = [
            0 => '固定积分',
            1 => '按实际下单金额的百分比四舍五入'
        ];

        return '当前商城设置的下单送积分规则为 : ' . $array[$arr['consume_integral_sign']] . ', ' . $desc;
    }

}
