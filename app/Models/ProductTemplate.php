<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

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
