<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductsService
 *
 * @property int $id
 * @property string $icon 小图标
 * @property string $title 服务名称
 * @property string $content 描述
 * @property int $status 0-禁用 1-启用
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductsService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductsService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductsService query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductsService whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductsService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductsService whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductsService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductsService whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductsService whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductsService whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
