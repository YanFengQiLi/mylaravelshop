<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Advert
 *
 * @property int $id
 * @property string $title 广告名称
 * @property int $type 广告类型
 * @property string $links 链接地址
 * @property int $status 状态 1-启用 0-禁用
 * @property string|null $image 图片地址
 * @property int $sort 排序
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Advert onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert status()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereLinks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Advert withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Advert withoutTrashed()
 * @mixin \Eloquent
 */
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
