<?php

namespace App\Models;

use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

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
