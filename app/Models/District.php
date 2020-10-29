<?php

namespace App\Models;

use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\District
 *
 * @property int $id 编号
 * @property int $pid 上级编号
 * @property int $deep 层级
 * @property string $name 名称
 * @property string|null $pinyin 拼音
 * @property string|null $pinyin_short 拼音缩写
 * @property string|null $ext_name 扩展名
 * @property string|null $create_time 创建时间
 * @property string|null $update_time 更新时间
 * @property string|null $operator 操作人
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\District[] $children
 * @property-read int|null $children_count
 * @property-read \App\Models\District $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereDeep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereExtName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereOperator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District wherePinyin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District wherePinyinShort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereUpdateTime($value)
 * @mixin \Eloquent
 */
class District extends Model
{
    use ModelTree;

    public $timestamps = false;

    /**
     * 父ID字段名称
     *
     * @return string
     */
    public function getParentColumn()
    {
        return 'pid';
    }

    /**
     * 标题字段名称
     *
     * @return string
     */
    public function getTitleColumn()
    {
        return 'ext_name';
    }

    //  禁用 order 字段
    public function getOrderColumn()
    {
        return null;
    }

    //  自定义节点数据
    public function allNodes()
    {
        return self::query()->get([
            'id', 'ext_name AS title', 'pid AS parent_id', 'deep'
        ])->toArray();
    }


    /**
     * 获取省份数据
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getProvinceList()
    {
        return self::query()->where('pid', 0)->get(['id','pid AS parent_id','ext_name AS name'])->toArray();
    }
}
