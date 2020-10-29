<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductTemplate
 *
 * @property int $id
 * @property string $title 模板名称
 * @property int $type 类型
 * @property int|null $status 状态 1-启用 0-禁用
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProductTemplateRule|null $templateRule
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplate whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplate whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplate whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTemplate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductTemplate extends Model
{

    protected $table = 'product_template';

    protected $fillable = ['title', 'type', 'status'];

    //  任何地区包邮
    const FREE = 0;
    //  除特殊地区,包邮
    const SPECIAL_FREE = 1;
    //  按地区,按件计费
    const UNIT = 2;
    //  按地区,固定邮费
    const FIXED = 3;
    //  消费N元包邮, 除特殊地区外
    const MONEY = 4;

    //  邮费规则数组
    const RULES = [
        self::FREE => '任何地区包邮',
        self::SPECIAL_FREE => '除特殊地区外包邮',
        self::UNIT => '按地区,按单位计费',
        self::FIXED => '按地区,固定邮费',
        self::MONEY => '消费N元包邮,除特殊地区外'
    ];

    public function templateRule()
    {
        return $this->hasOne(ProductTemplateRule::class,'product_template_id','id');
    }

}
