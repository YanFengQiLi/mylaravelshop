<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ProductsService extends Model
{

    protected $table = 'products_service';

    /**
     * @param string $column
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     * @author zhenhong~
     * 获取启用的商品服务列表
     */
    public function getProductServiceList(string $column = '*')
    {
        return self::query()->selectRaw($column)->where('status', 1)->get();
    }

    /**
     * @param mixed ...$params
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     * @author zhenhong~
     * 根据Ids获取商品服务列表
     */
    public function getProductServiceByIds(...$params)
    {
        return self::query()->whereIn('id', $params)->where('status', 1)->get(['id', 'icon', 'title', 'content']);
    }

}
