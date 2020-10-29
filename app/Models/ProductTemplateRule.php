<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductTemplateRule
 *
 * @property int $id
 * @property int $product_template_id 运费模板ID
 * @property string|null $city 城市json
 * @property int|null $default_num 默认数量
 * @property float|null $default_price 默认费用
 * @property int|null $add_num 新增数量
 * @property float $add_price 新增费用
 * @property string|null $extra 存储特殊扩展字段
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplateRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplateRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplateRule query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplateRule whereAddNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplateRule whereAddPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplateRule whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplateRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplateRule whereDefaultNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplateRule whereDefaultPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplateRule whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplateRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplateRule whereProductTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplateRule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductTemplateRule extends Model
{

    protected $table = 'product_template_rule';

    protected $fillable = [
        'product_template_id',
        'city',
        'default_num',
        'default_price',
        'add_num',
        'add_price',
        'extra'
    ];

    public function setCityAttribute($value)
    {
        if ($value && is_array($value)){
            $this->attributes['city'] = implode(',', $value);
        }else{
            $this->attributes['city'] = '';
        }
    }

}
