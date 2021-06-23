<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberFavoriteProduct extends Model
{
    use SoftDeletes;

    protected $table = 'member_favorite_products';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id','id');
    }

    /**
     * @param array $data
     * @return MemberFavoriteProduct|Model
     * 创建商品收藏（关注）
     */
    public function insertMemberFavoriteProduct(array $data)
    {
        return self::create($data);
    }

    /**
     * @param $ids
     * @return int
     * 移除商品收藏（关注）
     */
    public function deleteMemberFavoriteProduct(...$ids)
    {
        return self::destroy($ids);
    }

    /**
     * @param $id       - ID
     * @param $idDelete - 是否包含已删除的
     * @return bool
     * 校验是否已收藏（关注）过该商品
     */
    public function checkMemberFavoriteProductIsExist($id, $idDelete = false)
    {
        $model = $idDelete ? self::query() : self::withTrashed();

        return $model->where('id', $id)->exists();
    }

    /**
     * @param $memberId
     * @param $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * 用户收藏（关注）列表
     */
    public function selectMemberFavoriteProductList($memberId, $limit)
    {
        return self::query()->with('product:id,title,image,price')
            ->select(['id', 'product_id'])
            ->paginate($limit);
    }

}
