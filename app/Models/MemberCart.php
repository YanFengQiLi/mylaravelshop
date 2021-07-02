<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MemberCart
 *
 * @property int $id
 * @property int $member_id 用户ID
 * @property int $product_sku_id 商品skuID
 * @property int $number 数量
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProductSku $productSku
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCart query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCart whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCart whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCart whereProductSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCart whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
