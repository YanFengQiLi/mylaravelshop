<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ProductsService extends Model
{

    protected $table = 'products_service';

    /**
     * @param string $column
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     * 获取商品服务列表
     */
    public function getProductServiceList(string $column = '*')
    {
        return self::query()->selectRaw($column)->get();
    }

}
