<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{

    use SoftDeletes;

    protected $table = 'advert';

    //  首页头部轮播
    const HEAD_SCROLL = 1;
    //  首页中间活动位广告
    const MID = 2;

    const TYPE = [
        self::HEAD_SCROLL => '首页头部轮播',
        self::MID => '首页中间活动位广告',
    ];

    public function getImageAttribute($value)
    {
        return env('APP_URL') .'uploads/'. $value;
    }

    /**
     * 只查询启用的
     * @param $query
     * @return mixed
     */
    public function scopeStatus($query)
    {
        return $query->where('status', 1);
    }

    public function getAdvertList(array $where = [])
    {
        return self::query()->status()->where($where)->orderBy('sort', 'ASC')->get([
            'id', 'title', 'type', 'links', 'image'
        ]);
    }
}
