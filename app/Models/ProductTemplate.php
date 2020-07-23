<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ProductTemplate extends Model
{

    protected $table = 'product_template';

    //  任何地区包邮
    const FREE = 0;
    //  除特殊地区,包邮
    const SPECIAL_FREE = 1;
    //  按地区,按件计费
    const PIECES = 2;
    //  按地区,按重量计费
    const WEIGHT = 3;
    //  固定邮费
    const FIXED = 4;
    //  购买满 X 金额包邮
    const MONEY = 5;

    //  邮费规则数组
    const RULES = [
        self::FREE => '任何地区包邮',
        self::SPECIAL_FREE => '除特殊地区外包邮',
        self::PIECES => '按地区,按件计费',
        self::WEIGHT => '按地区,按重量计费',
        self::FIXED => '固定邮费',
        self::MONEY => '购买满X金额包邮'
    ];

}
