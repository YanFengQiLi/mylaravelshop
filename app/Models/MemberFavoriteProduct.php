<?php

namespace App\Models;

use App\Events\AttentionProductLowerPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MemberFavoriteProduct
 *
 * @property int $id
 * @property int $member_id 用户ID
 * @property int $product_id 产品ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberFavoriteProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberFavoriteProduct newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberFavoriteProduct onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberFavoriteProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberFavoriteProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberFavoriteProduct whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberFavoriteProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberFavoriteProduct whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberFavoriteProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberFavoriteProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberFavoriteProduct withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberFavoriteProduct withoutTrashed()
 * @mixin \Eloquent
 */
class MemberFavoriteProduct extends Model
{
    use SoftDeletes;

    protected $table = 'member_favorite_products';

    protected $fillable = ['member_id', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id','id');
    }

    protected $dispatchesEvents = [
        'created' => AttentionProductLowerPrice::class
    ];

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
     * @param $memberId
     * @param $ids
     * @return int
     * 移除商品收藏（关注）
     */
    public function deleteMemberFavoriteProduct($memberId, array $ids)
    {
        return self::query()->where('member_id', $memberId)->whereIn('product_id', $ids)->delete();
    }

    /**
     * @param $where    - 查询条件
     * @param $idDelete - 是否包含已删除的
     * @return bool
     * 校验是否已收藏（关注）过该商品
     */
    public function checkMemberFavoriteProductIsExist(array $where, $idDelete = false)
    {
        $model = $idDelete ? self::withTrashed() : self::query();

        return $model->where($where)->exists();
    }

    /**
     * @param $memberId - 用户ID
     * @param $limit    - 分页条数
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * 用户收藏（关注）列表
     */
    public function selectMemberFavoriteProductList($memberId, $limit)
    {
        return self::query()->with('product:id,title,image,price')
            ->where('member_id', $memberId)
            ->select(['id', 'product_id'])
            ->paginate($limit);
    }

    /**
     * @param array $where  - 查询条件
     * @return bool|null
     * 恢复删除的一条关注
     */
    public function restoreMemberFavoriteProduct(array $where)
    {
        $model = self::onlyTrashed()->where($where)->first();

        return $model->restore();
    }

}
