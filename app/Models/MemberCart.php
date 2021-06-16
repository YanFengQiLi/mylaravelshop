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
    public function incMemberCartNumber(array $where, int $number)
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

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     * 获取一条购物车信息
     */
    public function getMemberCartInfo(array $where)
    {
        return self::query()->with('productSku', 'productSku.product')->where($where)->first();
    }

    /**
     * @param $memberId
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * 获取用户购物车列表
     */
    public function selectMemberCartList($memberId, $limit = 10)
    {
        return self::query()->select('id', 'product_sku_id', 'number')->with([
            'productSku' => function ($query) {
                $query->select('id', 'title', 'price', 'img', 'product_id');
            },
            'productSku.product' => function($query) {
                $query->select('id', 'title AS product_name');
            }
        ])->where('member_id', $memberId)->paginate($limit);
    }
}
