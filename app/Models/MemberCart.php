<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberCart extends Model
{
    protected $table = 'member_carts';

    protected $fillable = ['member_id', 'product_sku_id', 'number'];

    //  操作类型
    const TYPE = [
        'add',
        'sub'
    ];

    public function productSku()
    {
        return $this->belongsTo(ProductSku::class,'product_sku_id','id');
    }

    /**
     * @param $data
     * @return MemberCart|Model
     * 添加购物车商品
     */
    public function createMemberCart($data)
    {
        return self::create($data);
    }

    /**
     * @param array $where
     * @param int $number
     * @return int
     * 增加购物车商品数量
     */
    public function IncMemberCartNumber(array $where, int $number)
    {
        return self::query()->where($where)->increment('number', $number);
    }

    /**
     * @param array $where
     * @param int $number
     * @return int
     * 减少购物车商品数量
     */
    public function decMemberCartNumber(array $where, int $number)
    {
        return self::query()->where($where)->decrement('number', $number);
    }
}
