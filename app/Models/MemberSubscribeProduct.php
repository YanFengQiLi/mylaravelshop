<?php

namespace App\Models;

use App\Events\AttentionProductLowerPrice;
use App\Events\RestoreAttentionProductLowerPrice;
use App\Events\UnAttentionProductLowerPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberSubscribeProduct extends Model
{
    use SoftDeletes;

    protected $table = 'member_subscribe_product';

    protected $fillable = ['member_id', 'product_id'];

    protected $dispatchesEvents = [
        'created' => AttentionProductLowerPrice::class,
        'deleted'  => UnAttentionProductLowerPrice::class,
        'restored' => RestoreAttentionProductLowerPrice::class
    ];

    /**
     * @param array $data
     * @return MemberSubscribeProduct|Model
     * 订阅商品商品降价通知
     */
    public function insertMemberSubscribeProduct(array $data)
    {
        return self::create($data);
    }

    /**
     * @param $memberId
     * @param $productId
     * @return bool|mixed|null
     * @throws \Exception
     * 取消订阅商品降价通知
     */
    public function deleteMemberSubscribeProduct($memberId, $productId)
    {
        //  特别注意： 因为直接删除，不会触发 ORM 的 deleted 和 deleting 生命周期节点，有且仅有`检索了模型实例的操作才会被触发`
        $model = $this->findMemberSubscribeProduct(['member_id' => $memberId, 'product_id' => $productId]);

        return $model->delete();
    }

    /**
     * @param $where    - 查询条件
     * @param $idDelete - 是否包含已删除的
     * @return bool
     * 校验是否订阅过该商品
     */
    public function checkMemberSubscribeProductIsExist(array $where, $idDelete = false)
    {
        $model = $idDelete ? self::withTrashed() : self::query();

        return $model->where($where)->exists();
    }

    /**
     * @param array $where  - 查询条件
     * @return bool|null
     * 恢复订阅
     */
    public function restoreMemberSubscribeProduct(array $where)
    {
        $model = self::onlyTrashed()->where($where)->first();

        return $model->restore();
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     * 查询一条商品订阅
     */
    public function findMemberSubscribeProduct(array $where)
    {
        return self::query()->where($where)->first();
    }
}
